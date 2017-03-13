<?php

displayimg();
function displayimg()
{
	require("connectDB.php");

    $dbname = "3year";
    mysqli_select_db($conn, $dbname);

    $id_product = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM product_info WHERE id = ?");
    $stmt->bind_param("s", $id_product);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    	
    	echo $row['title'] . "<br>";
    	echo $row['category'] . "<br>";
    	echo $row['description'] . "<br>";
    	echo $row['price'] . "<br>";
    	echo '<img height="300" width="300" src="data:image;base64, '.$row['img'].' ">' . "<br>";
        echo $row['auction_type'] . "<br>";
        echo "By " . $row['user_id'] . "<br>";

        $auctionType = $row['auction_type'];

        // Increment number of views for the product.
        $counter = $row['viewCounter'];
        $counter++;
        $stmt = $conn->prepare("UPDATE product_info SET viewCounter = ? WHERE id = ?");
        $stmt->bind_param("ii", $counter, $id_product);
        $stmt->execute();

        $stmt = $conn->prepare("SELECT amount FROM bidding_info WHERE product_id = ? ORDER BY amount DESC LIMIT 1");
        $stmt->bind_param("i", $id_product);
        $stmt->execute();
        $result2 = $stmt->get_result();
        $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
        
        

        echo "<html>";
        echo "<head>";
            echo "<link rel='stylesheet' type='text/css' href='./style.css'>";
            echo "<script src='./scripts.js'></script>";
            echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>";
        echo "</head>";
        echo "<body>";
            
        if(strcmp($auctionType, "Buy Now") == 0)
        {

          echo "<div class='buy_button' onclick=\"print_id('".$row['id']."')\">Buy</div>";
        }
        else if(strcmp($auctionType, "English Auction") == 0) 
        {
          echo "The current highest bid is: " . $row2['amount'] . "<br>";
          echo "<div class='bid_button' onclick=\"print_bid('".$row['id']."')\">Bid</div>"; 
        } 

        echo "<br>";
        echo "<br>";

        echo "</body>";
        echo "</html>";
        
    


    $stmt->close();
    $conn->close();
}



?>