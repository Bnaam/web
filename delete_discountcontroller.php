<?php



function delete($id)
{


  require '../utils/db.php';
  $stmt = $conn->prepare("DELETE FROM khuyenmai where makm =:id");
  $stmt->bindParam(':id', $id);
  return $stmt->execute();
 
}


$id = $_GET['id'];

if(isset($id))
{

   delete($id);
   $message = "Xóa thành công";
  $url = "../view/discount.php";
  echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
}  else
  {
    $message = "Không thể xóa";
  $url = "../view/discount.php";
  echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
  }
	




?>