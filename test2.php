<?php


require("connectDB.php");
$dbname = "3year";
mysqli_select_db($conn, $dbname);


$stmt = $conn->prepare("SELECT price FROM product_info GROUP BY price DESC LIMIT 1,1");
$stmt->execute();
$result = $stmt->get_result();

while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
{	
    echo $row['price'];
    	
}



?>