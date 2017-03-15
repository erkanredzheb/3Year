<html>

<form action="bid.php" method="post">
<input type="text" name="thebid" value=""><br>
<input type="submit" value="Place your bid" name="placebid" />


</html>

<?php
error_reporting(0);
session_start();

$cookie_name = "a";

if(strcmp($cookie_name, "a") == 0)
{
  $cookie_name = $_SESSION['user'];
  $cookie_value = $_GET['id'];
  setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
}


if(!isset($_SESSION["user"]))
{
	header("Location: login.php");
}

if(isset($_POST['placebid']))
{
	$thebid = ($_POST['thebid']);
	
	require("connectDB.php");
	$dbname = "3year";
	mysqli_select_db($conn, $dbname);

	$stmt = $conn->prepare("SELECT amount FROM bidding_info WHERE product_id = ?");
    $stmt->bind_param("i", $_COOKIE[$cookie_name]);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if($count > 0)
    {	

      while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
	  {	
    	  $theprice = $row['amount'];
	  }
	}  
    else
    {	
	  $stmt = $conn->prepare("SELECT price FROM product_info WHERE id = ?");
      $stmt->bind_param("i", $_COOKIE[$cookie_name]);
      $stmt->execute();
      $result = $stmt->get_result();

      while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
	  {	
    	  $theprice = $row['price'];
	  }  
    }


    if($theprice < $thebid)
    {	
	  $stmt = $conn->prepare("INSERT INTO bidding_info (product_id, bidder_id, amount) VALUES (?, ?, ?)");
      $stmt->bind_param("isi", $_COOKIE[$cookie_name], $_SESSION['user'], $thebid);
      $stmt->execute();

      $one = "1";
      $stmt = $conn->prepare("UPDATE product_info SET bid_placed = (?) WHERE id = ?");
      $stmt->bind_param("ii", $one, $_COOKIE[$cookie_name]);
      $stmt->execute();

      header("Location: index.php");
    }
    else
    { echo "Please provide a bigger amount than " . $theprice; }  


    $stmt->close();
    $conn->close();

}


?>


