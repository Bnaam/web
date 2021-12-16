<?php


function getIDByName($ten)
{
	require '../utils/db.php';
    $sql = "SELECT * FROM nhacungcap";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $banner =  $stmt->fetchALL(PDO::FETCH_ASSOC);
    if($banner)
    {
    foreach ($banner as $row) {
        if($row["tenncc"]==$ten)
        {
            return $row["mancc"];
            break;
        }
        
    }
}
}

if(count($_POST) > 0)
{
$txt_tencc = $_POST["txt_tencc"];
$txt_diachi = $_POST["txt_diachi"];
$txt_sdt = $_POST["txt_sdt"];

$id = getIDByName($txt_tencc);

$btn_group = $_POST['btn_supplier_group'];
	switch ($btn_group) {

        case "create":
       
if(isset($id))
	{
		
		header("Location: ../view/supplieredit.php?id=".$id);
	}
	else
	{
		require '../utils/db.php';

		$stmt = $conn->prepare("INSERT INTO nhacungcap (tenncc,diachi,sdt) VALUES (:tenncc,:diachi,:sdt)");
		$stmt->bindParam(':tenncc', $txt_tencc);
		$stmt->bindParam(':diachi', $txt_diachi);
		$stmt->bindParam(':sdt', $txt_sdt);
		$stmt->execute();

		
		$message = "Thêm thành công";
	    $url = "../view/supplier.php";
	    echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
	}


        die;
        break;

        case "update":
       
        $idedit = $_GET['id'];

require '../utils/db.php';
$stmt = $conn->prepare("UPDATE nhacungcap SET tenncc =:tenncc, diachi =:diachi, sdt=:sdt where mancc =:mancc");
$stmt->bindParam(':tenncc', $txt_tencc);
$stmt->bindParam(':diachi', $txt_diachi);
$stmt->bindParam(':sdt', $txt_sdt);
$stmt->bindParam(':mancc', $idedit);
$stmt->execute();


$message = "Cập nhật thông tin thành công";
$url = "../view/supplier.php";
echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
                  
  
        die;
        break;


        default :
            break;
        }
}else
{
	function delete($id)
{
 require '../utils/db.php';
  $stmt = $conn->prepare("DELETE FROM nhacungcap where mancc =:id");
  $stmt->bindParam(':id', $id);
  return $stmt->execute();
} 

  function getSLByID($id)
  {
    require '../utils/db.php';
    $sql = "SELECT Count(*) as SL FROM sanpham where mancc=:id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return  $stmt->fetch(PDO::FETCH_ASSOC);    
  }


$id = $_GET['id'];

if(isset($id))
{
  $SL = getSLByID($id);
  
  
      if($SL["SL"] > 0)
      {
        $message = "Xóa thất bại";
        $url = "../view/supplier.php";
        echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
      }else
      {
        delete($id);
        $message = "Xóa thành công";
        $url = "../view/supplier.php";
        echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
      }
  
}
else
{
 $message = "Xóa thất bại";
  $url = "../view/supplier.php";
  echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";}
}


?>