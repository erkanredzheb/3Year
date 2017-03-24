<?php
session_start();

if(!isset($_SESSION["user"]))
{
	header("Location: login.php");
}


if(isset($_SESSION["user"]))
{
    echo "<div class = \"header\">";
    echo "Hi, " . $_SESSION["user"] . "<br>";
    echo "<a href=\"logout.php\">Log out</a>";
    echo " <a href=\"upload.php\">Sell</a>";
    echo " <a href=\"myitems.php\">My Items</a>";   
    echo " <a href=\"purchase_history.php\">Purchases</a>";
    echo " <a href=\"index.php\">Home</a>";
    echo "</div>";
    echo "<br>";
}   

require("connectDB.php");

$dbname = "3year";
mysqli_select_db($conn, $dbname);

$stmt = $conn->prepare("SELECT product_id, amount FROM bidding_info WHERE bidder_id = ?");
$stmt->bind_param("s", $_SESSION['user']);
$stmt->execute();
$result = $stmt->get_result();
$num_rows = mysqli_num_rows($result);
if($num_rows == 0)
{	
   echo "<html>";
		    echo "<head>";
		    echo "<link rel='stylesheet' type='text/css' href='./style.css'>";
		    echo "<script src='./scripts.js'></script>";
		    echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>";
		    echo "</head>";
		    echo "<body>";
		    echo "<div class='soldLabel'>";
				echo "You do not have any bids yet!";
			echo "</div>";
			echo "</body>";
			echo "</html>";
}			


while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
{
    $stmt = $conn->prepare("SELECT * FROM product_info WHERE id = ?");
	$stmt->bind_param("i", $row['product_id']);
	$stmt->execute();
	$result2 = $stmt->get_result();
    while($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC))
    {
    	
	    	echo "<div class='soldLabel'>";
	    		echo "Your bid for the following product is: " . $row['amount'] . "<br>";
	    	echo "</div>";
		    echo $row2['title'] . "<br>";
		    echo $row2['category'] . "<br>";
		    echo $row2['description'] . "<br>";
		    echo $row2['price'] . "<br>";
		    echo '<img height="300" width="300" src="data:image;base64, '.$row2['img'].' ">' . "<br>";
		    echo $row2['auction_type'] . "<br>";
		    echo "By " . $row2['user_id'] . "<br>";
		        

		    echo "<html>";
		    echo "<head>";
		    echo "<link rel='stylesheet' type='text/css' href='./style.css'>";
		    echo "<script src='./scripts.js'></script>";
		    echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>";
		    echo "</head>";
		    echo "<body>";
		           


		    echo "<div class='product_view_button' onclick=\"product_view('".$row2['id']."')\">View</div>";

			echo "<br>";
			echo "<br>";

			echo "</body>";
			echo "</html>";
		
		
		 
			
	}	
}	


?>