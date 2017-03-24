<?php

session_start();
if(!isset($_SESSION["user"]))
{
	header("Location: login.php");
}
else
{
	echo "<div class = \"header\">";
    echo "Hi, " . $_SESSION["user"] . "<br>";
    echo "<a href=\"logout.php\">Log out</a>";
    echo " <a href=\"myitems.php\">My Items</a>";
    echo " <a href=\"mybids.php\">My Bids</a>";
    echo " <a href=\"purchase_history.php\">Purchases</a>";
    echo " <a href=\"index.php\">Home</a>";
    echo "</div>";
    echo "<br>";
}



if(isset($_POST['submitimg']))
{

	if(getimagesize($_FILES['image']['tmp_name']) == FALSE)
	{
		echo "Please select an image.";
	}
	else
	{	
		$image = ($_FILES['image']['tmp_name']);
		$image = file_get_contents($image);
		$image = base64_encode($image);

		$title = $_POST['title'];
		$category = $_POST['state'];
		$descr = $_POST['descr'];
		$price = $_POST['price'];
		$auction = $_POST['auction'];
	
        saveimg($title, $category, $descr, $price, $image, $auction);
		
	}	

	//echo $title . $category . $descr . $price;
}	

function saveimg($title, $category, $descr, $price, $image, $auction)
{
    	require("connectDB.php");

        $dbname = "3year";
        mysqli_select_db($conn, $dbname);

        $stmt = $conn->prepare("INSERT INTO product_info (user_id, title, category, description, price, img, auction_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiss", $_SESSION["user"], $title, $category, $descr, $price, $image, $auction);
        $stmt->execute();

        echo "Product uploaded successfully." . "<br>";
    
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
    <h1>Upload</h1><br>
  <form method="post" enctype="multipart/form-data">
    <input type="text" name="title" value="" placeholder="Title">
    <select name="state" placeholder="Category">
  				<option value="Fashion">Fashion</option>
  				<option value="Home & Garden">Home & Garden</option>
  				<option value="Electronics">Electronics</option>
  				<option value="Leisure">Leisure</option>
  				<option value="Collectables">Collectables</option>
  				<option value="Health & Beauty">Health & Beauty</option>
  				<option value="Motors">Motors</option>
	</select>
     <input type="text" name="descr" value="" placeholder="Description">
     <input type="text" name="price" value="" placeholder="Price">
     <select name="auction" placeholder="Selling method">
  				<option value="Buy Now">Buy Now</option>
  				<option value="English Auction">English Auction</option>
  				<option value="Blind Auction">Blind Auction</option>
  				<option value="Vickery Auction">Vickery Auction</option>
			</select>
	<input type="file" name="image">		
    <input type="submit" name="submitimg" class="login login-submit" value="Upload">
  </form>
    
</div>

<!-- <div id="error"><img src="https://dl.dropboxusercontent.com/u/23299152/Delete-icon.png" /> Your caps-lock is on.</div> -->
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>

  
</body>
</html>