<?php


session_start();
if(isset($_SESSION["username"]))
{
	$idqtv=$_SESSION["maqtv"];
}

function getIDByURL($url)
{
	require '../utils/db.php';
    $sql = "SELECT * FROM banner";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $banner =  $stmt->fetchALL(PDO::FETCH_ASSOC);
    if($banner)
    {
    foreach ($banner as $row) {
        if($row["url"]==$url)
        {
            return $row["mabanner"];
            break;
        }
        
    }
}
}

function getIDByImg($img)
{
	require '../utils/db.php';
    $sql = "SELECT * FROM banner";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $banner =  $stmt->fetchALL(PDO::FETCH_ASSOC);
    if($banner)
    {
    foreach ($banner as $row) {
        if($row["hinhanh"]==$img)
        {
            return $row["mabanner"];
            break;
        }
        
    }
}
}




if(count($_POST) > 0)
{
$txt_url = $_POST["txt_url"];



$id = getIDByURL($txt_url);

$btn_group = $_POST['btn_banner_group'];
	switch ($btn_group) {

        case "create":
        $file_avatar = $_FILES["file_avatar"]["name"];
if(isset($id))
	{
		
		header("Location: ../view/banneredit.php?id=".$id);
	}
	else
	{
		require '../utils/db.php';

		$stmt = $conn->prepare("INSERT INTO banner (url,hinhanh,maqtv) VALUES (:url,:hinhanh,:maqtv)");
		$stmt->bindParam(':url', $txt_url);
		$stmt->bindParam(':hinhanh', $file_avatar);
		$stmt->bindParam(':maqtv', $idqtv);
		$stmt->execute();

		
		$message = "Thêm thành công";
	    $url = "../view/banner.php";
	    echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
	}


        die;
        break;

        case "update":
       
        $idedit = $_GET['id'];


        
	
 	
        	       	require '../utils/db.php';
$stmt = $conn->prepare("UPDATE banner SET url =:url, maqtv =:id where mabanner =:mabanner");
$stmt->bindParam(':url', $txt_url);
$stmt->bindParam(':id', $idqtv);
$stmt->bindParam(':mabanner', $idedit);
$stmt->execute();


$message = "Cập nhật thông tin thành công";
$url = "../view/banner.php";
echo "<script type='text/javascript'>alert('$message');window.location = '$url';</script>";
                  
  


	

        die;
        break;


        default :
            break;
        }
}
?>