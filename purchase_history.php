<?php

session_start();

if(!isset($_SESSION["user"]))
{
	header("Location: login.php");
}

$currUser = $_SESSION["user"];

if(isset($_SESSION["user"]))
{
    echo "<div class = \"header\">";
    echo "Hi, " . $_SESSION["user"] . "<br>";
    echo "<a href=\"logout.php\">Log out</a>";
    echo " <a href=\"upload.php\">Sell</a>";
    echo " <a href=\"myitems.php\">My Items</a>";
    echo " <a href=\"mybids.php\">My Bids</a>";
    echo " <a href=\"index.php\">Home</a>";
    echo "</div>";
    echo "<br>";
}   

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
            


        

        echo "<br>";
        echo "<br>";

        echo "</body>";
        echo "</html>";
     }   
        
}
else
	echo "You haven't bought anything yet.";

?>