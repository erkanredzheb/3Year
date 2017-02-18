<?php

require("connectDB.php");
require("register.php");
require("login.php");

$dbname = "3year";
mysqli_select_db($conn, $dbname);


// Delete previously created entries with username "testlogin".
$testlogin = "testlogin";
$stmt = $conn->prepare("DELETE FROM user_info WHERE username = ?");
$stmt->bind_param("s", $testlogin);
$stmt->execute();

verifyReg($username = "testlogin", $password = "magik", $password2 = "magik", $mails = "magik@abv.bg");

echo "<br>" . "This sould say that login was successful:" . "<br>";
verifyLogin($testlogin, $password = "magik");

// Delete entries with username "testlogin".
$testlogin = "testlogin";
$stmt = $conn->prepare("DELETE FROM user_info WHERE username = ?");
$stmt->bind_param("s", $testlogin);
$stmt->execute();

?>

