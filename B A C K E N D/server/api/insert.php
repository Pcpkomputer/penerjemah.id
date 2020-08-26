<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

if(isset($_POST)){
    
$context=json_decode($_POST["params"]);


if($context->aksi=="prosesPekerjaTerpilih"){
    include "../koneksi.php";
    $id=mysqli_real_escape_string($conn,$context->id);
    $iduser=mysqli_real_escape_string($conn,$context->credentials->id_user);
    $username=mysqli_real_escape_string($conn,$context->credentials->username);
    $token=mysqli_real_escape_string($conn,$context->credentials->token);
    
    $q=$conn->query("SELECT user.id_user, user.username, user.token, permintaan.jangkawaktu, permintaan.judul FROM permintaan INNER JOIN user ON permintaan.id_user=user.id_user WHERE permintaan.id_permintaan=$id;")->fetch_assoc();

    if($q["username"]==$username && $q["id_user"]==$iduser && $q["token"]==$token){
        $idterpilih=mysqli_real_escape_string($conn,$context->idterpilih);
        $deskripsi=mysqli_real_escape_string($conn,$context->deskripsi);

        $judul=$q["judul"];
        $jangkawaktu=$q["jangkawaktu"];
        $date=date("Y-m-d");
        $deadline=date('Y-m-d', strtotime($date. " + $jangkawaktu days"));

        $uniqid=(string)uniqid();
        $target_dir = "../assets/handwork/";
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
                    
                    if($conn->query("INSERT INTO pekerjaterpilihpermintaan VALUES ($id,$idterpilih,'$aa','$deskripsi','$deadline');")){
                        $conn->query("UPDATE permintaan SET permintaan.status='in progress' WHERE permintaan.id_permintaan=$id;");
                        $conn->query("INSERT INTO aktivitas VALUES (NULL,$iduser,'Baru saja memilih kandidat permintaannya di $judul');");
                        $conn->query("DELETE FROM penaruh WHERE penaruh.id_permintaan=$id");
                        $conn->query("INSERT INTO notifikasi VALUES (NULL,$idterpilih,$id,NULL,0)");

                        $p=array("status"=>"success");
                        echo json_encode($p);
                    }
                    else{
                        $p=array("status"=>"error");
                        echo json_encode($p);
                    }
       
            }
        }


    }else{
        $p=array("status"=>"error");
        echo json_encode($p);
    }
}



