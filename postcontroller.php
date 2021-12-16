<?php


session_start();
if(isset($_SESSION["username"]))
{
	$id=$_SESSION["email"];
}

require '../utils/db.php';



function getID($email)
{
	require '../utils/db.php';
	$stmt = $conn->prepare("SELECT * FROM quantrivien");
	$stmt->execute();
	$users =  $stmt->fetchALL(PDO::FETCH_ASSOC);

	if($users)
	{
		foreach ($users as $user) {
			if($user["email"]==$email)
			{
				return $user["maqtv"];
				break;
			}
		}
	}
	
} 

function getIDKM($tieude)
{
	require '../utils/db.php';
	$stmt = $conn->prepare("SELECT * FROM baiviet");
	$stmt->execute();
	$users =    $stmt->fetchALL(PDO::FETCH_ASSOC);

	if($users)
	{
		foreach ($users as $giatri) {
			if($giatri["tieude"]==$tieude)
			{
				return $giatri["mabv"];
				break;
			}
		}
	}
	
} 


if(count($_POST) > 0)
{

$txt_tenbv = $_POST["txt_tenbv"];
$txt_noidung = $_POST["txt_noidung"];


$maqtv = getID($id);

$mabv = getIDKM($txt_tenbv);
$btn_group = $_POST['btn_post_group'];
	switch ($btn_group) {

        case "create":
$file_avatar = $_FILES["file_avatar"]["name"];
if($mabv == null)
{
$stmt = $conn->prepare("INSERT INTO baiviet (tieude,noidung,maqtv,hinh) VALUES (:tieude, :noidung, :maqtv, :hinh)");
$stmt->bindParam(':tieude', $txt_tenbv);
$stmt->bindParam(':noidung', $txt_noidung);
$stmt->bindParam(':maqtv', $maqtv);
$stmt->bindParam(':hinh', $file_avatar);
$stmt->execute();


	$message = "Thêm thành công";
      $url = "../view/post.php";
      echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
}
else
{
header("Location: ../view/postedit.php?id=".$mabv);
}


         die;
            break;
         case "update":
         $idedit =  $_GET['id'];
$stmt = $conn->prepare("UPDATE baiviet Set tieude=:tieude ,noidung=:noidung,maqtv=:maqtv where mabv=:mabv");
$stmt->bindParam(':tieude', $txt_tenbv);
$stmt->bindParam(':noidung', $txt_noidung);
$stmt->bindParam(':maqtv', $maqtv);
$stmt->bindParam(':mabv', $idedit);
$stmt->execute();


	$message = "Cập nhật thành công";
      $url = "../view/post.php";
      echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
           

            die;
            break;
            
           
        default :
            break;
    }






}


?>