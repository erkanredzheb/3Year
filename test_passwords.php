<?php
	
require("connectDB.php");
require("register.php");


$dbname = "3year";
mysqli_select_db($conn, $dbname);


// Functional tests
echo "<br>" . "This sould create a new entry:" . "<br>";
verifyReg($username = "password", $password = "magik", $password2 = "magik", $mails = "magik@abv.bg");


// Delete previously created entries with username "password".
$testpass = "password";
$stmt = $conn->prepare("DELETE FROM user_info WHERE username = ?");
$stmt->bind_param("s", $testpass);
$stmt->execute();


// Unit tests
echo "<br>" . "Should say that the password is too short:" . "<br>";
verifyReg($username = "magik", $password = "magi", $password2 = "magi", $mails = "magik@abv.bg");
echo "<br>";

echo "<br>" . "Should say that the password is too long:" . "<br>";
verifyReg($username = "magik", $password = "magikmagikmagikmagik", $password2 = "magikmagikmagikmagik", $mails = "magik@abv.bg");
echo "<br>";

echo "<br>" . "Should say that the password do not match:" . "<br>";
verifyReg($username = "password", $password = "magik", $password2 = "magikk", $mails = "magik@abv.bg");
echo "<br>";


$stmt->close();
$conn->close();


?>
