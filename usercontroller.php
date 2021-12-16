<?php


function getID($id)
{
  require '../utils/db.php';

  $stmt = $conn->prepare("SELECT * FROM quantrivien ");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  $a =  $stmt->fetchALL(PDO::FETCH_ASSOC);
  if($a)
  {
    foreach ($a as $row ) {
      if($row["email"] ==$id )
      {
        return $row["maqtv"];
      }
    }
  }
} 

function updatePasswordByEmail($email,$newpass)
{
require '../utils/db.php';
  $stmt = $conn->prepare("UPDATE quantrivien SET password =:newpass where email =:email");
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':newpass', $newpass);
  return $stmt->execute();

  $conn = null; 

}

function updateUser($tenqtv,$email,$user,$id)
{
require '../utils/db.php';
  $stmt = $conn->prepare("UPDATE quantrivien SET tenqtv =:tenqtv, username =:username, email =:email where maqtv =:maqtv");
  $stmt->bindParam(':tenqtv', $tenqtv);
  $stmt->bindParam(':username', $user);
  $stmt->bindParam(':email', $email);
  
  
  $stmt->bindParam(':maqtv', $id);
  return $stmt->execute();

  $conn = null; 

}

if(count($_POST) > 0)
{
$txt_name = $_POST["txt_name"];
$txt_email = $_POST["txt_email"];

$txt_username = $_POST["txt_username"];

$txt_pass = $_POST["txt_pass"];
$txt_newpass = $_POST["txt_newpass"];

$user = getID($txt_email);

$btn_group = $_POST['btn_user_group'];
	switch ($btn_group) {

        case "update":

updateUser($txt_name,$txt_email,$txt_username,$user);

	$message = "Sửa thông tin thành công";
	$url = "../view/profile.php";
	echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";

        break;

        case "reset":

if($txt_newpass != null){

updatePasswordByEmail($txt_email,$txt_newpass);

	$message = "Đổi mật khẩu thành công";
	$url = "../view/profile.php";
	echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
}
else
{
	$message = "Đổi mật khẩu thất bại";
	$url = "../view/profile.php";
	echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";

}


        break;
}

}
?>