<?php
if(isset($_POST['submit']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	$password2 = $_POST['password2'];
	$mails = $_POST['email'];


    verifyDetails($username, $password, $password2, $mails);

}

function verifyDetails($username, $password, $password2, $mails)
{
    // check if username has forbidden sumbols.
    if(!isSafe($username))
        echo "You have used forbidden symbols.";
    // check if username has min 4 chars.
    else if (strlen($username) < 4) 
    {
        echo "The username is too short.";
    }
    // check if pass match.
    else if ($password != $password2) 
    {
        echo "Your passwords do not match.";
    }
    // check if e-mail valid.
    else if (!filter_var($mails, FILTER_VALIDATE_EMAIL))
    {
        echo "Your e-mail address is invalid.";
    }
    else
    {   
        echo $username;
        require("connectDB.php");
       

        $dbname = "3year";
        mysqli_select_db($conn, $dbname);

        $stmt = $conn->prepare("SELECT username FROM user_info WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);

        if($count == 0)
        {   
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO user_info (username, password, mails)
            VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hash, $mails);
            $stmt->execute();

    
            echo "New record created successfully";
    

            $stmt->close();
            $conn->close();
        }
        else
            echo "Username already in use.";
    }
}

function IsSafe($string)
{
    if(preg_match('/[^a-zA-Z0-9_]/', $string) == 0)
    {
    	//echo "true";
        return true;
        
    }
    else
    {
    	//echo "false";
        return false;
        
    }
}

?>

<html>

<form action="register.php" method="post">

Username: <input type="text" name="username" value=""><br>

E-mail: <input type="text" name="email" value=""><br>

Password: <input type="password" name="password" value=""><br>

Re-enter password:  <input type="password" name="password2" value=""><br>

<input type="submit" value="Submit" name="submit" />



</html>