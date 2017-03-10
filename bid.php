<?php
//error_reporting(0);
session_start();

$cookie_name = "a";

if(strcmp($cookie_name, "a") == 0)
{
  $cookie_name = $_SESSION['user'];
  $cookie_value = $_GET['id'];
  setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
}


if(!isset($_SESSION["user"]))
{
	header("Location: login.php");
}

if(isset($_POST['placebid']))
{
	$thebid = ($_POST['thebid']);
	echo $thebid;
	echo "Value is: " . $_COOKIE[$cookie_name];

	require("connectDB.php");
	$dbname = "3year";
	mysqli_select_db($conn, $dbname);

	$stmt = $conn->prepare("INSERT INTO bidding_info (product_id, bidder_id, amount) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $_COOKIE[$cookie_name], $_SESSION['user'], $thebid);
    $stmt->execute();


    $stmt->close();
    $conn->close();

}


?>


<html>

<form action="bid.php" method="post">
<input type="text" name="thebid" value=""><br>
<input type="submit" value="Place your bid" name="placebid" />


</html>