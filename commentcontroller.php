<?php


$id = $_GET['id'];

if(isset($id))
{
	function delete($id)
{
 require '../utils/db.php';
  $stmt = $conn->prepare("DELETE FROM binhluan where mabl =:id");
  $stmt->bindParam(':id', $id);
  return $stmt->execute();
} 
  
  delete($id);
  $message = "Xóa thành công";
  $url = "../view/comment.php";
  echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
}
else
{
 $message = "Xóa thất bại";
  $url = "../view/comment.php";
  echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
}



?>