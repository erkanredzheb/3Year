<?php
	require("connectDB.php");

	if($verifyConn)
	{
		echo "Connected to the database successfully!";
	}
	else
	{
		echo "Cannot establish a connection!";
	}	
?>