if($context->aksi=="ikutTaruhan"){
    include "../koneksi.php";
    $id=mysqli_real_escape_string($conn,$context->id);
    $iduser=mysqli_real_escape_string($conn,$context->credentials->id_user);
    //var_dump($context->credentials);
    $username=mysqli_real_escape_string($conn,$context->credentials->username);
    $token=mysqli_real_escape_string($conn,$context->credentials->token);
    //echo "SELECT * FROM penaruh WHERE id_permintaan=$id AND id_user=$iduser";
    $xxx=$conn->query("SELECT * FROM penaruh WHERE id_permintaan=$id AND id_user=$iduser;");
    if($xxx->num_rows==0){
        $ddd=$conn->query("SELECT permintaan.id_user FROM permintaan WHERE permintaan.id_permintaan=$id;")->fetch_assoc();
        if($ddd["id_user"]==$iduser){
            $p=array("status"=>"error");
            echo json_encode($p);
        }else{
            $q=$conn->query("SELECT user.id_user, user.username, user.token FROM user WHERE user.id_user='$iduser';")->fetch_assoc();

            if($q["username"]==$username && $q["id_user"]==$iduser && $q["token"]==$token){
                $q2=$conn->query("SELECT permintaan.status FROM permintaan WHERE permintaan.id_permintaan=$id")->fetch_assoc();
                if($q2["status"]=="published"){
                    $conn->query("INSERT INTO penaruh VALUES ($iduser,$id);");
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
       
    }
    else{
        $p=array("status"=>"error");
        echo json_encode($p);
    }

    
}


if($context->aksi=="kirimKomentar"){
    include "../koneksi.php";
    $id=mysqli_real_escape_string($conn,$context->id);
    $iduser=mysqli_real_escape_string($conn,$context->credentials->id_user);
    $username=mysqli_real_escape_string($conn,$context->credentials->username);
    $token=mysqli_real_escape_string($conn,$context->credentials->token);
    
    $q=$conn->query("SELECT user.id_user, user.username, user.token FROM user WHERE user.id_user='$iduser';")->fetch_assoc();

    if($q["username"]==$username && $q["id_user"]==$iduser && $q["token"]==$token){
        $komentar=mysqli_real_escape_string($conn,$context->bearer->komentar);
        if($conn->query("INSERT INTO komentarjasa VALUES ($iduser,$id,'$komentar')")){
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


if($context->aksi=="membuatPermintaan"){
    include "../koneksi.php";
    $iduser=mysqli_real_escape_string($conn,$context->credentials->id_user);
    $username=mysqli_real_escape_string($conn,$context->credentials->username);
    $token=mysqli_real_escape_string($conn,$context->credentials->token);
    
    $q=$conn->query("SELECT user.id_user, user.username, user.token FROM user WHERE user.id_user='$iduser';")->fetch_assoc();

    if($q["username"]==$username && $q["id_user"]==$iduser && $q["token"]==$token){
        $judul=mysqli_real_escape_string($conn,$context->bearer->judul);
        $deskripsi=mysqli_real_escape_string($conn,$context->bearer->deskripsi);
        $harga=mysqli_real_escape_string($conn,$context->bearer->harga);
        $jangkawaktu=mysqli_real_escape_string($conn,$context->bearer->jangkawaktu);
        $label=mysqli_real_escape_string($conn,$context->bearer->label);
        $kategori=mysqli_real_escape_string($conn,$context->bearer->kategori);
        $tanggaldibuat=date("Y/m/d");
        
        if(strlen($judul)>0 && strlen($deskripsi)>0 && strlen($harga)>0 && strlen($jangkawaktu)>0){
            if($conn->query("INSERT INTO permintaan VALUES (NULL,'$judul','$deskripsi','$kategori','$label','$tanggaldibuat','$harga','$jangkawaktu','published',$iduser);")){
                $p=array("status"=>"success");
                echo json_encode($p);
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
       
    }else{
        $p=array("status"=>"error");
        echo json_encode($p);
    }
}

if($context->aksi=="uploadPortofolio"){
    include "../koneksi.php";
    $id=mysqli_real_escape_string($conn,$context->id);
    $iduser=mysqli_real_escape_string($conn,$context->credentials->id_user);
    $username=mysqli_real_escape_string($conn,$context->credentials->username);
    $token=mysqli_real_escape_string($conn,$context->credentials->token);
    
    $q=$conn->query("SELECT user.id_user, user.username, user.token FROM user WHERE user.username='$id';")->fetch_assoc();

    if($q["username"]==$username && $q["id_user"]==$iduser && $q["token"]==$token){
        
        $deskripsi=mysqli_real_escape_string($conn,$context->bearer->deskripsi);

        $uniqid=(string)uniqid();
        $target_dir = "../assets/portofolio/";
        $uploadOk = 1;
        $base=basename($_FILES["file"]["name"]);
        $imageFileType = strtolower(pathinfo($base,PATHINFO_EXTENSION));

        $aa=$uniqid .".".$imageFileType;

        $target_file = $target_dir . $aa;
        //echo $target_file;
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if($check !== false) {
                $uploadOk = 1;
        } else {
                $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["file"]["size"] > 500000) {
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            //echo json_encode(array("status"=>"error"));
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $url=$aa;
                if($conn->query("INSERT INTO portofolio VALUES ($iduser,'$url','$deskripsi');")){
                    echo json_encode(array("status"=>"success"));
                }
                else{
                    echo json_encode(array("status"=>"error"));
                }

            } else {
                echo json_encode(array("status"=>"error"));
            }
        }
        
    }else{
        $p=array("status"=>"error");
        echo json_encode($p);
    }
}
}
?>