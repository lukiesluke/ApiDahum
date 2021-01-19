<?php include 'db.conn.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $myDateTime = DateTime::createFromFormat('M-d-Y', $_POST["dateEntry"]);
    $dateEntry = $myDateTime->format('Y-m-d');

    $myDateTime = DateTime::createFromFormat('M-d-Y', $_POST["payinDate"]);
    $payinDate = $myDateTime->format('Y-m-d');
    
    $myDateTime = DateTime::createFromFormat('M-d-Y', $_POST["payoutDate"]);
    $payoutDate = $myDateTime->format('Y-m-d');

    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $payinAmount = floatval(preg_replace('/[^\d.]/', '', $_POST["payinAmount"]));
    $estimatedProfitReturn = floatval(preg_replace('/[^\d.]/', '', $_POST["estimatedProfitReturn"]));
    $payoutAmount = floatval(preg_replace('/[^\d.]/', '', $_POST["payoutAmount"]));
    $selectModePayment = $_POST["selectModePayment"];
    $reference = $_POST["reference"];
    $notes = $_POST["notes"];

    $afname = $_POST["afname"];
    $amname = $_POST["amname"];
    $alname = $_POST["alname"];

    // Percentage interest
    if (@$_POST["check30"] != "") {
        $percentage = @$_POST["check30"];
    }
    if (@$_POST["check50"] != "") {
        $percentage = @$_POST["check50"];
    }

    //Holding Period
    if (@$_POST["hold1"] != "") {
        $holdingPeriod = @$_POST["hold1"];
    }
    if (@$_POST["hold2"] != "") {
        $holdingPeriod = @$_POST["hold2"];
    }
    if (@$_POST["hold3"] != "") {
        $holdingPeriod = @$_POST["hold3"];
    }
    if (@$_POST["hold4"] != "") {
        $holdingPeriod = @$_POST["hold4"];
    }
    if (@$_POST["hold5"] != "") {
        $holdingPeriod = @$_POST['hold5'];
    }
    if (@$_POST["hold6"] != "") {
        $holdingPeriod = @$_POST["hold6"];
    }

    //Bank Name
    if (@$_POST["bankName1"] != "") {
        $bankName = @$_POST["bankName1"];
    }
    if (@$_POST["bankName2"] != "") {
        $bankName = @$_POST["bankName2"];
    }
    if (@$_POST["bankName3"] != "") {
        $bankName = @$_POST["bankName3"];
    }
    if (@$_POST["bankName4"] != "") {
        $bankName = @$_POST["bankName4"];
    }
    if (@$_POST["bankName5"] != "") {
        $bankName = @$_POST["bankName5"];
    }
    if (@$_POST["bankName6"] != "") {
        $bankName = @$_POST["bankName6"];
    }
    
    $sql ="INSERT INTO `entries` (`deposite_date`,`first_name`,`middle_name`,`last_name`,`phone_nume`,`email`,`percent_interest`,
    `payin_amount`,`profit_amount`,`payout_amount`,`payin_date`,`payout_date`,`move_payment`,`reference_number`,`notes`,`bank_name`,
    `bank_account_name`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    // prepare and bind
    $stmt = $conn->prepare($sql);
    $acc = "$afname $amname $alname";
    $stmt->bind_param("sssssssdddsssssss", $dateEntry, $afname, $amname, $alname, $phone, $email, $percentage, 
    $payinAmount, $estimatedProfitReturn,$payoutAmount,$payinDate, $payoutDate, $selectModePayment, $reference, $notes, $bankName, $acc);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    echo 'DateEntry: ' . $dateEntry.'<br>';
    echo 'fname: '. $fname . ' : lname: '. $lname . '<br>';
    echo 'phone: '. $phone . ' : email: '. $email . '<br>';
    echo 'payinAmount: ' . $payinAmount . ' : Percentage: ' . $percentage.'<br>';
    echo 'estimatedProfitReturn: ' . $estimatedProfitReturn . ' : payoutAmount: ' . $payoutAmount .'<br>';
    echo 'payinDate: ' . $payinDate. ' : holdingPeriod: ' . $holdingPeriod.'<br>';
    echo 'payoutDate: ' . $payoutDate. ' : selectModePayment: ' . $selectModePayment.'<br>';
    echo 'reference: ' . $reference. ' : notes: ' . $notes.'<br>';
    echo 'BankName: ' . $bankName. ' : AccountName: ' . $afname. ' '. $amname .' '. $alname.'<br>';
    echo "Account Name: $afname $amname $alname";
}

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

  <link rel="stylesheet" href="build/css/styles.css">

  <!--
  <link rel="stylesheet" href="build/css/intlTelInput.css">
  <link rel="stylesheet" href="build/css/demo.css">
   https://www.jqueryscript.net/form/jQuery-International-Telephone-Input-With-Flags-Dial-Codes.html -->
