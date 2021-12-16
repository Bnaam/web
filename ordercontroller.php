<?php
require '../utils/db.php';


session_start();
if(isset($_SESSION["username"]))
{
	$id=$_SESSION["maqtv"];
}

function getSLByID($id)
{
    require '../utils/db.php';
  $stmt = $conn->prepare("SELECT * FROM sanpham where masp =:id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  $sp =   $stmt->fetch(PDO::FETCH_ASSOC);
  return $sp;
 
  
}

function updateSLByID($id,$SL)
{
  require '../utils/db.php';
  $stmt = $conn->prepare("UPDATE sanpham SET soluong =:soluong where masp =:id");
  $stmt->bindParam(':soluong', $SL);
  $stmt->bindParam(':id', $id);
  return $stmt->execute();
}


function getTongSLByID($id)
{
    require '../utils/db.php';
  $stmt = $conn->prepare("SELECT `mahang`,SUM(`soluong`) AS `soluong` FROM `sanpham`
    where mahang =:id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  $sp =   $stmt->fetch(PDO::FETCH_ASSOC);
  return $sp;
 
  
}




function updateSLDMByID($id,$SL)
{
require '../utils/db.php';
  $stmt = $conn->prepare("UPDATE danhmucsp SET soluong =:soluong where madm =:id");
  $stmt->bindParam(':soluong', $SL);
  $stmt->bindParam(':id', $id);
  return $stmt->execute();
  

}


if(count($_POST) > 0)
{
$txt_masp = $_POST["txt_masp"];

$txt_Soluong = $_POST["txt_Soluong"];
$date_giaohang = $_POST["date_giaohang"];
$select = $_POST["select"];

$today = date("d-m-Y");

$btn_group = $_POST['btn_order_group'];
	switch ($btn_group) {

        case "update":
		$idedit =  $_GET['id'];
		
		
		if(strtotime($today)<strtotime($date_giaohang)){
		$stmt = $conn->prepare("UPDATE donhang Set ngaygiaohang=:ngaygiaohang ,tinhtrang=:tinhtrang,maqtv=:maqtv where madh=:madh");
		$stmt->bindParam(':ngaygiaohang', $date_giaohang);
		$stmt->bindParam(':tinhtrang', $select);
		$stmt->bindParam(':maqtv', $id);
		$stmt->bindParam(':madh', $idedit);
		$stmt->execute();

		if($select == "Đã giao")
		{
			$sp = getSLByID($txt_masp);
			$SL = $sp["soluong"]-$txt_Soluong;
			
			updateSLByID($sp["masp"],$SL);

			$dm = getTongSLByID($sp["mahang"]);
    
      		updateSLDMByID($sp["mahang"],$dm["soluong"]);
		}

		$message = "Cập nhật thành công";
		$url = "../view/order.php";
		echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
		}
		else
		{
		$message = "Cập nhật thất bại";
		$url = "../view/order.php";
		echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
		}
         break;
     }
 }
?>