<?php
session_start();
echo "Hi, " . $_SESSION["user"] . "<br>";
echo "Most popular products" . "<br>";
require("connectDB.php");
echo "<a href=\"login.php\">Login</a>";
echo "<br>";

$dbname = "3year";
mysqli_select_db($conn, $dbname);

$stmt = $conn->prepare("SELECT * FROM product_info ORDER BY viewCounter DESC LIMIT 4");


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


    echo "Recently added" . "<br>";
    echo "<br>";
    echo "<br>";

	$stmt = $conn->prepare("SELECT * FROM product_info ORDER BY date DESC LIMIT 4");


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
