<?php

displayimg();
function displayimg()
{
	require("connectDB.php");

    $dbname = "3year";
    mysqli_select_db($conn, $dbname);

    $stmt = $conn->prepare("SELECT * FROM product_info");
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
            

        // <form action="buy.php" method="post">
        // <input type="submit" value="Buy" name="buy" />


        echo "<div class='buy_button' onclick=\"print_id('".$row['id']."')\">HI</div>";

        echo "<br>";
        echo "<br>";

        echo "</body>";
        echo "</html>";
        
    }


    $stmt->close();
    $conn->close();
}

?>