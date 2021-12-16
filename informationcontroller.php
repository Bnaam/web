<?php

session_start();
if(isset($_SESSION["username"]))
{
	$id=$_SESSION["email"];
}


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


function update($tench,$diachi,$sdt,$email,$id)
{
  require '../utils/db.php';
  $stmt = $conn->prepare("UPDATE thongtincuahang SET diachi =:diachi, sdt =:sdt, email =:email, maqtv =:id where tench =:tench");
  $stmt->bindParam(':diachi', $diachi);
  $stmt->bindParam(':sdt', $sdt);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':id', $id);
  
  
  $stmt->bindParam(':tench', $tench);
  return $stmt->execute();

  $conn = null; 

}

if(count($_POST) > 0)
{

$maqtv = getID($id);
$txt_tench = $_POST["txt_tench"];

$txt_diachi = $_POST["txt_diachi"];
$txt_sdt = $_POST["txt_sdt"];
$txt_email = $_POST["txt_email"];

update($txt_tench,$txt_diachi,$txt_sdt,$txt_email,$maqtv);
	  $message = "Cập nhật thành công";
      $url = "../view/information.php";
      echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
}

?>