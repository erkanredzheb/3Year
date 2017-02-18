<?php

require("connectDB.php");
require("register.php");


$dbname = "3year";
mysqli_select_db($conn, $dbname);


// Delete previously created entries with username "magik".
$theuname = "magik";
$stmt = $conn->prepare("DELETE FROM user_info WHERE username = ?");
$stmt->bind_param("s", $theuname);
$stmt->execute();


echo "<br>" . "This sould create a new entry:" . "<br>";
verifyReg($username = "magik", $password = "magik", $password2 = "magik", $mails = "magik@abv.bg");
echo "<br>";

echo "Should say that the user already exists:" . "<br>";
verifyReg($username = "magik", $password = "magik", $password2 = "magik", $mails = "magik@abv.bg");
echo "<br>";

echo "<br>" . "Should say that the username is too short:" . "<br>";
verifyReg($username = "mag", $password = "magik", $password2 = "magik", $mails = "magik@abv.bg");
echo "<br>";

echo "<br>" . "Should say that the username has forbidden symbols:" . "<br>";
verifyReg($username = "magik~!", $password = "magik", $password2 = "magik", $mails = "magik@abv.bg");
echo "<br>";


$conn->close();

?>