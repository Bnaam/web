<?php

function getSL($id)
{
  require '../utils/db.php';

  $stmt = $conn->prepare("SELECT * FROM sanpham ");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  $a =  $stmt->fetchALL(PDO::FETCH_ASSOC);
  if($a)
  {
    foreach ($a as $row ) {
      if($row["masp"] ==$id )
      {
        return $row["soluong"];
      }
    }
  }

  
        
} 

function delete($id)
{
require '../utils/db.php';
  $stmt = $conn->prepare("DELETE FROM sanpham where masp =:id");
  $stmt->bindParam(':id', $id);
  return $stmt->execute();
} 



$id = $_GET['id'];



if(isset($id))
{
  if(getSL($id)==0)
  {
    
   delete($id);

   $message = "Xóa thành công";
  $url = "../view/product.php";
  echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>"; 
  }
  else
  {
    $message = "Không thể xóa";
  $url = "../view/product.php";
  echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>"; 
  }
	
}



?>