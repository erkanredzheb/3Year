<?php

require("connectDB.php");

$dbname = "3year";
mysqli_select_db($conn, $dbname);

$one = "1";
$stmt = $conn->prepare("SELECT id, user_id FROM product_info WHERE bid_placed = ?");
$stmt->bind_param("i", $one);
$stmt->execute();
$result = $stmt->get_result();

while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
{

	// The acc of the uploader.
    $stmt = $conn->prepare("SELECT acc_balance FROM user_info WHERE username = ?");
	$stmt->bind_param("s", $row['user_id']);
	$stmt->execute();
	$result3 = $stmt->get_result();
    while($row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC))
    {
    	$accBalupl = $row3['acc_balance'];
    }

	$stmt = $conn->prepare("SELECT * FROM bidding_info WHERE product_id = ? ORDER BY amount DESC LIMIT 1");
	$stmt->bind_param("i", $row['id']);
	$stmt->execute();
	$result2 = $stmt->get_result();

	while($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC))
	{
	  echo "The amound bid " . $row2['amount'] . "<br>";

	  $accPlus = $accBalupl + $row2['amount'];
	  echo "The new acc of uploader " . $accPlus . " by " . $row['user_id'] . "<br>";

	  $stmt = $conn->prepare("UPDATE user_info SET acc_balance = (?) WHERE username = ?");
      $stmt->bind_param("is",$accPlus ,$row['user_id']);
      $stmt->execute();	



      // Acc balance of bidder.
      $stmt = $conn->prepare("SELECT acc_balance FROM user_info WHERE username = ?");
	  $stmt->bind_param("s", $row2['bidder_id']);
	  $stmt->execute();
	  $result4 = $stmt->get_result();
      while($row4 = mysqli_fetch_array($result4,MYSQLI_ASSOC))
      {
    	 $accBalbid = $row4['acc_balance'];
      }  

	  $accMinus = $accBalbid - $row2['amount']; 
	  echo "The new account of the buyer " . $accMinus . " by " . $row2['bidder_id'] . "<br>";
     
      $stmt = $conn->prepare("UPDATE user_info SET acc_balance = (?) WHERE username = ?");
      $stmt->bind_param("is",$accMinus, $row2['bidder_id']);
      $stmt->execute();	

      $stmt = $conn->prepare("UPDATE product_info SET boughtby = ? WHERE id = ?");
	  $stmt->bind_param("si", $row2['bidder_id'], $row['id']);
	  $stmt->execute();

	  $stmt = $conn->prepare("INSERT INTO winner_info (product_id, winner_id, amount) VALUES (?, ?, ?)");
      $stmt->bind_param("isi",$row['id'] ,$row2['bidder_id'], $row2['amount']);
      $stmt->execute();	

      $stmt = $conn->prepare("TRUNCATE TABLE bidding_info");
      $stmt->execute();
	}	

}


$stmt->close();
$conn->close();
?>