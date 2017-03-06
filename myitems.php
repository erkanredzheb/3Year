<?php
session_start();

if(!isset($_SESSION["user"]))
{
	header("Location: login.php");
}

require("connectDB.php");

$dbname = "3year";
mysqli_select_db($conn, $dbname);

 $stmt = $conn->prepare("SELECT * FROM product_info INNER JOIN user_info ON product_info.user_id= (?) GROUP BY product_info.title, product_info.category, product_info.price, product_info.img");
 $stmt->bind_param("s", $_SESSION["user"]);
 $stmt->execute();
 $result = $stmt->get_result();

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

$stmt->close();
$conn->close();

?>
