<?php
namespace Phppot;

//include 'db.conn.php';


use \Phppot\Entry;
use \Datetime;

require_once __DIR__ . './class/Entry.php';

$entry = new Entry();

if ($_SERVER["REQUEST_METHOD"] == "POST") {



  if (!empty($_POST["searchDate"])) {
    $myDateTime = DateTime::createFromFormat('M-d-Y', $_POST["searchDate"]);
    $newDate = $myDateTime->format('Y-m-d');
    $entryResult = $entry->getAllEntry($newDate);
  }

  if (isset($_POST["export"])) {

    $entryResult = $entry->getAllEntry('2020-12-08');
    $entry->exportProductDatabase($entryResult);

  }

}

// if ($_SERVER["REQUEST_METHOD"] == "POST") {

//   if (!empty($_POST["searchDate"])) {
//     $sql = "SELECT DATE_FORMAT(`deposite_date`,'%M %d, %Y') AS deposite_date, CONCAT(first_name,' ', middle_name,' ', last_name) AS 'name',
//     `percent_interest`, `payin_amount`, `profit_amount`, `payout_amount`, DATE_FORMAT(`payin_date`,'%M %d, %Y') AS payin_date, DATE_FORMAT(`payout_date`,'%M %d, %Y') AS payout_date, `move_payment`,
//     `reference_number`, `proof_deposit`,`notes`, `bank_account_name`, `bank_name`, `bank_account_number`,`status` FROM `entries` WHERE DATE(`deposite_date`)=?";

//     $myDateTime = DateTime::createFromFormat('M-d-Y', $_POST['searchDate']);
//     $newDate = $myDateTime->format('Y-m-d');

//     // prepare and bind
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("s", $newDate);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $stmt->close();
//     $conn->close();
//   }
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Forex Stocks Riders</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
  <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href= "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> 
</head> 
</head>
<body class="bg-dark">
<?php include 'header.php';?>

<div class="container-fluid">
<button class="btn btn-info mt-1" onclick="exportTableToExcel('tblData', 'members-data')">Export to Excel</button>
        <table id="tblData" class="table table-hover table-responsive table-striped table-bordered small mt-2 bg-white">
            <thead>
                <tr>
                    <th class="font-weight-bold align-middle small text-nowrap">DATE OF DEPOSIT</th>
                    <th class="font-weight-bold align-middle small text-nowrap">FULL NAME</th>
                    <th class="font-weight-bold text-center align-middle small">%</th>
                    <th class="font-weight-bold text-center align-middle small text-nowrap">PAYIN AMOUNT</th>
                    <th class="font-weight-bold text-center align-middle small">PROFIT</th>
                    <th class="font-weight-bold text-center align-middle small text-nowrap">PAYOUT AMOUNT</th>
                    <th class="font-weight-bold text-center align-middle small text-nowrap">PAYIN DATE</th>
                    <th class="font-weight-bold text-center align-middle small text-nowrap">PAYOUT DATE</th>
                    <th class="font-weight-bold text-center align-middle small text-nowrap">MODE OF PAYMENT</th>
                    <th class="font-weight-bold text-center align-middle small text-nowrap">REFERENCE / CONFIRMATION NUMBER</th>
                    <th class="font-weight-bold text-center align-middle small">
                    <span style="color:blue" data-toggle="tooltip" title="EMAIL PROOF OF DEPOSIT TO FOREX and PASTE THE IMAGE OR GOOGLE LINK">PROOF</span>
                    </th>
                    <th class="font-weight-bold text-center align-middle small">NOTES</th>
                    <th class="font-weight-bold text-center align-middle small text-nowrap">BANK ACCOUNT HOLDER NAME</th>
                    <th class="font-weight-bold text-center align-middle small text-nowrap">BANK NAME</th>
                    <th class="font-weight-bold text-center align-middle small text-nowrap">BANK ACCOUNT NUMBER</th>
                    <th class="font-weight-bold text-center align-middle small">STATUS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($entryResult)) {
                  foreach ($entryResult as $key => $value) {?>
                <tr>
                    <td><span class="text-nowrap"><?php echo $entryResult[$key]["deposite_date"]; ?></span></td>
                    <td><span class="text-nowrap"><?php echo $entryResult[$key]["name"]; ?></span></td>
                    <td><span class="text-nowrap"><?php echo $entryResult[$key]["percent_interest"]; ?></span></td>
                    <td><span class="text-nowrap"><?php echo number_format($entryResult[$key]["payin_amount"], 2); ?></span></td>
                    <td><span class="text-nowrap"><?php echo number_format($entryResult[$key]["profit_amount"], 2); ?></span></td>
                    <td><span class="text-nowrap"><?php echo number_format($entryResult[$key]["payout_amount"], 2); ?></span></td>
                    <td><span class="text-nowrap"><?php echo $entryResult[$key]["payin_date"]; ?></span></td>
                    <td><span class="text-nowrap"><?php echo $entryResult[$key]["payout_date"]; ?></span></td>
                    <td><span class="text-nowrap"><?php echo $entryResult[$key]["move_payment"]; ?></span></td>
                    <td><span class="text-nowrap"><?php echo $entryResult[$key]["reference_number"]; ?></span></td>
                    <td><span class="text-nowrap"><?php echo $entryResult[$key]["proof_deposit"]; ?></span></td>
                    <td><span class="text-nowrap" style="color:blue" data-toggle="tooltip" title="<?php echo $entryResult[$key]["notes"]; ?>">Show Notes</span></td>
                    <td><span class="text-nowrap"><?php echo $entryResult[$key]["bank_account_name"]; ?></span></td>
                    <td><span class="text-nowrap"><center><?php echo $entryResult[$key]["bank_name"]; ?></center></td>
                    <td><span class="text-nowrap"><?php echo $entryResult[$key]["bank_account_number"]; ?></td>
                    <td><span class="text-nowrap"><?php echo $entryResult[$key]["status"]; ?></td>
                </tr>
                <?php } } else { ?>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
</div>
<br><br>
<script src="build/js/myScript.js"></script>
<br><br>
</body>
</html>