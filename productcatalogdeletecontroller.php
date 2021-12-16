<?php

function getSL($id)
{
  require '../utils/db.php';

  $stmt = $conn->prepare("SELECT * FROM danhmucsp ");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  $a =  $stmt->fetchALL(PDO::FETCH_ASSOC);
  if($a)
  {
    foreach ($a as $row ) {
      if($row["madm"] ==$id )
      {
        return $row["soluong"];
      }
    }
  }

  
        
} 

function delete($id)
{
require '../utils/db.php';
  $stmt = $conn->prepare("DELETE FROM danhmucsp where madm =:id");
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
  $url = "../view/productcatalog.php";
  echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>"; 
  }
  else
  {
    $message = "Không thể xóa";
  $url = "../view/productcatalog.php";
  echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>"; 
  }
	
}



?>