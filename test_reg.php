<?php
require("connectDB.php");
require("register.php");

$dbname = "3year";
mysqli_select_db($conn, $dbname);

// Delete previously created entries with username "testreg".
$testreg = "testreg";
$stmt = $conn->prepare("DELETE FROM user_info WHERE username = ?");
$stmt->bind_param("s", $testreg);
$stmt->execute(); 

$stmt = $conn->prepare("SELECT * FROM user_info");
$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$count = mysqli_num_rows($result);

// Functional tests
echo "<br>" . "This sould create a new entry:" . "<br>";
verifyReg($username = "testreg", $password = "magik", $password2 = "magik", $mails = "magik@abv.bg");

$stmt = $conn->prepare("SELECT * FROM user_info");
$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$count2 = mysqli_num_rows($result);

if($count < $count2)
{
	echo "<br>" . "The test for creating a new user passed!" ."<br>";
}
else
{
	echo "<br>" . "The test for creating a new user failed!" . "<br>";
}

// Delete entries with username "password".
$testreg = "testreg";
$stmt = $conn->prepare("DELETE FROM user_info WHERE username = ?");
$stmt->bind_param("s", $testreg);
$stmt->execute(); 

?>