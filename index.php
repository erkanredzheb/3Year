<?php
session_start();
if(isset($_SESSION["user"]))
{
    echo "<div class = \"header\">";
    echo "Hi, " . $_SESSION["user"] . "<br>";
    echo "<a href=\"logout.php\">Log out</a>";
    echo " <a href=\"upload.php\">Sell</a>";
    echo " <a href=\"myitems.php\">My Items</a>";
    echo " <a href=\"mybids.php\">My Bids</a>";
    echo " <a href=\"purchase_history.php\">Purchases</a>";
    echo "</div>";
    echo "<br>";
}
else
{
    echo " <a href=\"login.php\">Sign in</a>";
    echo " <a href=\"register.php\">Register</a>";
    echo "<br>";
}    

$null = null;
$fashion = "Fashion";
$hg = "Home & Garden";
$elec = "Electronics";
$leis = "Leisure";
$collec = "Collectables";
$hb = "Health & Beauty";
$motors = "Motors";

require("connectDB.php");

$dbname = "3year";
mysqli_select_db($conn, $dbname);

$stmt = $conn->prepare("SELECT id FROM product_info WHERE category = ? AND boughtby IS NULL");
$stmt->bind_param("s", $fashion);
$stmt->execute();
$result = $stmt->get_result();
$num_rows = mysqli_num_rows($result);
$fashionN = $num_rows;

$stmt = $conn->prepare("SELECT id FROM product_info WHERE category = ? AND boughtby IS NULL");
$stmt->bind_param("s", $hg);
$stmt->execute();
$result = $stmt->get_result();
$num_rows = mysqli_num_rows($result);
$hgN = $num_rows;

$stmt = $conn->prepare("SELECT id FROM product_info WHERE category = ? AND boughtby IS NULL");
$stmt->bind_param("s", $elec);
$stmt->execute();
$result = $stmt->get_result();
$num_rows = mysqli_num_rows($result);
$elecN = $num_rows;


$stmt = $conn->prepare("SELECT id FROM product_info WHERE category = ? AND boughtby IS NULL");
$stmt->bind_param("s", $leis);
$stmt->execute();
$result = $stmt->get_result();
$num_rows = mysqli_num_rows($result);
$leisN = $num_rows;


$stmt = $conn->prepare("SELECT id FROM product_info WHERE category = ? AND boughtby IS NULL");
$stmt->bind_param("s", $collec);
$stmt->execute();
$result = $stmt->get_result();
$num_rows = mysqli_num_rows($result);
$collecN = $num_rows;


$stmt = $conn->prepare("SELECT id FROM product_info WHERE category = ? AND boughtby IS NULL");
$stmt->bind_param("s", $hb);
$stmt->execute();
$result = $stmt->get_result();
$num_rows = mysqli_num_rows($result);
$hbN = $num_rows;


$stmt = $conn->prepare("SELECT id FROM product_info WHERE category = ? AND boughtby IS NULL");
$stmt->bind_param("s", $motors);
$stmt->execute();
$result = $stmt->get_result();
$num_rows = mysqli_num_rows($result);
$motorsN = $num_rows;

echo "<div class = \"buy_type\">";
echo "<a href=\"buynow.php\">Buy Now</a>";
echo "  <a href=\"auctions.php\">Auctions</a>";
echo "</div>";

echo "<div class = \"search\">";
echo "<html>";

echo "<form action=\"search.php\" method=\"post\">";

echo "<input type=\"text\" name=\"search\">";

echo "<input type=\"submit\" value=\"Go!\" name=\"searchButton\" />";


echo "</html>";
echo "</div>";

echo "<div class = \"wrapper\">";
echo "<ul>";
echo "<li><a href=\"fashion.php\">Fashion(" . $fashionN . ")</a>";
echo " <a href=\"home&garden.php\">Home & Garden(" . $hgN . ")</a>";
echo " <a href=\"electronics.php\">Electronics(" . $elecN . ")</a>";
echo " <a href=\"leisure.php\">Leisure(" . $leisN . ")</a>";
echo " <a href=\"collectables.php\">Collectables(" . $collecN . ")</a>";
echo " <a href=\"health&beauty.php\">Health & Beauty(" . $hbN . ")</a>";
echo " <a href=\"motors.php\">Motors(" . $motorsN . ")</a>";
echo "</li>";
echo "</ul>";
echo "</div>";

echo "<br>";
echo "<br>";
echo "<br>";




echo "<div class = \"mptext\">";
    echo "Most popular" . "<br>";
echo "</div>";
echo "<hr>";

echo "<div class = \"mostpopular\">";
echo "<ul>";
echo "<li>";

$vickery = "Vickery Auction";
$blind = "Blind Auction";


$stmt = $conn->prepare("SELECT * FROM product_info ORDER BY viewCounter DESC LIMIT 50");
$stmt->execute();
$result = $stmt->get_result();
    while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
    {	
        if($row["boughtby"] == NULL)
        {    
           $auctionType = $row['auction_type']; 
    	   echo $row['title'] . "<br>";
    	   echo $row['category'] . "<br>";
    	   echo $row['description'] . "<br>";
           if(strcmp($auctionType, $blind)  !== 0 && strcmp($auctionType, $vickery) !==0)

           { echo $row['price'] . "<br>"; }
    	   echo '<img height="300" width="300" src="data:image;base64, '.$row['img'].' ">' . "<br>";
           echo $row['auction_type'] . "<br>";
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
echo "</li>";
echo "</ul>";   
echo "</div>";

echo "<div class = \"raddedtext\">";
echo "Recently added" . "<br>";
echo "</div>";

echo "<div class = \"radded\">";
echo "<ul>";
echo "<li>";


  

	$stmt = $conn->prepare("SELECT * FROM product_info ORDER BY date DESC LIMIT 50");


    $stmt->execute();
    $result = $stmt->get_result();
    while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
    {	
        if($row['boughtby'] == NULL)
        {
           $auctionType = $row['auction_type'];    
    	   echo $row['title'] . "<br>";
    	   echo $row['category'] . "<br>";
    	   echo $row['description'] . "<br>";
    	   if(strcmp($auctionType, $blind)  !== 0 && strcmp($auctionType, $vickery) !==0)

           { echo $row['price'] . "<br>"; }
       
    	   echo '<img height="300" width="300" src="data:image;base64, '.$row['img'].' ">' . "<br>";
           echo $row['auction_type'] . "<br>";
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

echo "</li>";
echo "</ul>";   
echo "</div>";


    $stmt->close();
    $conn->close();


?>
