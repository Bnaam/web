<?php

include_once '../model/DMSP.php';
require '../utils/db.php';
function insertDMSP($dmsp) {
		$txt_tendm = $dmsp->get_tendm();
		$txt_soluong = $dmsp->get_soluong();

		require '../utils/db.php';
		$stmt = $conn->prepare("INSERT INTO danhmucsp (tendm,soluong) VALUES (:tendm,:soluong)");
		$stmt->bindParam(':tendm', $txt_tendm);
		$stmt->bindParam(':soluong', $txt_soluong);
		$stmt->execute();
}




function getTenDM($tendm)
{
	require '../utils/db.php';
	$stmt = $conn->prepare("SELECT madm,tendm FROM danhmucsp");
	$stmt->execute();
	$users =    $stmt->fetchALL(PDO::FETCH_ASSOC);
	// use exec() because no results are returned
	if($users)
	{
	foreach ($users as $giatri) {
		if($giatri["tendm"]==$tendm)
		{
			return $giatri["tendm"];
		}
		else
		{
			return 1;
			break;
		}
	}
	}
	
} 


function getIDDM($tendm)
{
	require '../utils/db.php';
	$stmt = $conn->prepare("SELECT madm,tendm FROM danhmucsp");
	$stmt->execute();
	$users =    $stmt->fetchALL(PDO::FETCH_ASSOC);

	if($users)
	{
		foreach ($users as $giatri) {
			if($giatri["tendm"]==$tendm)
			{
				return $giatri["madm"];
			}
		}
	}
	
} 



$txt_tendm = $_POST["txt_tendm"];
$txt_soluong = $_POST["txt_soluong"];


$tendm=getTenDM($txt_tendm);
$iddm=getIDDM($txt_tendm);

$btn_group = $_POST['btn_productcatalog_group'];
	switch ($btn_group) {

        case "create":
if($txt_soluong >= 0)
{
	if($tendm == 1)
	{
		$dmsp = new DMSP($txt_tendm,$txt_soluong);
		insertDMSP($dmsp);
		
		$message = "Thêm thành công";
		$url = "../view/productcatalog.php";
		echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
		
	}
	else
	{
		header("Location: ../view/productcatalogedit.php?id=".$iddm['madm']);
	}
}
else
{
		$message = "Thêm thất bại";
		$url = "../view/productcatalogadd.php";
		echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
}

        
        break;

        case "update":
$id = $iddm;
     
if($txt_soluong >= 0)
{
$stmt = $conn->prepare("UPDATE danhmucsp Set tendm=:tendm ,soluong=:soluong where madm=:madm");
$stmt->bindParam(':tendm', $txt_tendm);
$stmt->bindParam(':soluong', $txt_soluong);
$stmt->bindParam(':madm', $id );
$stmt->execute();

	$message = "Cập nhật thông tin thành công";
	$url = "../view/productcatalog.php";
	echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
}
else
{
	$message = "Cập nhật thông tin thất bại";
	$url = "../view/productcatalogedit.php?id=".$id;
	echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
}
        
        break;


        default :
            break;
        }



?>