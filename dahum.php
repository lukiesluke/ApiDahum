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

//Initialize array variable
$response["summary"] = array();

//Query fetch summary result
$query = "SELECT `date_paid` DatePaid,  
SUM(CASE WHEN `payment_type`=0 THEN `paid_amount` ELSE 0 END) TotalCash,
SUM(CASE WHEN `payment_type`=1 THEN `paid_amount` ELSE 0 END) TotalCheck,
SUM(CASE WHEN `payment_type`=2 THEN `paid_amount` ELSE 0 END) TotalBankTransfer,
SUM(`commission`) AS Expenses, 
SUM(IF(`payment_type` = 0, `paid_amount`-`commission`,0)) AS TotalCashOnHand
FROM `db_transaction` t GROUP BY `date_paid` ORDER BY `date_paid` DESC";

$queryDetails = "SELECT l.`id`, l.`proj_name`,
(SELECT IFNULL(SUM(it.`paid_amount`),0) FROM `db_transaction` it WHERE it.`proj_id`=t.`proj_id` AND  it.`payment_type`=0 AND it.`date_paid` BETWEEN ? AND ?) AS cash,
(SELECT IFNULL(SUM(it.`paid_amount`),0) FROM `db_transaction` it WHERE it.`proj_id`=t.`proj_id` AND  it.`payment_type`=1 AND it.`date_paid` BETWEEN ? AND ?) AS 'check',
(SELECT IFNULL(SUM(it.`paid_amount`),0) FROM `db_transaction` it WHERE it.`proj_id`=t.`proj_id` AND  it.`payment_type`=2 AND it.`date_paid` BETWEEN ? AND ?) AS 'bankTransfer',
(SELECT IFNULL(SUM(it.`commission`),0) FROM `db_transaction` it WHERE it.`proj_id`=t.`proj_id` AND it.`date_paid` BETWEEN ? AND ?) AS 'expenses',
(SELECT IFNULL(SUM(it.`paid_amount`)-SUM(it.`commission`),0) FROM `db_transaction` it WHERE it.`proj_id`=t.`proj_id` AND  it.`payment_type`=0 AND it.`date_paid` BETWEEN ? AND ?) AS 'total'
FROM `db_project_list` l LEFT JOIN `db_transaction` t ON l.id = t.`proj_id` GROUP BY l.`id` ORDER BY l.`proj_name` ASC";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows>0) {
  while ($row = $result->fetch_assoc()) {
    $temp = array(); // temp array 
    $datePaid = $row["DatePaid"];
    $temp["DatePaid"] = $row["DatePaid"];
    $temp["TotalCash"] = $row["TotalCash"];
    $temp["TotalCheck"] = $row["TotalCheck"];
    $temp["TotalBankTransfer"] = $row["TotalBankTransfer"];
    $temp["Expenses"] = $row["Expenses"];
    $temp["TotalCashOnHand"] = $row["TotalCashOnHand"];

    $stmt2 = $conn->prepare($queryDetails);
    $dt = $datePaid;
    $stmt2->bind_param("ssssssssss", $dt, $dt, $dt, $dt, $dt, $dt, $dt, $dt, $dt, $dt);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    $response["Details"] = array();
    while ($row2 = $result2->fetch_assoc()) {
      $temp2 = array(); // temp array 
      $temp2["proj_name"] = $row2["proj_name"];
      $temp2["cash"] = $row2["cash"];
      $temp2["check"] = $row2["check"];
      $temp2["bankTransfer"] = $row2["bankTransfer"];
      $temp2["expenses"] = $row2["expenses"];
      $temp2["total"] = $row2["total"];
      array_push($response["Details"], $temp2);
    }
    $temp["Details"] = $response["Details"];
    unset($response["Details"]);

    array_push($response["summary"], $temp);
  }
}


// while ($row = $result->fetch_assoc())  {
//   $temp = array(); // temp array 
//   $datePaid = $row["DatePaid"];
//   $temp["DatePaid"] = $row["DatePaid"];
// 	$temp["TotalCash"] = $row["TotalCash"];
// 	$temp["TotalCheck"] = $row["TotalCheck"];
// 	$temp["TotalBankTransfer"] = $row["TotalBankTransfer"];
// 	$temp["Expenses"] = $row["Expenses"];
//   $temp["TotalCashOnHand"] = $row["TotalCashOnHand"];

//   while ($row2 = $result2->fetch_assoc())  {
//     if ($datePaid==$row2["DatePaid"]) {
//       $temp2 = array(); // temp array 
//       $temp2["DatePaid"] = $row2["DatePaid"];
//       $temp2["TotalCash"] = $row2["TotalCash"];
//       $temp2["TotalCheck"] = $row2["TotalCheck"];
//       $temp2["TotalBankTransfer"] = $row2["TotalBankTransfer"];
//       $temp2["Expenses"] = $row2["Expenses"];
//       $temp2["TotalCashOnHand"] = $row2["TotalCashOnHand"]; 

//       $temp["Details"] = $temp2;
//       unset($temp2);
//       break;
//     }
//   }
//   array_push($response["summary"], $temp);
// }

//Print array in JSON format
 echo json_encode($response, JSON_PRETTY_PRINT);

$stmt->close();
$stmt2->close();
$conn->close();

?>