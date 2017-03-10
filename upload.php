<?php

session_start();
if(!isset($_SESSION["user"]))
{
	header("Location: login.php");
}

 echo "Hi, " . $_SESSION["user"] . "<br>";

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

<html>
	<body>
		<form method="post" enctype="multipart/form-data">
			Name: <input type="text" name="title" value=""><br>
			Categories: 
			<select name="state">
  				<option value="Fashion">Fashion</option>
  				<option value="Home & Garden">Home & Garden</option>
  				<option value="Electronics">Electronics</option>
  				<option value="Leisure">Leisure</option>
  				<option value="Collectables">Collectables</option>
  				<option value="Health & Beauty">Health & Beauty</option>
  				<option value="Motors">Motors</option>
			</select>
			<br/>
			
			Description: <input type="text" name="descr" value=""><br>
			Price: <input type="text" name="price" value=""><br>
			Auction type:
			<select name="auction">
  				<option value="BN">Buy Now</option>
  				<option value="EA">English Auction</option>
			</select>
			<br/>
			<input type="file" name="image">
			<br/><br/>
			<input type="submit" name="submitimg" value="Upload" />
		</form>
	</body>
</html>