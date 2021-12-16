<?php

include_once '../utils/validation.php';
//kiem tra email hop le



if (count($_POST) > 0) {

require '../utils/db.php';

$username = $_POST["username"];
$password = $_POST["password"];

$stmt = $conn->prepare("SELECT * FROM quantrivien");
$stmt->execute();
$a =  $stmt->fetchALL(PDO::FETCH_ASSOC);
  if($a)
  {
    foreach ($a as $row ) {
      if ($username == $row["username"] && $password == $row["password"]) {
       session_start();
       $_SESSION["maqtv"] = $row["maqtv"];
       $_SESSION["tenqtv"] = $row["tenqtv"];
       $_SESSION["email"] = $row["email"];
       $_SESSION["sdt"] = $row["sdt"];
       $_SESSION["username"] = $row["username"];
       $_SESSION["password"] = $row["password"];
       
       header("Location: ../view/user.php");
       
    }
    
    else
    {
      
      $message = "Sai thông tin đăng nhập";
      $url = "../view/login.php";
      echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
      
    }
    }
  }





    
}
    

?>

