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
displayimg();
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

function displayimg()
{
	require("connectDB.php");

    $dbname = "3year";
    mysqli_select_db($conn, $dbname);

    $stmt = $conn->prepare("SELECT * FROM product_info");
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
    {	
    	echo $row['title'] . "<br>";
    	echo $row['category'] . "<br>";
    	echo $row['description'] . "<br>";
    	echo $row['price'] . "<br>";
    	echo '<img height="300" width="300" src="data:image;base64, '.$row['img'].' ">' . "<br>";
    }


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
  				<option value="Home">Home</option>
  				<option value="Fitness">Fitness</option>
  				<option value="Cars">Cars</option>
  				<option value="Computers">Computers</option>
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