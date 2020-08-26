<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

if(isset($_POST)){
    
    $context=json_decode($_POST["params"]);

    if($context->aksi=="updateDetailUser"){
        include "../koneksi.php";
        $id=mysqli_real_escape_string($conn,$context->id);
        $iduser=mysqli_real_escape_string($conn,$context->credentials->id_user);
        $username=mysqli_real_escape_string($conn,$context->credentials->username);
        $token=mysqli_real_escape_string($conn,$context->credentials->token);
        
        $q=$conn->query("SELECT user.id_user, user.username, user.token FROM user WHERE user.username='$id';")->fetch_assoc();

        if($q["username"]==$username && $q["id_user"]==$iduser && $q["token"]==$token){
            $namalengkap=mysqli_real_escape_string($conn,$context->bearer->namalengkap);
            $provinsi=mysqli_real_escape_string($conn,$context->bearer->provinsi);
            $kabupaten=mysqli_real_escape_string($conn,$context->bearer->kabupaten);
            $deskripsi=mysqli_real_escape_string($conn,$context->bearer->deskripsi);
            
            if($conn->query("UPDATE user SET user.namalengkap='$namalengkap',user.provinsi='$provinsi',user.kabupaten='$kabupaten',user.deskripsi='$deskripsi' WHERE user.id_user=$iduser;")){
                $p=array("status"=>"success");
                echo json_encode($p);
            }
            else{
                $p=array("status"=>"error");
                echo json_encode($p);
            }
        }else{
            $p=array("status"=>"error");
            echo json_encode($p);
        }
    }


    if($context->aksi=="updateDetailJasa"){
        include "../koneksi.php";
        $id=mysqli_real_escape_string($conn,$context->id);
        $iduser=mysqli_real_escape_string($conn,$context->credentials->id_user);
        $username=mysqli_real_escape_string($conn,$context->credentials->username);
        $token=mysqli_real_escape_string($conn,$context->credentials->token);
        
        $q=$conn->query("SELECT user.username,user.id_user,user.token FROM jasa INNER JOIN user ON jasa.id_user=user.id_user WHERE jasa.id_jasa=$id;")->fetch_assoc();

        if($q["username"]==$username && $q["id_user"]==$iduser && $q["token"]==$token){
            $judul=mysqli_real_escape_string($conn,$context->bearer->judul);
            $deskripsi=mysqli_real_escape_string($conn,$context->bearer->deskripsi);
            $label=mysqli_real_escape_string($conn,$context->bearer->label);
            
            if($conn->query("UPDATE jasa SET jasa.judul='$judul',jasa.deskripsi='$deskripsi',jasa.label='$label' WHERE jasa.id_jasa=$id;")){
                $p=array("status"=>"success");
                echo json_encode($p);
            }else{
                $p=array("status"=>"error");
                echo json_encode($p);
            }

        }else{
            $p=array("status"=>"error");
            echo json_encode($p);
        }
    }

    
    if($context->aksi=="updateDetailPermintaan"){
        include "../koneksi.php";
        $id=mysqli_real_escape_string($conn,$context->id);
        $iduser=mysqli_real_escape_string($conn,$context->credentials->id_user);
        $username=mysqli_real_escape_string($conn,$context->credentials->username);
        $token=mysqli_real_escape_string($conn,$context->credentials->token);
        
        $q=$conn->query("SELECT user.username,user.id_user,user.token FROM permintaan INNER JOIN user ON permintaan.id_user=user.id_user WHERE permintaan.id_permintaan=$id;")->fetch_assoc();

        if($q["username"]==$username && $q["id_user"]==$iduser && $q["token"]==$token){
            $judul=mysqli_real_escape_string($conn,$context->bearer->judul);
            $deskripsi=mysqli_real_escape_string($conn,$context->bearer->deskripsi);

            if($conn->query("UPDATE permintaan SET permintaan.judul='$judul',permintaan.deskripsi='$deskripsi' WHERE permintaan.id_permintaan=$id")){
                $p=array("status"=>"success");
                echo json_encode($p);
            }
            else{
                $p=array("status"=>"error");
                echo json_encode($p);
            }
        }else{
            $p=array("status"=>"error");
                echo json_encode($p);
        }
    }
}

?>