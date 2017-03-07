<?php

session_start();

if(!isset($_SESSION["user"]))
{
	header("Location: login.php");
}

$currUser = $_SESSION["user"];


require("connectDB.php");

$dbname = "3year";
mysqli_select_db($conn, $dbname);

$stmt = $conn->prepare("SELECT * FROM product_info WHERE boughtby = ?");
$stmt->bind_param("s", $currUser);
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
        
}
else
	echo "You haven't bought anything yet.";

?>