<?php
if(isset($_POST['submit']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	$password2 = $_POST['password2'];
	$mails = $_POST['email'];

    verifyReg($username, $password, $password2, $mails);
   

}

function verifyReg($username, $password, $password2, $mails)
{
     // check if username has forbidden sumbols.
    if(!isSafe($username))
        echo "You have used forbidden symbols.";
    // check if username has min 4 chars.
    else if (strlen($username) < 4) 
    {
        echo "The username is too short.";
    }
    // check if username has not more than 16 chars.
    else if (strlen($username) > 16) 
    {
        echo "The username is too long.";
    }
    // check if pass is too short
    else if (strlen($password) < 5 && strlen($password2) < 5)
    {
        echo "Your password is too short.";
    }
    // check if pass is too long
    else if (strlen($password) > 16 && strlen($password2) > 16)
    {
        echo "Your password is too long.";
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
        //echo $username;
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

    
            echo "New record created successfully" . "<br>";
            header("Location: http://localhost/3Year/login.php");

            $stmt->close();
            $conn->close();
        }
        else
            echo "Username already in use.\n";
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

<html >
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  
  
  <link rel='stylesheet prefetch' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>

      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>
  <div class="login-card">
    <h1>Register</h1><br>
  <form action="register.php" method="post">
    <input type="text" name="username" placeholder="Username">
    <input type="text" name="email" placeholder="E-mail">
    <input type="password" name="password" placeholder="Password">
    <input type="password" name="password2" placeholder="Re-enter password">
    <input type="submit" name="submit" class="login login-submit" value="Register">
  </form>
    
</div>

<!-- <div id="error"><img src="https://dl.dropboxusercontent.com/u/23299152/Delete-icon.png" /> Your caps-lock is on.</div> -->
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>

  
</body>
</html>