</head>
<body class="bg-dark">
<?php include 'header.php';?>
<div class="container pt-3 my-3">
    <!-- Form -->
    <form class="bg-white px-3" name="formRegistration" action="registration.php" onsubmit="return validateForm()" method="post">
        <!-- Title Page -->
        <div class="form-row justify-content-center align-items-center">
            <div class="form-group col-md-6">
                <p class="h3 text-center mt-5">FOREX Trading Request Form</p>
            </div>
        </div>
        <!--End of Title Page -->

        <!-- Date Entry-->
        <div class="form-row justify-content-center align-items-center">
            <div class="form-group col-md-3">
                <label>Date*</label>
                <input id="datepickerentryDate" name="dateEntry" placeholder="Date" aria-label="Date" readonly>
                <script src="build/js/myScript.js"></script>
            </div>
            <div class="form-group col-md-3">
            </div>
        </div>
        <!--End of Date Entry -->

        <!-- Client Name Info -->
        <div class="form-row justify-content-center align-items-center">
            <div class="form-group col-md-3">
                <label>Name*</label>
                <input type="text" class="form-control" id="fname" name="fname" placeholder="Name" onkeyup="functionClientInfo('fname')">
                <label class="font-italic small font-weight-lighter">First</label>
            </div>
            <div class="form-group col-md-3">
                <label>&nbsp;</label>
                <input type="text" class="form-control" id="lname" name="lname" placeholder="Last" onkeyup="functionClientInfo('lname')">
                <label class="font-italic small font-weight-lighter">Last</label>    
            </div>
        </div>
        <!--End of Client Name Info -->

        <!--Contact Info -->
        <div class="form-row justify-content-center align-items-center">
            <div class="form-group col-md-3">
                <label>Phone*</label>
                <input type="text" class="form-control" name="phone" placeholder="Phone">
            </div>
            <div class="form-group col-md-3">
                <label>Email*</label>
                <input type="email" class="form-control" name="email" placeholder="Email">
            </div>
        </div>
        <!--End of Contact Info -->

        <!-- Payin Amount and Interest -->
        <div class="form-row justify-content-center align-items-center">
            <div class="form-group col-md-3">
                <label>Pay-IN Amount*</label>
                <input type="text" class="form-control" id="payinAmount" name="payinAmount" placeholder="Pay-IN Amount">
                <label class="font-italic small font-weight-lighter">Enter amount you want to invest</span></label>
            </div>
            <div class="form-group col-md-3">
                <label>Interest*</label>
                <div class="form-check form-check-inline">
                    <div class="form-check form-check-inline mx-3">
                        <input class="form-check-input" type="checkbox" id="check30" name="check30" value="30%" onchange="return validateInterest30()">
                        <label class="form-check-label small">30% Rider</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="check50" name="check50" value="50%" onchange="return validateInterest50()">
                        <label class="form-check-label small">50% Rider</label>
                    </div>
                </div>
                <p class="small text-danger mx-3" id="infoInterest"></p>
                <div class="form-group">
                    <label>&nbsp;&nbsp;</label>
                </div>
            </div>
        </div>
        <!--End of Payin Amount and Interest -->
        
        <!-- Estimated Profit Return and  Pay-OUT Amount-->
        <div class="form-row justify-content-center align-items-center">
            <div class="form-group col-md-3">
                <label>Estimated Profit Return</label>
                <input type="text" class="form-control" id="estimatedProfitReturn" name="estimatedProfitReturn" placeholder="0.00" readonly>
                <label class="font-italic small font-weight-lighter">Projected Profit Based on Interest</label>
            </div>
            <div class="form-group col-md-3">
                <label>Pay-OUT Amount</label>
                <input type="text" class="form-control" id="payoutAmount" name="payoutAmount" placeholder="0.00" readonly>
                <label class="font-italic small font-weight-lighter">Total Return on Investment</label>
            </div>
        </div>
        <!--End of Estimated Profit Return and  Pay-OUT Amount-->

        <!-- Pay-IN Date and Pay-IN Holding Period -->
        <div class="form-row justify-content-center align-items-center">
            <div class="form-group col-md-3">
                <label >Pay-IN Date*</label>
                <input id="datepickerPayin" name="payinDate" placeholder="Date" aria-label="datepickerPayin" readonly>
                <script src="build/js/myScript.js"></script>
                <label class="font-italic small font-weight-lighter">dd-MMM-yyyy<br>Enter exact date of PAY-IN</label>
            </div>
            <div class="form-group col-md-3">
                <label>Pay-IN Holding Period*</label> 
                <div class="container-sm">
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="hold1" name="hold1" value="30 days" onchange="return functionHoldingPeriod('hold1')" checked>
                    <label class="form-check-label small" for="inlineCheckbox1">30 days</label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="hold2" name="hold2" value="45 days" onchange="return functionHoldingPeriod('hold2')">
                    <label class="form-check-label small" for="inlineCheckbox2">45 days</label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="hold3" name="hold3" value="60 days" onchange="return functionHoldingPeriod('hold3')">
                    <label class="form-check-label small" for="inlineCheckbox3">60 days</label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="hold4" name="hold4" value="90 days" onchange="return functionHoldingPeriod('hold4')">
                    <label class="form-check-label small" for="inlineCheckbox3">90 days</label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="hold5" name="hold5" value="120 days" onchange="return functionHoldingPeriod('hold5')">
                    <label class="form-check-label small" for="inlineCheckbox3">120 days</label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="hold6" name="hold6" value="180 days" onchange="return functionHoldingPeriod('hold6')">
                    <label class="form-check-label small" for="inlineCheckbox3">180 days</label>
                    </div>
                </div>
            </div>
        </div>
        <!--End of Pay-IN Date and Pay-IN Holding Period -->
        
        <!-- Pay-OUT Date and Mode of payment for PAY-IN -->
        <div class="form-row justify-content-center align-items-center">
            <div class="form-group col-md-3">
                <label>Pay-OUT Date*</label>
                <input id="datepickerPayoutDate" placeholder="Date" id="payoutDate" name="payoutDate" aria-label="datepickerPayoutDate" readonly>
                <script src="build/js/myScript.js"></script>
                <label class="font-italic small font-weight-lighter">Select last date on the calendar based on the PAYIN holding period</label>
            </div>
            <div class="form-group col-md-3">
                <label>Mode of payment for PAY-IN *</label>
                    <select class="form-control" id="selectModePayment" name="selectModePayment" onchange="functionSelectModePayment()">
                        <option selected>Choose...</option>
                        <option>BDO</option>
                        <option>BPI</option>
                        <option>EastWest Bank</option>
                        <option>GCash</option>
                        <option>Security Bank</option>
                        <option>Cash</option>
                    </select>
                <label class="font-italic small font-weight-lighter">Select mode of payment<br><span class="text-danger" id="infoSelectModePayment">&nbsp;</span></label>
            </div>
        </div>
        <!--End of Pay-OUT Date and Mode of payment for PAY-IN -->
        
        <!-- Reference and Confirmation Number(s) -->
        <div class="form-row justify-content-center align-items-center">
            <div class="form-group col-md-3">
                <label>Reference and Confirmation Number(s)*</label>
                <input type="text" class="form-control" name="reference" placeholder="Reference">
                <label class="font-italic small font-weight-lighter">Indicate complete reference number(s). Multiple entries allowed if more than one payment.</label>
            </div>
            <div class="form-group col-md-3">
                <label>Attach Proof of Payment*</label>
                <input type="text" class="form-control" name="upload" placeholder="upload">
                <label class="font-italic small font-weight-lighter">Attach photo or screenshot of payment slip. Maximum of 5 files.</label>    
            </div>
        </div>
        <!--End of Reference and Confirmation Number(s) -->

        <div class="form-row justify-content-center align-items-center">
            <div class="form-group col-md-6">
                <label>Notes</label>
                <textarea class="form-control" name="notes" rows="3"></textarea>
                <label class="font-italic small font-weight-lighter">Input notes, reminders, or special instructions</label>
            </div>
        </div>
        <div class="form-row justify-content-center align-items-center">
            <div class="form-group col-md-6">
            <div class="form-group">
                <label>MODE OF PAY-OUT</label>
                <hr class="my-1">
                <label class="font small font-weight-lighter">ENTER DETAILS WHERE YOU WANT US TO DEPOSIT YOUR PAYOUT</label>
            </div>
            </div>
        </div>

        <!-- Bank Name (Primary) -->
        <div class="form-row justify-content-center align-items-center">
            <div class="form-group col-md-6">
                <label>Bank Name (Primary)*</label>
                <div class="form-check">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="BDO" id="bankName1" name="bankName1" onchange="return functionSelectBankName('bankName1')">
                        <label class="form-check-label small align-text-top">BDO</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="METROBANK" id="bankName2" name="bankName2" onchange="return functionSelectBankName('bankName2')">
                        <label class="form-check-label small align-text-top">METROBANK</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="BPI" id="bankName3" name="bankName3" onchange="return functionSelectBankName('bankName3')">
                        <label class="form-check-label small align-text-top">BPI</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="UNIONBANK" id="bankName4" name="bankName4" onchange="return functionSelectBankName('bankName4')">
                        <label class="form-check-label small align-text-top">UNIONBANK</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="EASTWEST BANK" id="bankName5" name="bankName5" onchange="return functionSelectBankName('bankName5')">
                        <label class="form-check-label small align-text-top">EASTWEST BANK</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="CASH" id="bankName6" name="bankName6" onchange="return functionSelectBankName('bankName6')" checked>
                        <label class="form-check-label small align-text-top">CASH</label>
                    </div>
                </div>
            </div>
        </div>
        <!--End of Bank Name (Primary) -->

        <!--Bank Acount Information -->
        <div class="form-row justify-content-center align-items-center">
            <div class="form-group col-md-2">
                <label>Account Name*</label>
                <input type="text" class="form-control" id="afname" name="afname" placeholder="Name">
                <label class="font-italic small font-weight-lighter">First</label>
            </div>
            <div class="form-group col-md-2">
                <label>&nbsp;</label>
                <input type="text" class="form-control" name="amname" placeholder="Middle">
                <label class="font-italic small font-weight-lighter">Middle</label>    
            </div>
            <div class="form-group col-md-2">
                <label>&nbsp;</label>
                <input type="text" class="form-control" id="alname" name="alname" placeholder="Last">
                <label class="font-italic small font-weight-lighter">Last</label>    
            </div>
        </div>
        <!--End Of Bank Acount Information -->

        <!--Memorandum Forms -->
        <div class="form-row justify-content-center align-items-center">
            <?php include 'memorandum.php';?>
        </div>
        <!--End of Memorandum Forms -->

        <!--Button Forms -->
        <div class="form-row justify-content-center align-items-center">
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-sm my-small-btn">Review</button>
                <button type="submit" class="btn btn-primary btn-sm my-small-btn" name="saveAndSubmit"  id="saveAndSubmit" disabled>Save</button>
            </div>
        </div>
        <!--End of Button Forms -->

    <!-- Form end -->
    </form>
</div>
<br><br>
</body>
</html>