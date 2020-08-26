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


if(isset($_POST)){
    
    $context=json_decode($_POST["params"]);


    if($context->aksi=="notifikasiSudahDilihat"){
        include "../koneksi.php";
        $iduser=mysqli_real_escape_string($conn,$context->credentials->id_user);
        $username=mysqli_real_escape_string($conn,$context->credentials->username);
        $token=mysqli_real_escape_string($conn,$context->credentials->token);

        $q=$conn->query("SELECT user.id_user, user.username, user.token FROM user WHERE user.id_user='$iduser';")->fetch_assoc();
        if($q["username"]==$username && $q["id_user"]==$iduser && $q["token"]==$token){
           $isi=array();
           $isi=$context->notifikasi;
           foreach ($isi as $key => $value) {
               $d=$isi[$key]->id;
               $conn->query("UPDATE notifikasi SET dibaca=1 WHERE notifikasi.id_notifikasi=$d");
           }
           echo json_encode(array("status"=>"success"));
        }
        else{
            echo json_encode(array("status"=>"error"));
        }

    }


    if($context->aksi=="lihatJumlahNotifikasi"){
        include "../koneksi.php";
        $iduser=mysqli_real_escape_string($conn,$context->credentials->id_user);
        $username=mysqli_real_escape_string($conn,$context->credentials->username);
        $token=mysqli_real_escape_string($conn,$context->credentials->token);

        $q=$conn->query("SELECT user.id_user, user.username, user.token FROM user WHERE user.id_user='$iduser';")->fetch_assoc();
        if($q["username"]==$username && $q["id_user"]==$iduser && $q["token"]==$token){
            $q2=$conn->query("SELECT * FROM notifikasi WHERE id_user=$iduser AND dibaca=0;");
            $arr=array();
            while($fetch=$q2->fetch_assoc()){
                $payload=new ArrayObject();
                $payload["id"]=$fetch["id_notifikasi"];
                $payload["id_jasa"]=$fetch["id_jasa"];
                $payload["id_permintaan"]=$fetch["id_permintaan"];
                $payload["keterangan"]=$fetch["keterangan"];
                array_push($arr,$payload);
            }
            echo json_encode($arr);
        }
        else{
            echo json_encode(array("status"=>"error"));
        }

    }

    if($context->aksi=="mengirimPermintaanUndangan"){
        include "../koneksi.php";
        $id=mysqli_real_escape_string($conn,$context->id);
        $iduser=mysqli_real_escape_string($conn,$context->credentials->id_user);
        $username=mysqli_real_escape_string($conn,$context->credentials->username);
        $token=mysqli_real_escape_string($conn,$context->credentials->token);
        $target=mysqli_real_escape_string($conn,$context->target);
        
        $q=$conn->query("SELECT user.username, user.id_user, user.token FROM permintaan INNER JOIN user ON user.id_user=permintaan.id_user WHERE permintaan.id_permintaan=$id;")->fetch_assoc();
        if($q["username"]==$username && $q["id_user"]==$iduser && $q["token"]==$token){
                $cariid=$conn->query("SELECT user.id_user FROM user WHERE user.username='$target';")->fetch_assoc();
                $id_=$cariid["id_user"];
                $conn->query("INSERT INTO undangan VALUES ($id_,$id);");
                $conn->query("INSERT INTO notifikasi VALUES (NULL,$id_,$id,NULL,0,'Anda diundang untuk mengikuti suatu permintaan oleh pemiliknya.');");
                echo json_encode(array("status"=>"success"));
        }else{
            echo json_encode(array("status"=>"error"));
        }
    }


    if($context->aksi=="prosesPembayaran"){
        include "../koneksi.php";
        $id=mysqli_real_escape_string($conn,$context->id);
        $iduser=mysqli_real_escape_string($conn,$context->credentials->id_user);
        $username=mysqli_real_escape_string($conn,$context->credentials->username);
        $token=mysqli_real_escape_string($conn,$context->credentials->token);

        $q=$conn->query("SELECT user.id_user, user.username, user.token FROM user WHERE user.id_user='$iduser';")->fetch_assoc();
        if($q["username"]==$username && $q["id_user"]==$iduser && $q["token"]==$token){
            $restrict1=$conn->query("SELECT permintaan.id_user,permintaan.judul,pekerjaterpilihpermintaan.id_user AS kandidat, permintaan.harga, user.username,user.token,lockedfile.* FROM lockedfile INNER JOIN permintaan ON permintaan.id_permintaan=lockedfile.id_permintaan INNER JOIN user ON permintaan.id_user=user.id_user INNER JOIN pekerjaterpilihpermintaan ON pekerjaterpilihpermintaan.id_permintaan=permintaan.id_permintaan WHERE lockedfile.id_permintaan=$id;")->fetch_assoc();
            if($restrict1["username"]==$username && $restrict1["id_user"]==$iduser && $restrict1["token"]==$token){
                $judd=$restrict1["judul"];
                $jumlahbayar=(int)$restrict1["harga"]/500;
                $plus=$conn->query("SELECT SUM(jumlah) AS plus FROM emoney WHERE prefix='+' AND id_user=$iduser GROUP BY id_user,prefix;")->fetch_assoc();
                $minus=$conn->query("SELECT SUM(jumlah) AS minus FROM emoney WHERE prefix='-' AND id_user=$iduser GROUP BY id_user,prefix;")->fetch_assoc();
                $totalduit=$plus["plus"]-$minus["minus"];

                $kandidat=$restrict1["kandidat"];
                
                if($totalduit<$jumlahbayar){
                    echo json_encode(array("status"=>"alert","keterangan"=>"Uang digital tidak cukup lakukan pengisian dengan Top Up!"));
                }
                else{
                    $tglsekarang=date("Y-m-d h:m:s");
                    $conn->query("INSERT INTO emoney VALUES($kandidat,$jumlahbayar,'+','$tglsekarang','penerimaan pembayaran');");
                    $conn->query("INSERT INTO emoney VALUES($iduser,$jumlahbayar,'-','$tglsekarang','pembayaran permintaan');");
                   $conn->query("UPDATE lockedfile SET locked=1 WHERE id_permintaan=$id");
                    
                    $conn->query("UPDATE permintaan SET permintaan.status='finished' WHERE permintaan.id_permintaan=$id;");
                   
                    $conn->query("INSERT INTO notifikasi VALUES (NULL,$kandidat,$id,NULL,0,'Anda mendapatkan pembayaran dari permintaan $judd sejumlah $jumlahbayar.';");

                    echo json_encode(array("status"=>"success","keterangan"=>"Pembayaran berhasil dilakukan, halaman akan direload kembali. Silakan klik tautan kembali untuk mengunduh."));
                }
            }
            else{
                echo json_encode(array("status"=>"error","keterangan"=>""));
            }
         } else{
            echo json_encode(array("status"=>"error","keterangan"=>""));
         }  

   
    }


    if($context->aksi=="loadFileTransaksi"){
        include "../koneksi.php";
        $id=mysqli_real_escape_string($conn,$context->id);
        $iduser=mysqli_real_escape_string($conn,$context->credentials->id_user);
        $username=mysqli_real_escape_string($conn,$context->credentials->username);
        $token=mysqli_real_escape_string($conn,$context->credentials->token);

        $q=$conn->query("SELECT user.id_user, user.username, user.token FROM user WHERE user.id_user='$iduser';")->fetch_assoc();
        if($q["username"]==$username && $q["id_user"]==$iduser && $q["token"]==$token){
            $restrict1=$conn->query("SELECT permintaan.id_user, permintaan.harga, user.username,user.token,lockedfile.* FROM lockedfile INNER JOIN permintaan ON permintaan.id_permintaan=lockedfile.id_permintaan INNER JOIN user ON permintaan.id_user=user.id_user WHERE lockedfile.id_permintaan=$id;")->fetch_assoc();
            if($restrict1["username"]==$username && $restrict1["id_user"]==$iduser && $restrict1["token"]==$token){
                if($restrict1["locked"]==0){

                    echo json_encode(array(
                        "status"=>"unauthorized",
                        "jumlahbayar"=>$restrict1["harga"],
                        "token"=>(int)$restrict1["harga"]/500
                    ));
                }
                else{
                    $fl=$restrict1["file"];
                    echo json_encode(array("status"=>"success","link"=>$fl));
                }
            }
            else{
                echo json_encode(array("status"=>"error"));
            }
         } else{
             echo json_encode(array());
         }  

   
    }


    if($context->aksi=="loadPermintaanSelesai"){
        include "../koneksi.php";
        $iduser=mysqli_real_escape_string($conn,$context->credentials->id_user);
        $username=mysqli_real_escape_string($conn,$context->credentials->username);
        $token=mysqli_real_escape_string($conn,$context->credentials->token);

        $q=$conn->query("SELECT user.id_user, user.username, user.token FROM user WHERE user.id_user='$iduser';")->fetch_assoc();
        if($q["username"]==$username && $q["id_user"]==$iduser && $q["token"]==$token){
            $arr=array();
            $q2=$conn->query("SELECT permintaan.*,pekerjaterpilihpermintaan.id_user, dari.username FROM lockedfile INNER JOIN permintaan ON lockedfile.id_permintaan=permintaan.id_permintaan INNER JOIN pekerjaterpilihpermintaan ON pekerjaterpilihpermintaan.id_permintaan=permintaan.id_permintaan INNER JOIN user AS dari ON pekerjaterpilihpermintaan.id_user=dari.id_user WHERE permintaan.id_user=$iduser;");
            while($fetch=$q2->fetch_assoc()){
                $payload=new ArrayObject();
                $payload["idpermintaan"]=$fetch["id_permintaan"];
                $payload["status"]=$fetch["status"];
                $payload["judul"]=$fetch["judul"];
                $payload["dari"]=$fetch["username"];
                array_push($arr,$payload);
            }
            echo json_encode($arr);            
    
         } else{
             echo json_encode(array());
         }  

   
    }
    

    if($context->aksi=="prosesDalamProgress"){
        include "../koneksi.php";
        $id=mysqli_real_escape_string($conn,$context->id);
        $iduser=mysqli_real_escape_string($conn,$context->credentials->id_user);
        $username=mysqli_real_escape_string($conn,$context->credentials->username);
        $token=mysqli_real_escape_string($conn,$context->credentials->token);

        
        $restrict1=$conn->query("SELECT * FROM lockedfile WHERE lockedfile.id_permintaan=$id;");
        if($restrict1->num_rows==0){
            
         $restrict2=$conn->query("SELECT * FROM (SELECT deadline,DATE(NOW()) AS sekarang FROM pekerjaterpilihpermintaan WHERE id_permintaan=$id) AS SQ WHERE SQ.sekarang<SQ.deadline;");
         if($restrict2->num_rows>0){
            $q=$conn->query("SELECT user.id_user, user.username, user.token FROM user WHERE user.id_user='$iduser';")->fetch_assoc();
    
            if($q["username"]==$username && $q["id_user"]==$iduser && $q["token"]==$token){
                $q2=$conn->query("SELECT pekerjaterpilihpermintaan.*,user.username,user.id_user,user.token FROM pekerjaterpilihpermintaan INNER JOIN user ON user.id_user=pekerjaterpilihpermintaan.id_user WHERE pekerjaterpilihpermintaan.id_permintaan=$id;")->fetch_assoc();
                if($q2["username"]==$username && $q2["id_user"]==$iduser && $q2["token"]==$token){
                    
    
                    $uniqid=(string)getToken(25);
                    $target_dir = "../assets/locked/";
                    $uploadOk = 1;
                    $base=basename($_FILES["file"]["name"]);
                    $imageFileType = strtolower(pathinfo($base,PATHINFO_EXTENSION));
                    $aa=$uniqid .".".$imageFileType;
                    $target_file = $target_dir . $aa;
    
                    if (file_exists($target_file)) {
                        $uploadOk = 0;
                    }
                    // Check file size
                    if ($_FILES["file"]["size"] > 50000000) {
                        $uploadOk = 0;
                    }
                    // Allow certain file formats
                    if($imageFileType != "docx" && $imageFileType != "doc" && $imageFileType != "pdf" && $imageFileType != "ass" && $imageFileType != "srt") {
                        $uploadOk = 0;
                    }
    
                    if ($uploadOk == 0) {
                        echo json_encode(array("status"=>"error"));
                    } else {
                        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                            $conn->query("INSERT INTO lockedfile VALUES ($id,0,'$aa');");
                           $conn->query("UPDATE permintaan SET permintaan.status='waiting payment' WHERE permintaan.id_permintaan=$id");
                           $idpembuat=$conn->query("SELECT permintaan.id_user,permintaan.judul FROM permintaan WHERE permintaan.id_permintaan=$id;")->fetch_assoc();
                            $idpem=$idpembuat["id_user"];
                           $juddd=$idpembuat["judul"];
                        $conn->query("INSERT INTO notifikasi (id_user,id_permintaan,dibaca,keterangan) VALUES ($idpem,$id,0,'Permintaan Anda yang berjudul $juddd baru saja diselesaikan oleh kandidat pilihan Anda');");
                            
                            echo json_encode(array("status"=>"success"));
                        }
                        else{
                            echo json_encode(array("status"=>"error"));
                        }
                    }
    
    
                }  
                
            }else{ 
                echo json_encode(array("status"=>"error"));
            }
               
           }
           else{
               echo json_encode(array("status"=>"error"));
           }
         }
         else{
            echo json_encode(array("status"=>"error"));
         }
   
    }
    
    if($context->aksi=="loadDalamProgress"){
        include "../koneksi.php";
        $iduser=mysqli_real_escape_string($conn,$context->credentials->id_user);
        $username=mysqli_real_escape_string($conn,$context->credentials->username);
        $token=mysqli_real_escape_string($conn,$context->credentials->token);

          
         $q=$conn->query("SELECT user.id_user, user.username, user.token FROM user WHERE user.id_user='$iduser';")->fetch_assoc();
    
        if($q["username"]==$username && $q["id_user"]==$iduser && $q["token"]==$token){
            $q2=$conn->query("SELECT permintaan.*,pekerjaterpilihpermintaan.* FROM pekerjaterpilihpermintaan INNER JOIN permintaan ON permintaan.id_permintaan=pekerjaterpilihpermintaan.id_permintaan WHERE pekerjaterpilihpermintaan.id_user=$iduser;");
            if($q2->num_rows>0){
                $payload=array();
                while($fetch=$q2->fetch_assoc()){
                    $arr=new ArrayObject();
                    $arr["id"]=$fetch["id_permintaan"];
                    $arr["judul"]=$fetch["judul"];
                    $arr["status"]=$fetch["status"];
                    $arr["harga"]=$fetch["harga"];
                    $arr["deskripsi"]=$fetch["deskripsi"];
                    $arr["file"]=$fetch["file"];
                    $arr["deadline"]=$fetch["deadline"];

                    array_push($payload,$arr);
                }   
                echo json_encode($payload);
            }else{ 
                echo json_encode(array());
            }
        }
           
        
    }
    
}