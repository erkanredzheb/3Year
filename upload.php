<?php


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
	
        saveimg($title, $category, $descr, $price, $image);
		
	}	

	//echo $title . $category . $descr . $price;
}	

function saveimg($title, $category, $descr, $price, $image)
{
    	require("connectDB.php");

        $dbname = "3year";
        mysqli_select_db($conn, $dbname);

        $stmt = $conn->prepare("INSERT INTO product_info (title, category, description, price, img) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $title, $category, $descr, $price, $image);
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
			<input type="file" name="image">
			<br/><br/>
			<input type="submit" name="submitimg" value="Upload" />
		</form>
	</body>
</html>