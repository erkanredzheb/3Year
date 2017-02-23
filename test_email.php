<?php

require("connectDB.php");
require("register.php");


$dbname = "3year";
mysqli_select_db($conn, $dbname);


// Functional tests
echo "<br>" . "This sould create a new entry:" . "<br>";
verifyReg($username = "email", $password = "magik", $password2 = "magik", $mails = "magik@abv.bg");


// Delete previously created entries with username "password".
$testemail = "email";
$stmt = $conn->prepare("DELETE FROM user_info WHERE username = ?");
$stmt->bind_param("s", $testemail);
$stmt->execute();


// Unit tests
echo "<br>" . "This sould say that the e-mail is not valid:" . "<br>";
verifyReg($username = "email", $password = "magik", $password2 = "magik", $mails = "magik@abv");

$stmt->close();
$conn->close();

?>
