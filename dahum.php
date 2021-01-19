<?php
header('Content-Type: application/json');
// Initialize variable for database credentials
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'dahum_builders';

//Create database connection
  $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

//Check connection was successful
  if ($conn->connect_errno) {
     printf("Failed to connect to database");
     exit();
  }

//Fetch 3 rows from actor table
  $result = $conn->query("SELECT `date_paid` DatePaid,  
  SUM(CASE WHEN `payment_type`=0 THEN `paid_amount` ELSE 0 END) TotalCash,
  SUM(CASE WHEN `payment_type`=1 THEN `paid_amount` ELSE 0 END) TotalCheck,
  SUM(CASE WHEN `payment_type`=2 THEN `paid_amount` ELSE 0 END) TotalBankTransfer,
  SUM(`commission`) AS Expenses, 
  SUM(IF(`payment_type` = 0, `paid_amount`-`commission`,0)) AS TotalCashOnHand
  FROM `db_transaction` t GROUP BY `date_paid` ORDER BY `date_paid` DESC");

//Fetch 3 rows from actor table
$result2 = $conn->query("SELECT `date_paid` DatePaid,  
SUM(CASE WHEN `payment_type`=0 THEN `paid_amount` ELSE 0 END) TotalCash,
SUM(CASE WHEN `payment_type`=1 THEN `paid_amount` ELSE 0 END) TotalCheck,
SUM(CASE WHEN `payment_type`=2 THEN `paid_amount` ELSE 0 END) TotalBankTransfer,
SUM(`commission`) AS Expenses, 
SUM(IF(`payment_type` = 0, `paid_amount`-`commission`,0)) AS TotalCashOnHand
FROM `db_transaction` t GROUP BY `date_paid` ORDER BY `date_paid` DESC");

//Initialize array variable
$response["summary"] = array();


while ($row = $result->fetch_assoc())  {
  $temp = array(); // temp array 
  $datePaid = $row["DatePaid"];
  $temp["DatePaid"] = $row["DatePaid"];
	$temp["TotalCash"] = $row["TotalCash"];
	$temp["TotalCheck"] = $row["TotalCheck"];
	$temp["TotalBankTransfer"] = $row["TotalBankTransfer"];
	$temp["Expenses"] = $row["Expenses"];
  $temp["TotalCashOnHand"] = $row["TotalCashOnHand"];

  while ($row2 = $result2->fetch_assoc())  {
    if ($datePaid==$row2["DatePaid"]) {
      $temp2 = array(); // temp array 
      $temp2["DatePaid"] = $row2["DatePaid"];
      $temp2["TotalCash"] = $row2["TotalCash"];
      $temp2["TotalCheck"] = $row2["TotalCheck"];
      $temp2["TotalBankTransfer"] = $row2["TotalBankTransfer"];
      $temp2["Expenses"] = $row2["Expenses"];
      $temp2["TotalCashOnHand"] = $row2["TotalCashOnHand"]; 

      $temp["Details"] = $temp2;
      unset($temp2);
      break;
    }
  }
  array_push($response["summary"], $temp);
}

//Print array in JSON format
 echo json_encode($response, JSON_PRETTY_PRINT);
?>