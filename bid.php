<html >
<head>
  <meta charset="UTF-8">
  <title>Bid</title>
  
  
  <link rel='stylesheet prefetch' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>

      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>
  <div class="login-card">
    <h1>Place your bid!</h1><br>
  <form action="bid.php" method="post">
    <input type="text" name="thebid" value="">
    <input type="submit" name="placebid" class="login login-submit" value="BID">
  </form>
    

</div>

<!-- <div id="error"><img src="https://dl.dropboxusercontent.com/u/23299152/Delete-icon.png" /> Your caps-lock is on.</div> -->
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>

  
</body>
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


$blind = "Blind Auction";
$vickery = "Vickery Auction";

$stmt = $conn->prepare("SELECT auction_type FROM product_info WHERE id = ?");
$stmt->bind_param("i", $_COOKIE[$cookie_name]);
$stmt->execute();
$result2 = $stmt->get_result();
while($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC))
{ 
        $auctionType = $row2['auction_type'];
} 


if(strcmp($auctionType, $blind) == 0 || strcmp($auctionType, $vickery) == 0)
{
  
  $stmt = $conn->prepare("SELECT product_id, bidder_id FROM bidding_info WHERE product_id = ?");
  $stmt->bind_param("i", $_COOKIE[$cookie_name]);
  $stmt->execute();
  $result3 = $stmt->get_result();

  $count = mysqli_num_rows($result3);
  if($count > 0)
  {
    while($row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC))
    {
      if(strcmp($row3['bidder_id'], $_SESSION['user']) == 0)
      {
        echo "Because of the auction type of this product you can only bid once! Check Vickery/Blind auction's rules.";
        exit(0);
      }  
    }
    
  }

}



	$stmt = $conn->prepare("SELECT amount FROM bidding_info WHERE product_id = ?");
    $stmt->bind_param("i", $_COOKIE[$cookie_name]);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count2 = mysqli_num_rows($result);

    if($count2 > 0)
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


