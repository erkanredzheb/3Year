<?php

if(isset($_POST['searchButton']))
{
	$search = "%{$_POST['search']}%";
	
    require("connectDB.php");

    $dbname = "3year";
    mysqli_select_db($conn, $dbname);
    
    $stmt = $conn->prepare("SELECT * FROM product_info WHERE title LIKE ?");
    $stmt->bind_param("s", $search);
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

<form action="search.php" method="post">

Search: <input type="text" name="search" value=""><br>

<input type="submit" value="Go!" name="searchButton" />


</html>