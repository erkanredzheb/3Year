<?php
if(isset($_POST['submitLogin']))
{
	$usernameLogin = ($_POST['usernameLogin']);
	$passwordLogin = ($_POST['passwordLogin']);


	require("connectDB.php");

	$dbname = "3year";
	mysqli_select_db($conn, $dbname);

    //$sql = "SELECT username, password FROM user_info WHERE username = '$usernameLogin'";
    $stmt = $conn->prepare("SELECT username, password FROM user_info WHERE username = ?");
    $stmt->bind_param("s", $usernameLogin);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

    $count = mysqli_num_rows($result);


   
    if($count == 1)
    {
    	if(password_verify($passwordLogin ,$row['password']))
    		echo "Login successful!";
    	else
    		echo "Incorrect password!";
    }
    else
    	echo "Username not valid!";


    $stmt->close();
	$conn->close();

}
?>

<html>

<form action="login.php" method="post">

Username: <input type="text" name="usernameLogin" value=""><br>

Password: <input type="password" name="passwordLogin" value=""><br>

<input type="submit" value="Submit" name="submitLogin" />


</html>