<?php
session_start();

$_SESSION["user"] = "erkan";
echo "Session created.Should print - erkan:" . "<br>";
echo $_SESSION["user"] . "<br>";

unset($_SESSION["user"]);
echo "Session var unset.Should print an error message:" . "<br>";
echo $_SESSION["user"];
//header("Location: index.php");

?>