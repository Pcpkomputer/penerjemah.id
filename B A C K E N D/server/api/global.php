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

    if($context->aksi=="loadJudulPermintaan"){
        include "../koneksi.php";

        $iduser=mysqli_real_escape_string($conn,$context->credentials->id_user);
        $username=mysqli_real_escape_string($conn,$context->credentials->username);
        $token=mysqli_real_escape_string($conn,$context->credentials->token);

        $q=$conn->query("SELECT user.id_user, user.username, user.token FROM user WHERE user.id_user='$iduser';")->fetch_assoc();
        if($q["username"]==$username && $q["id_user"]==$iduser && $q["token"]==$token){
            $q2=$conn->query("SELECT permintaan.id_permintaan,permintaan.judul FROM permintaan WHERE permintaan.id_user=$iduser AND permintaan.status='published';");
            if($q2->num_rows>0){
                $arr=array();
                while($fetch=$q2->fetch_assoc()){
                    $obj=new ArrayObject();
                    $obj["id"]=$fetch["id_permintaan"];
                    $obj["judul"]=$fetch["judul"];
                    array_push($arr,$obj);
                }
                echo json_encode($arr);
            }else{
                echo json_encode(array());
            }
        }else{
            echo json_encode(array("status"=>"error"));
        }
    }

    if($context->aksi=="cekusername"){
        include "../koneksi.php";
        $username=mysqli_real_escape_string($conn,$context->id);
        $q=$conn->query("SELECT user.id_user FROM user WHERE user.username='$username';");
        if($q->num_rows>0){
            echo json_encode(array("status"=>"success"));
        }
        else{
            echo json_encode(array("status"=>"error"));
        }
    }

    if($context->aksi=="prosesdaftar"){
        include "../koneksi.php";
        $uniqid=(string)uniqid();
        $target_dir = "../assets/avatar/";
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
                $avatar=$aa;
                $email=mysqli_real_escape_string($conn,$context->email);
                $username=mysqli_real_escape_string($conn,$context->username);
                $password=mysqli_real_escape_string($conn,$context->password);
                $namalengkap=mysqli_real_escape_string($conn,$context->namalengkap);
                $deskripsi=mysqli_real_escape_string($conn,$context->deskripsi);
                $provinsi=mysqli_real_escape_string($conn,$context->provinsi);
                $kabupaten=mysqli_real_escape_string($conn,$context->kabupaten);
                $tanggaldibuat=date("Y/m/d");
                $token=getToken(15);
                $bisaproses=true;
                
                if(!preg_match("/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/",$email)){
                    $bisaproses=false;
                }

                if($bisaproses==true){
                    if($conn->query("INSERT INTO user (id_user,email,username,password,namalengkap,deskripsi,tanggaldibuat,provinsi,kabupaten,terakhirlogin,avatar,token) VALUES (NULL,'$email','$username','$password','$namalengkap','$deskripsi','$tanggaldibuat','$provinsi','$kabupaten','','$avatar','$token');")==true){
                        echo json_encode(array("status"=>"success"));
                    }
                    else{
                        echo json_encode(array("status"=>"error"));
                    }
                }
                else{
                    echo json_encode(array("status"=>"error"));
                }

                
            } else {
                echo json_encode(array("status"=>"error"));
            }
        }

    }

    if($context->aksi=="cekcaptcha"){
        include "../koneksi.php";
        $idcaptcha=mysqli_real_escape_string($conn,$context->id);
        $value=mysqli_real_escape_string($conn,$context->value);

        $q=$conn->query("SELECT * FROM captcha WHERE id_captcha=$idcaptcha");
        $res=$q->fetch_assoc();

        if($res["kunci"]==$value){
            echo json_encode(array(
                "status"=>true
            ));
        }
        else{
            echo json_encode(array(
                "status"=>false
            ));
        }
    }

    if($context->aksi=="loaddatacaptcha"){
        include "../koneksi.php";
        $payload=new ArrayObject();
        $q=$conn->query("SELECT * FROM captcha;");
        $random=rand(1,$q->num_rows);
        $q=$conn->query("SELECT * FROM captcha WHERE id_captcha=$random");
        $fetch=$q->fetch_assoc();
        $payload["id_captcha"]=$fetch["id_captcha"];
        $payload["gambar"]=$fetch["gambar"];

        echo json_encode($payload);
    }

    if($context->aksi=="loaddataportofolio"){
        include "../koneksi.php";
        $payload=array();

        $username=mysqli_real_escape_string($conn,$context->id);
        $q=$conn->query("SELECT * FROM portofolio INNER JOIN user ON user.id_user=portofolio.id_user WHERE user.username='$username';");
        
        if($q->num_rows>0){
            while($fetch=$q->fetch_assoc()){
                $p=new ArrayObject();
                $p["id"]=$fetch["id_user"];
                $p["gambar"]=$fetch["gambar"];
                $p["keterangan"]=$fetch["isi"];
                array_push($payload,$p);
            }
            echo json_encode($payload);
        }
        else{
            echo json_encode($payload);
        }
    }

    if($context->aksi=='loaddatadashboard'){
        include "../koneksi.php";
        ///
        $payload=new ArrayObject();
        ///
        $q=$conn->query("SELECT permintaan.id_permintaan, permintaan.judul,permintaan.id_user,user.username,user.avatar FROM permintaan INNER JOIN user ON user.id_user=permintaan.id_user ORDER BY permintaan.id_permintaan DESC LIMIT 5;");
        $q2=$conn->query("SELECT SQ.*,SQ.totalnilai/SQ.jmlorang AS totalfix FROM (SELECT COUNT(rating.id_pemberirating) AS jmlorang, rating.id_penerimarating, penerima.username, penerima.avatar, SUM(rating.nilai) AS totalnilai FROM rating INNER JOIN user AS pemberi ON pemberi.id_user=rating.id_pemberirating INNER JOIN user AS penerima ON penerima.id_user=rating.id_penerimarating GROUP BY rating.id_penerimarating) AS SQ GROUP BY totalfix DESC LIMIT 5;");
        $q3=$conn->query("SELECT user.username, user.avatar, aktivitas.deskripsi FROM aktivitas INNER JOIN user ON user.id_user=aktivitas.id_user ORDER BY aktivitas.id_aktivitas DESC LIMIT 5;");
        $q4=$conn->query("SELECT COUNT(*) AS total FROM user;");
        
        if($q4->num_rows>0){
            $hasil=$q4->fetch_assoc();
            $payload["total"]=$hasil["total"];
        }


        if($q3->num_rows>0){
            $arr=array();
            while($fetch=$q3->fetch_assoc()){
                $p=new ArrayObject();
                $p["username"]=$fetch["username"];
                $p["deskripsi"]=$fetch["deskripsi"];
                $p["avatar"]=$fetch["avatar"];
                array_push($arr,$p);
            }
            $payload["aktivitas"]=$arr;
        }
        else{
            $payload["aktivitas"]=array();
        }


        if($q->num_rows>0){
            $arr=array();
            while($fetch=$q->fetch_assoc()){
                $p=new ArrayObject();
                $p["id"]=$fetch["id_permintaan"];
                $p["avatar"]=$fetch["avatar"];
                $p["judul"]=$fetch["judul"];
                $p["user"]=$fetch["username"];
                array_push($arr,$p);
            }
            $payload["baruditambahkan"]=$arr;
        }
        else{
            $payload["baruditambahkan"]=array();
        }

        if($q2->num_rows>0){
            $arr=array();
            while($fetch=$q2->fetch_assoc()){
                $p=new ArrayObject();
                $p["username"]=$fetch["username"];
                $p["avatar"]=$fetch["avatar"];
                $p["rating"]=(int)$fetch["totalfix"];

                //mencari urutan rating
                if($p["rating"]>0){
                    $sub2=$conn->query("SELECT rating.id_penerimarating,SUM(rating.nilai) AS total FROM rating GROUP BY rating.id_penerimarating ORDER BY total DESC;");
                    $count=0;
                    $urutan=0;
                    while($h=$sub2->fetch_assoc()){
                        $count=$count+1;
                        if($h["id_penerimarating"]==$fetch["id_penerimarating"]){
                            $urutan=$count;
                            break;
                        }
                    }
                    $p["ranking"]=$urutan;
                }
                else{
                    $p["ranking"]="No Ranking";
                }
                array_push($arr,$p);

            }

            $payload["ratingtertinggi"]=$arr;
        }
        else{
            $payload["ratingtertinggi"]=array();
        }

        echo json_encode($payload);
  
    }

    if($context->aksi=="memuatdetailuser-jasa"){
        include "../koneksi.php";
        $id=mysqli_real_escape_string($conn,$context->id);
        $q=$conn->query("SELECT jasa.background,jasa.id_jasa,jasa.judul,jasa.id_user,user.username FROM jasa INNER JOIN user ON user.id_user=jasa.id_user WHERE username='$id';");
        if($q->num_rows>0){
            $arr=array();
            while($fetch=$q->fetch_assoc()){
                $payload=new ArrayObject();
                $payload["id"]=$fetch["id_jasa"];
                $payload["judul"]=$fetch["judul"];
                $payload["background"]=$fetch["background"];
                array_push($arr,$payload);
            }
            echo json_encode($arr);
        }
        else{
            $payload=array();
            echo json_encode($payload);
        }
    }

    if($context->aksi=="memuatdetailuser-permintaan"){
        include "../koneksi.php";
        $id=mysqli_real_escape_string($conn,$context->id);
        $q=$conn->query("SELECT permintaan.id_permintaan,permintaan.judul,permintaan.status,permintaan.id_user,user.username FROM permintaan INNER JOIN user ON permintaan.id_user=user.id_user WHERE user.username='$id';");
        if($q->num_rows>0){
            $arr=array();
            while($fetch=$q->fetch_assoc()){
                $payload=new ArrayObject();
                $payload["id"]=$fetch["id_permintaan"];
                $payload["judul"]=$fetch["judul"];
                $payload["status"]=$fetch["status"];
                array_push($arr,$payload);
            }
            echo json_encode($arr);
        }else{
            $arr=array();
            echo json_encode($arr);
        }
    }

    if($context->aksi=="memuatdetailuser"){
        include "../koneksi.php";
        $id=mysqli_real_escape_string($conn,$context->id);
        $q=$conn->query("SELECT user.id_user, user.avatar, user.namalengkap, user.deskripsi, user.username, user.tanggaldibuat, user.provinsi, user.kabupaten, user.terakhirlogin FROM user WHERE username='$id';");
        if($q->num_rows>0){       
            $fetch=$q->fetch_assoc();
            $iduser=$fetch["id_user"];
            $totalpermintaan=$conn->query("SELECT COUNT(*) AS totalpermintaan FROM permintaan WHERE permintaan.id_user=$iduser;")->fetch_assoc();
            $totaljasa=$conn->query("SELECT COUNT(*) AS totaljasa FROM jasa WHERE jasa.id_user=$iduser;")->fetch_assoc();
            
            $payload=new ArrayObject();
            $payload["user"]=array(
                "id"=>$fetch["id_user"],
                "avatar"=>$fetch["avatar"],
                "namalengkap"=>$fetch["namalengkap"],
                "username"=>$fetch["username"],
                "tanggaldibuat"=>$fetch["tanggaldibuat"],
                "provinsi"=>$fetch["provinsi"],
                "kabupaten"=>$fetch["kabupaten"],
                "permintaandanjasaselesai"=>$totalpermintaan["totalpermintaan"]+$totaljasa["totaljasa"],
                "terakhirlogin"=>$fetch["terakhirlogin"]
            );
            $payload["thread"]=array(
                "deskripsi"=>$fetch["deskripsi"]
            );
            echo json_encode($payload);
        }
        else{
            $payload=new ArrayObject();
            echo json_encode($payload);
        }
    }


    if($context->aksi=="memuattotaluser"){
        include "../koneksi.php";
        if(isset($context->kategori)){
            echo "mmq";
        }
        else{
            $q=$conn->query("SELECT COUNT(*) AS total FROM user;");
            if($q->num_rows>0){
                $hasil=$q->fetch_assoc();
                $payload=new ArrayObject();
                $payload["total"]=$hasil["total"];
                echo json_encode($payload);
            }
        }
    }
    if($context->aksi=="memuatkontenuser"){
        include "../koneksi.php";
        $limit_=mysqli_real_escape_string($conn,$context->limit);
        $offset_=mysqli_real_escape_string($conn,$context->offset);
        $q=$conn->query("SELECT user.id_user,user.avatar,user.username FROM user ORDER BY user.id_user DESC LIMIT $limit_ OFFSET $offset_;");
        if($q->num_rows>0){
            $qx=array();
            while($fetch=$q->fetch_assoc()){
                $payload=new ArrayObject();
                $payload["id"]=$fetch["id_user"];
                $payload["user"]=$fetch["username"];
                $payload["avatar"]=$fetch["avatar"];

                 ///mencari rating dari user
                 $iduser=$fetch["id_user"];
                 $res2=$conn->query("SELECT SQ.dua/SQ.satu AS rate FROM (SELECT COUNT(perating.username) AS satu,meme.username,SUM(rating.nilai) AS dua FROM rating INNER JOIN user AS perating ON perating.id_user=rating.id_pemberirating INNER JOIN user AS meme ON meme.id_user=rating.id_penerimarating WHERE meme.id_user=$iduser GROUP BY meme.id_user) AS SQ");
                 if($res2->num_rows>0){
                     $xxx=$res2->fetch_assoc();
                     $payload["reputasi"]=(int)$xxx["rate"];
                 }
                 else{
                     $payload["reputasi"]=0;
                 }
                 
                 array_push($qx,$payload);
 
                
            }
            echo json_encode($qx);
        }
        

    }
    if($context->aksi=="memuatkomentarjasa"){
        include "../koneksi.php";
        $id=mysqli_real_escape_string($conn,$context->id);
        $q=$conn->query("SELECT komentarjasa.id_user,user.username,user.avatar,komentarjasa.id_jasa,komentarjasa.komentar FROM komentarjasa INNER JOIN user ON komentarjasa.id_user=user.id_user WHERE komentarjasa.id_jasa=$id;");
        $payload=array();
        if($q->num_rows>0){
            while($fetch=$q->fetch_assoc()){
                $k=new ArrayObject();
                $k["username"]=$fetch["username"];
                $k["komentar"]=$fetch["komentar"];
                $k["gambar"]=$fetch["avatar"];
                array_push($payload,$k);
            }
            echo json_encode($payload);
        }
        else{
            $payload=array();
            echo json_encode($payload);
        }
    }  
    if($context->aksi=="memuatkontenjasa"){
        include "../koneksi.php";
        if(isset($context->id)){
            $id=mysqli_real_escape_string($conn,$context->id);
            $qjasa=$conn->query("SELECT jasa.judul,jasa.id_jasa,jasa.tanggaldibuat,jasa.label,user.id_user,user.avatar,user.username,jasa.harga,jasa.waktupengerjaan,jasa.deskripsi,jasa.background FROM jasa INNER JOIN user ON jasa.id_user=user.id_user WHERE jasa.id_jasa=$id;");
            if($qjasa->num_rows>0){
                $p=array();
                $fetch=$qjasa->fetch_assoc();
                $payload=new ArrayObject();
                $payload["user"]=new ArrayObject();
                $payload["user"]["username"]=$fetch["username"];
                $payload["user"]["id"]=$fetch["id_user"];
                $payload["user"]["avatar"]=$fetch["avatar"];
    
                ///mencari rating dari user
                $iduser=$fetch["id_user"];
                $res2=$conn->query("SELECT SQ.dua/SQ.satu AS rate FROM (SELECT COUNT(perating.username) AS satu,meme.username,SUM(rating.nilai) AS dua FROM rating INNER JOIN user AS perating ON perating.id_user=rating.id_pemberirating INNER JOIN user AS meme ON meme.id_user=rating.id_penerimarating WHERE meme.id_user=$iduser GROUP BY meme.id_user) AS SQ");
                if($res2->num_rows>0){
                    $xxx=$res2->fetch_assoc();
                    $payload["user"]["rating"]=(int)$xxx["rate"];
                }
                else{
                     $payload["user"]["rating"]=0;
                }
                
                //mencari urutan rating
                if($payload["user"]["rating"]>0){
                    $q=$conn->query("SELECT rating.id_penerimarating,SUM(rating.nilai) AS total FROM rating GROUP BY rating.id_penerimarating ORDER BY total DESC;");
                    $count=0;
                    $urutan=0;
                    while($h=$q->fetch_assoc()){
                        $count=$count+1;
                        if($h["id_penerimarating"]==$payload["user"]["id"]){
                            $urutan=$count;
                            break;
                        }
                    }
                    $payload["user"]["ranking"]=$urutan;
                }
                else{
                    $payload["user"]["ranking"]="No Ranking";
                }

                $payload["thread"]=array(
                    "id"=>$fetch["id_jasa"],
                    "judul"=>$fetch["judul"],
                    "deskripsi"=>$fetch["deskripsi"],
                    "tags"=>explode(",",$fetch["label"]),
                    "tgldibuat"=>$fetch["tanggaldibuat"],
                    "harga"=>$fetch["harga"],
                    "jangkawaktu"=>$fetch["waktupengerjaan"],
                    "background"=>$fetch["background"]
                );

                echo json_encode($payload);


            }
        }else{
            $limit=mysqli_real_escape_string($conn,$context->limit);
            $offset=mysqli_real_escape_string($conn,$context->offset);
            $qjasa=$conn->query("SELECT jasa.judul,jasa.id_jasa,jasa.tanggaldibuat,jasa.label,user.id_user,user.avatar,user.username,jasa.harga,jasa.waktupengerjaan,jasa.deskripsi,jasa.background FROM jasa INNER JOIN user ON jasa.id_user=user.id_user LIMIT $limit OFFSET $offset;");
            if($qjasa->num_rows>0){
                $p=array();
                while($fetch=$qjasa->fetch_assoc()){
                    $payload=new ArrayObject();
                    $payload["id"]=$fetch["id_jasa"];
                    $payload["judul"]=$fetch["judul"];
                    $payload["label"]=explode(",",$fetch["label"]);
                    $payload["tanggaldibuat"]=$fetch["tanggaldibuat"];
                    $payload["pemostingjasa"]=array(
                        "id"=>$fetch["id_user"],
                        "nama"=>$fetch["username"],
                        "avatar"=>$fetch["avatar"]
                    );
                    $payload["harga"]=$fetch["harga"];
                    $payload["waktupengerjaan"]=$fetch["waktupengerjaan"];
                    $payload["deskripsi"]=$fetch["deskripsi"];
                    $payload["gambar"]=$fetch["background"];
    
                     ///mencari rating dari user
                    $iduser=$fetch["id_user"];
                    $res2=$conn->query("SELECT SQ.dua/SQ.satu AS rate FROM (SELECT COUNT(perating.username) AS satu,meme.username,SUM(rating.nilai) AS dua FROM rating INNER JOIN user AS perating ON perating.id_user=rating.id_pemberirating INNER JOIN user AS meme ON meme.id_user=rating.id_penerimarating WHERE meme.id_user=$iduser GROUP BY meme.id_user) AS SQ");
                    if($res2->num_rows>0){
                        $xxx=$res2->fetch_assoc();
                        $payload["rating"]=(int)$xxx["rate"];
                    }
                    else{
                        $payload["rating"]=0;
                    }
    
                    array_push($p,$payload);
                }
                echo json_encode($p);
            }
        }
      
    }

    if($context->aksi=="memuatpenaruhpermintaan"){
        include "../koneksi.php";
        $queryPenaruh=$conn->query("SELECT penaruh.id_user,penaruh.id_permintaan,user.username,user.avatar FROM penaruh INNER JOIN user ON penaruh.id_user=user.id_user WHERE penaruh.id_permintaan=$context->id;");
        if($queryPenaruh->num_rows>0){
            $payload=array();
            while($fetch=$queryPenaruh->fetch_assoc()){
                $p=array(
                    "id_user"=>$fetch["id_user"],
                    "username"=>$fetch["username"],
                    "gambar"=>$fetch["avatar"],
                    "rating"=>0
                );

                 ///mencari rating dari user
                $iduser=$fetch["id_user"];
                $res2=$conn->query("SELECT SQ.dua/SQ.satu AS rate FROM (SELECT COUNT(perating.username) AS satu,meme.username,SUM(rating.nilai) AS dua FROM rating INNER JOIN user AS perating ON perating.id_user=rating.id_pemberirating INNER JOIN user AS meme ON meme.id_user=rating.id_penerimarating WHERE meme.id_user=$iduser GROUP BY meme.id_user) AS SQ");
                if($res2->num_rows>0){
                    $xxx=$res2->fetch_assoc();
                    $p["rating"]=(int)$xxx["rate"];
                }
                else{
                    $p["rating"]=0;
                }
                
                array_push($payload,$p);
            }
            echo json_encode($payload);
        }
        else{
            $payload=array();
            echo json_encode($payload);
        }
    }

    if($context->aksi=="mencarijumlahuser"){
        include "../koneksi.php";
         //// mencari jumlah user
         $queryJmlUser=$conn->query("SELECT COUNT(*) AS total FROM user")->fetch_assoc();
         $payload=array(
            "jumlahuser"=>$queryJmlUser["total"]
         );
         echo json_encode($payload);
    }
    if($context->aksi=="memuatpekerjaterpilihpermintaan"){
        include '../koneksi.php';
        $id=mysqli_real_escape_string($conn,$context->id);
        $res=$conn->query("SELECT * FROM pekerjaterpilihpermintaan WHERE id_permintaan=$id;");
        if($res->num_rows>0){
            $hasil=$conn->query("SELECT pekerjaterpilihpermintaan.id_permintaan,pekerjaterpilihpermintaan.id_user,user.username,user.avatar FROM pekerjaterpilihpermintaan INNER JOIN user ON pekerjaterpilihpermintaan.id_user=user.id_user WHERE pekerjaterpilihpermintaan.id_permintaan=$id;")->fetch_assoc();
            

            $payload=array(
                "id_user"=>$hasil["id_user"],
                "username"=>$hasil["username"],
                "rating"=>0,
                "point"=>0,
                "ranking"=>"No Ranking",
                "gambar"=>$hasil["avatar"]
             );

            ///mencari rating dari user
            $iduser=$hasil["id_user"];
            $res2=$conn->query("SELECT SQ.dua/SQ.satu AS rate FROM (SELECT COUNT(perating.username) AS satu,meme.username,SUM(rating.nilai) AS dua FROM rating INNER JOIN user AS perating ON perating.id_user=rating.id_pemberirating INNER JOIN user AS meme ON meme.id_user=rating.id_penerimarating WHERE meme.id_user=$iduser GROUP BY meme.id_user) AS SQ");
            if($res2->num_rows>0){
                $xxx=$res2->fetch_assoc();
                $payload["rating"]=(int)$xxx["rate"];
            }
            else{
                $payload["rating"]=0;
            }
                     
            //mencari urutan rating
        if($payload["rating"]>0){
            $q=$conn->query("SELECT rating.id_penerimarating,SUM(rating.nilai) AS total FROM rating GROUP BY rating.id_penerimarating ORDER BY total DESC;");
            $count=0;
            $urutan=0;
            while($h=$q->fetch_assoc()){
                $count=$count+1;
                if($h["id_penerimarating"]==$payload["id_user"]){
                    $urutan=$count;
                    break;
                }
            }
            $payload["ranking"]=$urutan;
        }
        else{
            $payload["ranking"]="No Ranking";
        }
            
        echo json_encode($payload);

        }
        else{
            $payload=new ArrayObject();
            echo json_encode($payload);
        }
    }

    if($context->aksi=="memuattotalkontenjasa"){
        if(isset($context->kategori)){
            echo 'kontrl';
        }
        else{
            include "../koneksi.php";
            $res=$conn->query("SELECT COUNT(*) AS total FROM jasa;")->fetch_assoc();
            $payload=array(
                'status'=>'ok',
                'data'=>array(
                    'total'=>$res["total"]
                )
                );
            echo json_encode($payload);
        }
    }


    if($context->aksi=="memuattotalkontenpermintaan"){
        if(isset($context->kategori)){
            echo 'kontrl';
        }
        else{
            include "../koneksi.php";
            $res=$conn->query("SELECT COUNT(*) AS total FROM permintaan;")->fetch_assoc();
            $payload=array(
                'status'=>'ok',
                'data'=>array(
                    'total'=>$res["total"]
                )
                );
            echo json_encode($payload);
        }
    }


    if($context->aksi=="memuatkontenpermintaan"){
        if(isset($context->id)){
            include "../koneksi.php";
            $id=mysqli_real_escape_string($conn,$context->id);
            $res=$conn->query("SELECT user.id_user,user.username,user.avatar,permintaan.id_permintaan,permintaan.judul,permintaan.deskripsi,permintaan.kategori,permintaan.label,permintaan.tanggaldibuat,permintaan.harga,permintaan.jangkawaktu,permintaan.status FROM permintaan INNER JOIN user ON permintaan.id_user=user.id_user WHERE permintaan.id_permintaan=$id;");
            if($res->num_rows>0){
                $fetch=$res->fetch_assoc();
                $data=new ArrayObject();
                $user=new ArrayObject();
                $thread=new ArrayObject();


                $thread["id"]=$fetch["id_permintaan"];
                $thread["judul"]=$fetch["judul"];
                $thread["deskripsi"]=$fetch["deskripsi"];
                $thread["tags"]=explode(",",$fetch["label"]);
                $thread["tgldibuat"]=$fetch["tanggaldibuat"];
                $thread["harga"]=$fetch["harga"];
                $thread["jangkawaktu"]=$fetch["jangkawaktu"];
                $thread["status"]=$fetch["status"];
                $thread["kategori"]=$fetch["kategori"];
                
                $user["avatar"]=$fetch["avatar"];
                $user["username"]=$fetch["username"];
                $user["id_user"]=$fetch["id_user"];

                ///mencari rating dari user
                $iduser=mysqli_real_escape_string($conn,$fetch["id_user"]);
                $res2=$conn->query("SELECT SQ.dua/SQ.satu AS rate FROM (SELECT COUNT(perating.username) AS satu,meme.username,SUM(rating.nilai) AS dua FROM rating INNER JOIN user AS perating ON perating.id_user=rating.id_pemberirating INNER JOIN user AS meme ON meme.id_user=rating.id_penerimarating WHERE meme.id_user=$iduser GROUP BY meme.id_user) AS SQ");
                if($res2->num_rows>0){
                    $xxx=$res2->fetch_assoc();
                    $user["rating"]=(int)$xxx["rate"];
                }
                else{
                    $user["rating"]=0;
                }

                //mencari urutan rating
                if($user["rating"]>0){
                    $q=$conn->query("SELECT rating.id_penerimarating,SUM(rating.nilai) AS total FROM rating GROUP BY rating.id_penerimarating ORDER BY total DESC;");
                    $count=0;
                    $urutan=0;
                    while($h=$q->fetch_assoc()){
                        $count=$count+1;
                        if($h["id_penerimarating"]==$user["id_user"]){
                            $urutan=$count;
                            break;
                        }
                    }
                    $user["ranking"]=$urutan;
                }
                else{
                    $user["ranking"]="No Ranking";
                }

                //// mencari jumlah user
                $queryJmlUser=$conn->query("SELECT COUNT(*) AS total FROM user")->fetch_assoc();
                $user["jumlahuser"]=$queryJmlUser["total"];
    
                //// mencari jumlah penaruh
                $idminta=$thread["id"];
                $q3=$conn->query("SELECT COUNT(*) AS total FROM penaruh WHERE id_permintaan='$idminta';");
    
                if($q3->num_rows>0){
                    $l=$q3->fetch_assoc();
                    $thread["penaruh"]=$l["total"];
                }
                else{
                    $thread["penaruh"]=0;
                }

                $data["user"]=$user;
                $data["thread"]=$thread;
                
                echo json_encode($data);


            }else{
                $payload=array();
                echo json_encode($payload);
            }
        }
        else{
            $data=array();
            $user=array(
                "id_user"=>"",
                "avatar"=>"",
                "username"=>"",
                "rating"=>0,
                "point"=>0,
                "ranking"=>"No Ranking",
                "jumlahuser"=>0
            );
            $thread=array(
                "id"=>"",
                "judul"=>"",
                "deskripsi"=>"",
                "tags"=>array(),
                "tgldibuat"=>"",
                "harga"=>"",
                "jangkawaktu"=>"",
                "status"=>"",
                "penaruh"=>0,
                "kategori"=>""
            );

           
        
            /////
            include('../koneksi.php');

            $limit_=mysqli_real_escape_string($conn,$context->limit);
            $offset_=mysqli_real_escape_string($conn,$context->offset);

            $res=$conn->query("SELECT user.id_user,user.username,user.avatar,permintaan.id_permintaan,permintaan.judul,permintaan.deskripsi,permintaan.kategori,permintaan.label,permintaan.tanggaldibuat,permintaan.harga,permintaan.jangkawaktu,permintaan.status FROM permintaan INNER JOIN user ON permintaan.id_user=user.id_user WHERE permintaan.status='published' ORDER BY permintaan.id_permintaan DESC LIMIT $limit_ OFFSET $offset_;");
            if($res->num_rows>0){
                while($row=$res->fetch_assoc()){
                    $user["avatar"]=$row["avatar"];
                    $user["username"]=$row["username"];
                    $user["id_user"]=$row["id_user"];
                    $thread["id"]=$row["id_permintaan"];
                    $thread["judul"]=$row["judul"];
                    $thread["deskripsi"]=$row["deskripsi"];
                    $thread["tags"]=explode(",",$row["label"]);
                    $thread["tgldibuat"]=$row["tanggaldibuat"];
                    $thread["harga"]=$row["harga"];
                    $thread["jangkawaktu"]=$row["jangkawaktu"];
                    $thread["status"]=$row["status"];
                    $thread["kategori"]=$row["kategori"];
        
                    ///mencari rating dari user
                    $iduser=mysqli_real_escape_string($conn,$row["id_user"]);
                    $res2=$conn->query("SELECT SQ.dua/SQ.satu AS rate FROM (SELECT COUNT(perating.username) AS satu,meme.username,SUM(rating.nilai) AS dua FROM rating INNER JOIN user AS perating ON perating.id_user=rating.id_pemberirating INNER JOIN user AS meme ON meme.id_user=rating.id_penerimarating WHERE meme.id_user=$iduser GROUP BY meme.id_user) AS SQ");
                    if($res2->num_rows>0){
                        $xxx=$res2->fetch_assoc();
                        $user["rating"]=(int)$xxx["rate"];
                    }
                    else{
                        $user["rating"]=0;
                    }
    
                    //mencari urutan rating
                    if($user["rating"]>0){
                        $q=$conn->query("SELECT rating.id_penerimarating,SUM(rating.nilai) AS total FROM rating GROUP BY rating.id_penerimarating ORDER BY total DESC;");
                        $count=0;
                        $urutan=0;
                        while($h=$q->fetch_assoc()){
                            $count=$count+1;
                            if($h["id_penerimarating"]==$user["id_user"]){
                                $urutan=$count;
                                break;
                            }
                        }
                        $user["ranking"]=$urutan;
                    }
                    else{
                        $user["ranking"]="No Ranking";
                    }
    
                    //// mencari jumlah user
                    $queryJmlUser=$conn->query("SELECT COUNT(*) AS total FROM user")->fetch_assoc();
                    $user["jumlahuser"]=$queryJmlUser["total"];
        
                    //// mencari jumlah penaruh
                    $idminta=$thread["id"];
                    $q3=$conn->query("SELECT COUNT(*) AS total FROM penaruh WHERE id_permintaan='$idminta';");
        
                    if($q3->num_rows>0){
                        $l=$q3->fetch_assoc();
                        $thread["penaruh"]=$l["total"];
                    }
                    else{
                        $thread["penaruh"]=0;
                    }
                    
                    
                    $payload=new ArrayObject();
                    $payload["user"]=$user;
                    $payload["thread"]=$thread;
        
                    array_push($data,$payload);
                }
               
                echo json_encode($data);
            }
        }
       
 
    }
    /////
}
?>