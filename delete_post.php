<?php

function delete($id)
{
require '../utils/db.php';
  $stmt = $conn->prepare("DELETE FROM baiviet where mabv =:id");
  $stmt->bindParam(':id', $id);
  return $stmt->execute();
} 



$id = $_GET['id'];

if(isset($id))
{
  
    
   delete($id);
  $message = "Xóa thành công";
  $url = "../view/post.php";
  echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
}
else
{
 $message = "Xóa thất bại";
  $url = "../view/post.php";
  echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";}


?>