<html>

<form action="search.php" method="post">

<input type="text" name="search">

<input type="submit" value="Go!" name="searchButton" />


</html>

<?php
echo "<br>";


if(isset($_POST['searchButton']))
{
	$search = "%{$_POST['search']}%";
	if(strlen($search) < 3)
    {
        echo "Please provide a word!";
    }
    else
    {    
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

           if($row['boughtby'] == NULL)
           {   

    		echo $row['title'] . "<br>";
            echo $row['category'] . "<br>";
            echo $row['description'] . "<br>";
            echo $row['price'] . "<br>";
            echo '<img height="300" width="300" src="data:image;base64, '.$row['img'].' ">' . "<br>";
            echo "By " . $row['user_id'] . "<br>";
        

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
    	} // while
    }
    else
    {
    	echo "Results not found...";
    }	
     
    $stmt->close();
    $conn->close();
    } // else provide a word
}	

?>

