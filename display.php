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
        ?>

        <html>
        <form action="buy.php" method="post">
        <input type="submit" value="Buy" name="buy" />
        <br>
        <br>
        </html>
        <?php
    }


    $stmt->close();
    $conn->close();
}

?>