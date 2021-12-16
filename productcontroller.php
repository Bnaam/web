<?php

function ktTrung($tensp,$mau)
{
    require '../utils/db.php';
    $sql = "SELECT * FROM sanpham ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $sp =  $stmt->fetchALL(PDO::FETCH_ASSOC);
    if($sp)
    {
    foreach ($sp as $row) {
        if($row["tensp"]==$tensp && $row["mausac"]==$mau )
        {
            return $row;
            break;
        }
        
    }
}
}




function getHinh($tensp,$mau,$dungluong,$ram)
{
    require '../utils/db.php';
    $sql = "SELECT * FROM sanpham ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $sp =  $stmt->fetchALL(PDO::FETCH_ASSOC);
    if($sp)
        {
    foreach ($sp as $row) {
        if($row["tensp"]==$tensp && $row["mausac"]==$mau && $row["dungluong"]==$dungluong && $row["ram"]==$ram)
        {
            return $row["hinh"];
            break;
        }
        
    }
}
}


function getSLByID($id)
{
    require '../utils/db.php';
  $stmt = $conn->prepare("SELECT `mahang`,SUM(`soluong`) AS `soluong` FROM `sanpham`
    where mahang =:id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  $sp =   $stmt->fetch(PDO::FETCH_ASSOC);
  return $sp;
 
  
}




function updateSLByID($id,$SL)
{
require '../utils/db.php';
  $stmt = $conn->prepare("UPDATE danhmucsp SET soluong =:soluong where madm =:id");
  $stmt->bindParam(':soluong', $SL);
  $stmt->bindParam(':id', $id);
  return $stmt->execute();
  

}


function insertProduct($ten, $sl, $gia, $mau,$dungluong,$ram,$mota,$hang,$hinh,$mancc) {
   require '../utils/db.php';
   $stmt = $conn->prepare("INSERT INTO sanpham (tensp, soluong, gia, mausac, dungluong,ram, mota, mahang, hinh,mancc) VALUES (:tensp, :soluong, :gia, :mausac, :dungluong,:ram, :mota, :mahang, :hinh, :mancc)");
$stmt->bindParam(':tensp', $ten);
$stmt->bindParam(':soluong', $sl);
$stmt->bindParam(':gia', $gia);
$stmt->bindParam(':mausac', $mau);
$stmt->bindParam(':dungluong', $dungluong);
$stmt->bindParam(':ram', $ram);
$stmt->bindParam(':mota', $mota);
$stmt->bindParam(':mahang', $hang);
$stmt->bindParam(':hinh', $hinh);
$stmt->bindParam(':mancc', $mancc);

return $stmt->execute();
}

function updateProduct($ten, $sl, $gia, $mau,$dungluong,$ram,$mota,$hang,$hinh,$id,$mancc) {
   require '../utils/db.php';
   $stmt = $conn->prepare("UPDATE sanpham SET tensp=:tensp, soluong=:soluong, gia=:gia, mausac=:mausac, dungluong=:dungluong, ram=:ram, mota=:mota, mahang=:mahang, hinh=:hinh, mancc=:mancc where masp =:id");
$stmt->bindParam(':tensp', $ten);
$stmt->bindParam(':soluong', $sl);
$stmt->bindParam(':gia', $gia);
$stmt->bindParam(':mausac', $mau);
$stmt->bindParam(':dungluong', $dungluong);
$stmt->bindParam(':ram', $ram);
$stmt->bindParam(':mota', $mota);
$stmt->bindParam(':mahang', $hang);
$stmt->bindParam(':hinh', $hinh);
$stmt->bindParam(':mancc', $mancc);
$stmt->bindParam(':id', $id);

return $stmt->execute();
}




if(count($_POST) > 0)
{


$txt_tensp = $_POST["txt_tensp"];
$txt_soluongsp = $_POST["txt_soluongsp"];
$txt_Gia = $_POST["txt_Gia"];
$txt_mau = $_POST["txt_mau"];
$txt_dungluong = $_POST["select_dungluong"];
$txt_ram = $_POST["select_ram"];
$txt_mota = $_POST["txt_mota"];
$select = $_POST["select"];
$select_nhacungcap = $_POST["select_nhacungcap"];
$file_avatar = $_FILES["file_avatar"]["name"];


$ktTrung = ktTrung($txt_tensp,$txt_mau);


$id = $ktTrung["masp"];




$btn_group = $_POST['btn_product_group'];
    switch ($btn_group) {

        case "create":


if(isset($ktTrung["masp"]))
{
    header("Location: ../view/productedit.php?id=".$ktTrung["masp"]);
}
else
{
    insertProduct($txt_tensp,$txt_soluongsp,$txt_Gia,$txt_mau,$txt_dungluong,$txt_ram,$txt_mota,$select,$file_avatar,$select_nhacungcap);
    $sp = getSLByID($select);
    
      updateSLByID($sp["mahang"],$sp["soluong"]);

      $message = "Thêm thành công";
      $url = "../view/product.php";
      echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
}
        break;
        case "update":



if($file_avatar == null)
{
    
    
  
    $hinh = getHinh($ktTrung["tensp"],$ktTrung["mausac"],$ktTrung["dungluong"],$ktTrung["ram"]);
    updateProduct($txt_tensp,$txt_soluongsp,$txt_Gia,$txt_mau,$txt_dungluong,$txt_ram,$txt_mota,$select,$hinh,$id,$select_nhacungcap);
    $sp = getSLByID($select);
    
      updateSLByID($sp["mahang"],$sp["soluong"]);

      $message = "Cập nhật thành công";
      $url = "../view/product.php";
      echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
  

}else{
   
    updateProduct($txt_tensp,$txt_soluongsp,$txt_Gia,$txt_mau,$txt_dungluong,$txt_ram,$txt_mota,$select,$file_avatar,$id,$select_nhacungcap);

        $sp = getSLByID($select);
    
      updateSLByID($sp["mahang"],$sp["soluong"]);

      $message = "Cập nhật thành công";
      $url = "../view/product.php";
      echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
  }

        break;
}

        
}
    

?>