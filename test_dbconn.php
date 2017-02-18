<?php
	require("connectDB.php");

	if(connectDB($servername, $usernameDB, $passwordDB))
	{
		echo "Connected to the database successfully!";
	}
?>

