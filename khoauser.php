<?php
function getUserById($id)
{
require '../utils/db.php';
        $stmt = $conn->prepare("SELECT makh,tinhtrang FROM khachhang where makh=:id");
        $stmt->bindParam(':id', $id);
                // insert a row
		$stmt->execute();
        $user= $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;   
    	$conn = null;  
}

function updateUser($id,$tinhtrang)
{
require '../utils/db.php';
if($tinhtrang == "Hoạt động")
{
	$tinhtrang = "Khóa";
}else{
	$tinhtrang = "Hoạt động";
}

   
        $stmt = $conn->prepare("UPDATE khachhang SET tinhtrang =:tinhtrang where makh =:id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':tinhtrang', $tinhtrang);
                // insert a row
		$user = $stmt->execute();
        return $user;
    	$conn = null;
}
$id = $_GET['id'];
$user = getUserById($id);

updateUser($user["makh"],$user["tinhtrang"]);
header("Location: ../view/user.php");

?>