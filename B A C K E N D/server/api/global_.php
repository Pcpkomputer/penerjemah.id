<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

if(isset($_POST)){
    $context=json_decode($_POST["params"]);

    if($context->aksi=="memuattotaluser-withcategory"){
        include "../koneksi.php";
        $kategori=mysqli_real_escape_string($conn,$context->kategori);
            $q=$conn->query("SELECT COUNT(DISTINCT(user.username)) AS total FROM permintaan INNER JOIN user ON permintaan.id_user=user.id_user WHERE permintaan.kategori='$kategori';");
            if($q->num_rows>0){
                $hasil=$q->fetch_assoc();
                $payload=new ArrayObject();
                $payload["total"]=$hasil["total"];
                echo json_encode($payload);
            }
        }


    if($context->aksi=="memuatkontenuser-withcategory"){
        include "../koneksi.php";
        $limit=mysqli_real_escape_string($conn,$context->limit);
        $offset=mysqli_real_escape_string($conn,$context->offset);
        $kategori=mysqli_real_escape_string($conn,$context->kategori);
        $q=$conn->query("SELECT user.id_user,user.avatar,user.username FROM user WHERE user.username IN (SELECT DISTINCT(user.username) FROM permintaan INNER JOIN user ON permintaan.id_user=user.id_user WHERE permintaan.kategori='$kategori') ORDER BY user.id_user DESC LIMIT $limit OFFSET $offset;");
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


    if($context->aksi=="memuattotalkontenjasa-withcategory"){
        include "../koneksi.php";
        $kategori=mysqli_real_escape_string($conn,$context->kategori);
        $res=$conn->query("SELECT COUNT(*) AS total FROM jasa WHERE jasa.label LIKE '%$kategori%';")->fetch_assoc();
        $payload=array(
            'status'=>'ok',
            'data'=>array(
                'total'=>(int)$res["total"]
            )
            );
        echo json_encode($payload);
    }

    if($context->aksi=="memuatkontenjasa-withcategory"){
        include "../koneksi.php";
        $limit=mysqli_real_escape_string($conn,$context->limit);
        $offset=mysqli_real_escape_string($conn,$context->offset);
        $kategori=mysqli_real_escape_string($conn,$context->kategori);
        $qjasa=$conn->query("SELECT jasa.judul,jasa.id_jasa,jasa.tanggaldibuat,jasa.label,user.id_user,user.avatar,user.username,jasa.harga,jasa.waktupengerjaan,jasa.deskripsi,jasa.background FROM jasa INNER JOIN user ON jasa.id_user=user.id_user WHERE jasa.label LIKE '%$kategori%' LIMIT $limit OFFSET $offset;");
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

    
    if($context->aksi=="memuattotalkontenpermintaan-withcategory"){
    
            include "../koneksi.php";
            $kategori=mysqli_real_escape_string($conn,$context->kategori);
            $res=$conn->query("SELECT COUNT(*) AS total FROM permintaan WHERE permintaan.kategori='$kategori';")->fetch_assoc();
            $payload=array(
                'status'=>'ok',
                'data'=>array(
                    'total'=>$res["total"]
                )
                );
            echo json_encode($payload);
    }


    if($context->aksi=="memuatkontenpermintaan-withcategory"){
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
        $kategori_=mysqli_real_escape_string($conn,$context->kategori);

        $res=$conn->query("SELECT user.id_user,user.username,user.avatar,permintaan.id_permintaan,permintaan.judul,permintaan.deskripsi,permintaan.kategori,permintaan.label,permintaan.tanggaldibuat,permintaan.harga,permintaan.jangkawaktu,permintaan.status FROM permintaan INNER JOIN user ON permintaan.id_user=user.id_user WHERE permintaan.status='published' AND permintaan.kategori='$kategori_' ORDER BY permintaan.id_permintaan DESC LIMIT $limit_ OFFSET $offset_;");
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
?>