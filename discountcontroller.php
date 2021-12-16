<?php

require '../utils/db.php';

function ktTrungMaSP($id)
{
	require '../utils/db.php';
	$sql = "SELECT * FROM khuyenmai ";
	
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$a =  $stmt->fetchALL(PDO::FETCH_ASSOC);
	if($a)
	{
	foreach ($a as $row) {
		if($row["masp"]==$id)
		{
			return 1;
			break;
		}
		
	}
}
}



function getIDKM($masp)
{
	require '../utils/db.php';
	$stmt = $conn->prepare("SELECT makm,masp FROM khuyenmai");
	$stmt->execute();
	$users =    $stmt->fetchALL(PDO::FETCH_ASSOC);

	if($users)
	{
		foreach ($users as $giatri) {
			if($giatri["masp"]==$masp)
			{
				return $giatri["makm"];
				break;
			}
		}
	}
	
} 

$date_ketthuc = $_POST["date_ketthuc"];
$txt_Gia = $_POST["txt_Gia"];
$select = $_POST["select"];

$today = date("d-m-Y");
$masp =  ktTrungMaSP($select);

$makm = getIDKM($select);

$btn_group = $_POST['btn_discount_group'];
	switch ($btn_group) {

        case "create":

if(strtotime($today)<strtotime($date_ketthuc)){
if($masp != 1)
{
$stmt = $conn->prepare("INSERT INTO khuyenmai (ngayketthuc,giakm,masp) VALUES (:ngayketthuc, :giakm, :masp)");
$stmt->bindParam(':ngayketthuc', $date_ketthuc);
$stmt->bindParam(':giakm', $txt_Gia);
$stmt->bindParam(':masp', $select);
$stmt->execute();

	
	
	$message = "Thêm thành công";
      $url = "../view/discount.php";
      echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
}
else
{
header("Location: ../view/discountedit.php?id=".$makm);
}

}
else
{
	$message = "Thêm thất bại";
      $url = "../view/discount.php";
      echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
}
            die;
            break;
         case "update":
if(strtotime($today)<strtotime($date_ketthuc))
{
$stmt = $conn->prepare("UPDATE khuyenmai Set ngayketthuc=:ngayketthuc ,giakm=:giakm where masp=:masp");
$stmt->bindParam(':ngayketthuc', $date_ketthuc);
$stmt->bindParam(':giakm', $txt_Gia);
$stmt->bindParam(':masp', $select);
$stmt->execute();


	$message = "Cập nhật thành công";
      $url = "../view/discount.php";
      echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
}else
{
	$message = "Cập nhật thất bại";
      $url = "../view/discount.php";
      echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
}
           

            die;
            break;
            
           
        default :
            break;
    }










?>