<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');


function getToken($length){
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

   for ($i=0; $i < $length; $i++) {
       $token .= $codeAlphabet[rand(0, $max-1)];
   }

   return $token;
}


function checkUserCredentials($conn,$iduser,$username,$token){
    $q=$conn->query("SELECT token,username FROM user WHERE id_user=$iduser")->fetch_assoc();
        if($q["token"]==$token && $q["username"]==$username){
            return true;
        }
        else{
            return false;
        }
}


if(isset($_POST)){
    
    $context=json_decode($_POST["params"]);

    if($context->aksi=="cekUangDigital"){
        include "../koneksi.php";
        $iduser=mysqli_real_escape_string($conn,$context->data->id_user);
        $username=mysqli_real_escape_string($conn,$context->data->username);
        $token=mysqli_real_escape_string($conn,$context->data->token);

        if(checkUserCredentials($conn,$iduser,$username,$token)==true){
            $satu=0;
            $dua=0;

            $plus=$conn->query("SELECT emoney.id_user,emoney.prefix,SUM(emoney.jumlah) AS plus FROM emoney WHERE id_user=$iduser AND prefix='+' GROUP BY emoney.prefix,emoney.id_user;");
            $minus=$conn->query("SELECT emoney.id_user,emoney.prefix,SUM(emoney.jumlah) AS minus FROM emoney WHERE id_user=$iduser AND prefix='-' GROUP BY emoney.prefix,emoney.id_user;");

            if($plus->num_rows>0){
                $f=$plus->fetch_assoc();
                $satu=$f["plus"];
            }
            if($minus->num_rows>0){
                $f=$minus->fetch_assoc();
                $dua=$f["minus"];
            }

            $total=(int)$satu-(int)$dua;
            echo json_encode(array("status"=>"success","jumlah"=>$total));
        }
        else{
            echo json_encode(array("status"=>"error"));
        }
        
    }


    if($context->aksi=="checkcredentials"){
        include "../koneksi.php";
        $iduser=mysqli_real_escape_string($conn,$context->id_user);
        $username=mysqli_real_escape_string($conn,$context->username);
        $token=mysqli_real_escape_string($conn,$context->token);
        $q=$conn->query("SELECT token,username FROM user WHERE id_user=$iduser")->fetch_assoc();
        if($token==$q["token"] && $username==$q["username"]){
            echo json_encode(array("status"=>"success"));
        }
        else{
            echo json_encode(array("status"=>"error"));
        }
    }

    if($context->aksi=="proseslogin"){
        include "../koneksi.php";
        $username=mysqli_real_escape_string($conn,$context->username);
        $password=mysqli_real_escape_string($conn,$context->password);

        $query=$conn->query("SELECT * FROM user WHERE username='$username';")->fetch_assoc();
        $iduser=$query["id_user"];
        $u=$query["username"];

        if($username==$query["username"] && $password==$query["password"]){
            $uniq=getToken(15);
            if($conn->query("UPDATE user SET token='$uniq' WHERE id_user=$iduser;")){
        
                ///mencari rating dari user
                $iduser=$query["id_user"];
                $res2=$conn->query("SELECT SQ.dua/SQ.satu AS rate FROM (SELECT COUNT(perating.username) AS satu,meme.username,SUM(rating.nilai) AS dua FROM rating INNER JOIN user AS perating ON perating.id_user=rating.id_pemberirating INNER JOIN user AS meme ON meme.id_user=rating.id_penerimarating WHERE meme.id_user=$iduser GROUP BY meme.id_user) AS SQ");
                if($res2->num_rows>0){
                    $xxx=$res2->fetch_assoc();
                    $reputasi=(int)$xxx["rate"];
                }
                else{
                    $reputasi=0;
                }

               
                echo json_encode(array(
                    "status"=>"success",
                    "data"=>array(
                        "id_user"=>$iduser,
                        "username"=>$u,
                        "namalengkap"=>$query["namalengkap"],
                        "rating"=>$reputasi,
                        "avatar"=>$query["avatar"],
                        "token"=>$uniq,
                        
                    )
                ));
            }

        }
        else{
            echo json_encode(array(
                "status"=>"error"
            ));
        }
    }
}

?>