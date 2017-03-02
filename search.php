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
    $count = mysqli_num_rows($result);

    if($count > 0)
    {	
    	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
    	{	
    		echo $row['title'] . "<br>";
            echo $row['category'] . "<br>";
            echo $row['description'] . "<br>";
            echo $row['price'] . "<br>";
            echo '<img height="300" width="300" src="data:image;base64, '.$row['img'].' ">' . "<br>";
        

            echo "<html>";
            echo "<head>";
                echo "<link rel='stylesheet' type='text/css' href='./style.css'>";
                echo "<script src='./scripts.js'></script>";
                echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>";
            echo "</head>";
            echo "<body>";
            
            echo "<div class='product_view_button' onclick=\"product_view('".$row['id']."')\">View</div>";

            echo "<br>";
            echo "<br>";

            echo "</body>";
            echo "</html>";
    	   }
    }
    else
    {
    	echo "Results not found...";
    }	
     
    $stmt->close();
    $conn->close();

}	

?>

<html>

<form action="search.php" method="post">

Search: <input type="text" name="search"><br>

<input type="submit" value="Go!" name="searchButton" />


</html>