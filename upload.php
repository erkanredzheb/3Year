<?php
if(isset($_POST['submitimg']))
{
	$title = $_POST['title'];
	$category = $_POST['state'];
	$descr = $_POST['descr'];
	$price = $_POST['price'];

	//echo $title . $category . $descr . $price;
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