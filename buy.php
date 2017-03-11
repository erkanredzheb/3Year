<?php

session_start();
$id = $_GET['id'];

if(!isset($_SESSION["user"]))
{
	header("Location: login.php");
}


require("connectDB.php");
$dbname = "3year";
mysqli_select_db($conn, $dbname);



$stmt = $conn->prepare("SELECT price,user_id FROM product_info WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
{	
    	$price = $row['price'];
    	$sellerID = $row['user_id'];
    	
}

$userID = $_SESSION["user"];
$stmt = $conn->prepare("SELECT acc_balance FROM user_info WHERE username = ?");
$stmt->bind_param("s", $userID);
$stmt->execute();
$result = $stmt->get_result();

while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
{	
    	$accBalBuyer = $row['acc_balance'];
    	
}

$stmt = $conn->prepare("SELECT acc_balance FROM user_info WHERE username = ?");
$stmt->bind_param("s", $sellerID);
$stmt->execute();
$result = $stmt->get_result();

while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
{	
    	$accBalSeller = $row['acc_balance'];
    	
}

$newAccBalBuyer = $accBalBuyer - $price;
$stmt = $conn->prepare("UPDATE user_info SET acc_balance = ? WHERE username = ?");
$stmt->bind_param("is", $newAccBalBuyer, $userID);
$stmt->execute();


$newAccBalSeller = $accBalSeller + $price;
$stmt = $conn->prepare("UPDATE user_info SET acc_balance = ? WHERE username = ?");
$stmt->bind_param("is", $newAccBalSeller, $sellerID);
$stmt->execute();

$stmt = $conn->prepare("UPDATE product_info SET boughtby = ? WHERE id = ?");
$stmt->bind_param("si", $userID, $id);
$stmt->execute();



$stmt->close();
$conn->close();

?>