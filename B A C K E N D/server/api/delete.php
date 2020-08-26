<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

if(isset($_POST)){
    
    $context=json_decode($_POST["params"]);

    if($context->aksi=="deleteDetailJasa"){
        include "../koneksi.php";
        $id=mysqli_real_escape_string($conn,$context->id);
        $iduser=mysqli_real_escape_string($conn,$context->credentials->id_user);
        $username=mysqli_real_escape_string($conn,$context->credentials->username);
        $token=mysqli_real_escape_string($conn,$context->credentials->token);

        $q=$conn->query("SELECT jasa.id_permintaan,jasa.judul,user.username,user.id_user,user.token FROM jasa INNER JOIN user ON jasa.id_user=user.id_user WHERE jasa.id_jasa=$id;")->fetch_assoc();

        if($q["username"]==$username && $q["id_user"]==$iduser && $q["token"]==$token){
            if($conn->query("DELETE FROM jasa WHERE id_jasa=$id")){
                $judul=$q["judul"];
                $conn->query("INSERT INTO aktivitas VALUES (NULL,$iduser,'Baru saja menghapus jasanya yaitu $judul');");
                echo json_encode(array(
                    "status"=>"success"
                ));
            }
            else{
                $p=array("status"=>"error");
                echo json_encode($p);
            }
           
        }
        else{
            $p=array("status"=>"error");
            echo json_encode($p);
        }
    }

    
    if($context->aksi=="deleteDetailPermintaan"){
        include "../koneksi.php";
        $id=mysqli_real_escape_string($conn,$context->id);
        $iduser=mysqli_real_escape_string($conn,$context->credentials->id_user);
        $username=mysqli_real_escape_string($conn,$context->credentials->username);
        $token=mysqli_real_escape_string($conn,$context->credentials->token);

        $q=$conn->query("SELECT permintaan.id_permintaan,permintaan.judul,user.username,user.id_user,user.token FROM permintaan INNER JOIN user ON permintaan.id_user=user.id_user WHERE permintaan.id_permintaan=$id;")->fetch_assoc();

        if($q["username"]==$username && $q["id_user"]==$iduser && $q["token"]==$token){
            if($conn->query("DELETE FROM permintaan WHERE id_permintaan=$id")){
                $judul=$q["judul"];
                $conn->query("INSERT INTO aktivitas VALUES (NULL,$iduser,'Baru saja menghapus permintaannya yaitu $judul');");
                echo json_encode(array(
                    "status"=>"success"
                ));
            }
            else{
                $p=array("status"=>"error");
                echo json_encode($p);
            }
           
        }
        else{
            $p=array("status"=>"error");
            echo json_encode($p);
        }
    }
}

?>