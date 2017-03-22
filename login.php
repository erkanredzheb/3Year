<?php
if(isset($_POST['submitLogin']))
{
	$usernameLogin = ($_POST['usernameLogin']);
	$passwordLogin = ($_POST['passwordLogin']);


	verifyLogin($usernameLogin, $passwordLogin);

}

function verifyLogin($usernameLogin, $passwordLogin)
{
    require("connectDB.php");

    $dbname = "3year";
    mysqli_select_db($conn, $dbname);

 
    $stmt = $conn->prepare("SELECT username, password FROM user_info WHERE username = ?");
    $stmt->bind_param("s", $usernameLogin);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

    $count = mysqli_num_rows($result);


   
    if($count == 1)
    {
        if(password_verify($passwordLogin ,$row['password']))
        {    
            echo "Login successful!";
            session_start();
            $_SESSION["user"] = $usernameLogin;
            header("Location: http://localhost/3Year/index.php");
            exit();
        }   
        else
            echo "Incorrect password!";
    }
    else
        echo "Username not valid!";


    $stmt->close();
    $conn->close();
}
?>


<html >
<head>
  <meta charset="UTF-8">
  <title>Log-in</title>
  
  
  <link rel='stylesheet prefetch' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>

      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>
  <div class="login-card">
    <h1>Log-in</h1><br>
  <form action="login.php" method="post">
    <input type="text" name="usernameLogin" placeholder="Username">
    <input type="password" name="passwordLogin" placeholder="Password">
    <input type="submit" name="submitLogin" class="login login-submit" value="login">
  </form>
    
  <div class="login-help">
    <a href="register.php">Register</a>
  </div>
</div>

<!-- <div id="error"><img src="https://dl.dropboxusercontent.com/u/23299152/Delete-icon.png" /> Your caps-lock is on.</div> -->
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>

  
</body>
</html>