$(document).ready(function(){ $('[data-toggle="tooltip"]').tooltip();});
$('#datepicker').datepicker({ uiLibrary: 'bootstrap4', format: 'mmm-dd-yyyy'});
$('#datepickerentryDate').datepicker({ uiLibrary: 'bootstrap4', format: 'mmm-dd-yyyy'});
$('#datepickerPayin').datepicker({ uiLibrary: 'bootstrap4', format: 'mmm-dd-yyyy'});
$('#datepickerPayoutDate').datepicker({ uiLibrary: 'bootstrap4', format: 'mmm-dd-yyyy'});

function validateSearhForm() {
  var searchDate = document.forms["formSearch"]["searchDate"];
  if(searchDate.value ==""){ 
    searchDate.style.backgroundColor = "#fccccc";
  } else {
    searchDate.style.backgroundColor = "white";
  }
}

function validateForm() {
  var dateEntry = document.forms["formRegistration"]["dateEntry"];
  var fname = document.forms["formRegistration"]["fname"];
  var lname = document.forms["formRegistration"]["lname"];
  var phone = document.forms["formRegistration"]["phone"];
  var email = document.forms["formRegistration"]["email"];
  var payinAmount = document.forms["formRegistration"]["payinAmount"];
  var payinDate = document.forms["formRegistration"]["payinDate"];
  var payoutDate = document.forms["formRegistration"]["payoutDate"];
  var selectModePayment = document.forms["formRegistration"]["selectModePayment"];
  var reference = document.forms["formRegistration"]["reference"];
  var afname = document.forms["formRegistration"]["afname"];
  var alname = document.forms["formRegistration"]["alname"];

  dateEntry.style.backgroundColor = "white";
  fname.style.backgroundColor = "white";
  lname.style.backgroundColor = "white";
  phone.style.backgroundColor = "white";
  email.style.backgroundColor = "white";
  payinAmount.style.backgroundColor = "white";
  payinDate.style.backgroundColor = "white";
  payoutDate.style.backgroundColor = "white";
  reference.style.backgroundColor = "white";
  afname.style.backgroundColor = "white";
  alname.style.backgroundColor = "white";

  var pass = Boolean(1);

  if (dateEntry.value.trim() == "") {
    dateEntry.style.backgroundColor = "#fccccc";
    pass = Boolean(0);
  }
  if (fname.value.trim() == "") {
    fname.style.backgroundColor = "#fccccc";
    pass = Boolean(0);
  }
  if (lname.value.trim() == "") {
    lname.style.backgroundColor = "#fccccc";
  }
  if (phone.value.trim() == "") {
    phone.style.backgroundColor = "#fccccc";
    pass = Boolean(0);
  }
  if (email.value.trim() == "") {
    email.style.backgroundColor = "#fccccc";
    pass = Boolean(0);
  }
  if (payinAmount.value.trim() == "") {
    payinAmount.style.backgroundColor = "#fccccc";
    pass = Boolean(0);
  }
  if (payinDate.value.trim() == "") {
    payinDate.style.backgroundColor = "#fccccc";
    pass = Boolean(0);
  }
  if (payoutDate.value.trim() == "") {
    payoutDate.style.backgroundColor = "#fccccc";
    pass = Boolean(0);
  }

  if (selectModePayment.value == "Choose...") {
    document.getElementById("infoSelectModePayment").innerHTML = "Please select mode of payment";
    pass = Boolean(0);
  }
  if (reference.value.trim() == "") {
    reference.style.backgroundColor = "#fccccc";
    pass = Boolean(0);
  }
  if (afname.value.trim() == "") {
    afname.style.backgroundColor = "#fccccc";
    pass = Boolean(0);
  }
  if (alname.value.trim() == "") {
    alname.style.backgroundColor = "#fccccc";
  }

  var c30 = document.getElementById("check30"); 
  var c50 = document.getElementById("check50");

  if(c30.checked  == false && c50.checked == false) {
    document.getElementById("infoInterest").innerHTML = "Please check any percentage";
  }

  if (pass == false) {
    alert("Please fill out all red fields.");
    return false;
  }
}

function myFunction() {
  $('#passwordsNoMatchRegister').hide();
}

function validateInterest30() {
  var payinAmount = document.getElementById("payinAmount");
  var estimatedProfitReturn = document.getElementById("estimatedProfitReturn");
  var payoutAmount = document.getElementById("payoutAmount");
  document.getElementById("infoInterest").innerHTML = "";

  if (payinAmount.value.trim().length < 1 || payinAmount.value == null || payinAmount.value == "") {
    payinAmount.style.backgroundColor = "#fccccc";
    payinAmount.value = 0;
    estimatedProfitReturn.value = 0;
    payoutAmount.value = 0;
    document.getElementById("check50").checked = false;
    return;
  } else {
    payinAmount.style.backgroundColor = "white";
  }

  payinAmount.value = payinAmount.value.replace(' ','');
  payinAmount.value = payinAmount.value.replace(/\,/g,'');

  if (isNaN(payinAmount.value)) {
    payinAmount.value = 0;
    payinAmount.style.backgroundColor = "#fccccc";
    estimatedProfitReturn.value = 0;
    payoutAmount.value = 0;
    document.getElementById("check50").checked = false;
    return;
  } else {
    payinAmount.style.backgroundColor = "white";
  }

  if (document.getElementById("check30").checked) {
    document.getElementById("check50").checked = false;
    estimatedProfitReturn.value = multifly(payinAmount.value, 0.30);
    payoutAmount.value = add(estimatedProfitReturn.value, payinAmount.value);
  } else {
    document.getElementById("check50").checked = true;
    estimatedProfitReturn.value = multifly(payinAmount.value, 0.50);
    payoutAmount.value = add(estimatedProfitReturn.value, payinAmount.value);
  }
}

function validateInterest50() {
  var payinAmount = document.getElementById("payinAmount");
  var estimatedProfitReturn = document.getElementById("estimatedProfitReturn");
  var payoutAmount = document.getElementById("payoutAmount");
  document.getElementById("infoInterest").innerHTML = "";

  if (payinAmount.value.trim().length < 1 || payinAmount.value == null || payinAmount.value == "") {
    payinAmount.style.backgroundColor = "#fccccc";
    payinAmount.value = 0;
    estimatedProfitReturn.value = 0;
    payoutAmount.value = 0;
    document.getElementById("check30").checked = false;
    return;
  } else {
    payinAmount.style.backgroundColor = "white";
  }
 
  payinAmount.value = payinAmount.value.replace(' ','');
  payinAmount.value = payinAmount.value.replace(/\,/g,'');

  if (isNaN(payinAmount.value)) {
    payinAmount.value = 0;
    payinAmount.style.backgroundColor = "#fccccc";
    estimatedProfitReturn.value = 0;
    payoutAmount.value = 0;
    document.getElementById("check30").checked = false;
    return;
  } else {
    payinAmount.style.backgroundColor = "white";
  }

  if (document.getElementById("check50").checked) {
    document.getElementById("check30").checked = false
    estimatedProfitReturn.value = multifly(payinAmount.value, 0.50);
    payoutAmount.value = add(estimatedProfitReturn.value, payinAmount.value);
  } else {
    document.getElementById("check30").checked = true;
    estimatedProfitReturn.value = multifly(payinAmount.value, 0.30);
    payoutAmount.value = add(estimatedProfitReturn.value, payinAmount.value);
  }
}
function toDescimal(a) {
  return parseFloat(a).toLocaleString()
}

function multifly(a, b) {
  a=a.replace(/\,/g,'');
  return toDescimal(parseFloat(a) * parseFloat(b));
}

function add(a, b) {
  a=a.replace(/\,/g,'');
  return toDescimal(parseFloat(a) + parseFloat(b));
}

function functionTermsAndCondition() {
  var saveAndSubmit = document.getElementById("saveAndSubmit");

  if (document.getElementById("termsAndCondition").checked) {
    saveAndSubmit.disabled = false;
  } else {
    saveAndSubmit.disabled = true;
  }
}

function functionHoldingPeriod(id) {
  switch(id) {
      case "hold1":
        document.getElementById("hold1").checked = true;
        document.getElementById("hold2").checked = false;
        document.getElementById("hold3").checked = false;
        document.getElementById("hold4").checked = false;
        document.getElementById("hold5").checked = false;
        document.getElementById("hold6").checked = false;
        break;
      case "hold2":
        document.getElementById("hold1").checked = false;
        document.getElementById("hold2").checked = true;
        document.getElementById("hold3").checked = false;
        document.getElementById("hold4").checked = false;
        document.getElementById("hold5").checked = false;
        document.getElementById("hold6").checked = false;
        break;
      case "hold3":
        document.getElementById("hold1").checked = false;
        document.getElementById("hold2").checked = false;
        document.getElementById("hold3").checked = true;
        document.getElementById("hold4").checked = false;
        document.getElementById("hold5").checked = false;
        document.getElementById("hold6").checked = false;
        break;
      case "hold4":
        document.getElementById("hold1").checked = false;
        document.getElementById("hold2").checked = false;
        document.getElementById("hold3").checked = false;
        document.getElementById("hold4").checked = true;
        document.getElementById("hold5").checked = false;
        document.getElementById("hold6").checked = false;
        break;
      case "hold5":
        document.getElementById("hold1").checked = false;
        document.getElementById("hold2").checked = false;
        document.getElementById("hold3").checked = false;
        document.getElementById("hold4").checked = false;
        document.getElementById("hold5").checked = true;
        document.getElementById("hold6").checked = false;
        break;
      case "hold6":
        document.getElementById("hold1").checked = false;
        document.getElementById("hold2").checked = false;
        document.getElementById("hold3").checked = false;
        document.getElementById("hold4").checked = false;
        document.getElementById("hold5").checked = false;
        document.getElementById("hold6").checked = true;
        break;
    }
  }

function functionSelectBankName(id) {
switch(id) {
    case "bankName1":
      document.getElementById("bankName1").checked = true;
      document.getElementById("bankName2").checked = false;
      document.getElementById("bankName3").checked = false;
      document.getElementById("bankName4").checked = false;
      document.getElementById("bankName5").checked = false;
      document.getElementById("bankName6").checked = false;
      break;
    case "bankName2":
      document.getElementById("bankName1").checked = false;
      document.getElementById("bankName2").checked = true;
      document.getElementById("bankName3").checked = false;
      document.getElementById("bankName4").checked = false;
      document.getElementById("bankName5").checked = false;
      document.getElementById("bankName6").checked = false;
      break;
    case "bankName3":
      document.getElementById("bankName1").checked = false;
      document.getElementById("bankName2").checked = false;
      document.getElementById("bankName3").checked = true;
      document.getElementById("bankName4").checked = false;
      document.getElementById("bankName5").checked = false;
      document.getElementById("bankName6").checked = false;
      break;
    case "bankName4":
      document.getElementById("bankName1").checked = false;
      document.getElementById("bankName2").checked = false;
      document.getElementById("bankName3").checked = false;
      document.getElementById("bankName4").checked = true;
      document.getElementById("bankName5").checked = false;
      document.getElementById("bankName6").checked = false;
      break;
    case "bankName5":
      document.getElementById("bankName1").checked = false;
      document.getElementById("bankName2").checked = false;
      document.getElementById("bankName3").checked = false;
      document.getElementById("bankName4").checked = false;
      document.getElementById("bankName5").checked = true;
      document.getElementById("bankName6").checked = false;
      break;
    case "bankName6":
      document.getElementById("bankName1").checked = false;
      document.getElementById("bankName2").checked = false;
      document.getElementById("bankName3").checked = false;
      document.getElementById("bankName4").checked = false;
      document.getElementById("bankName5").checked = false;
      document.getElementById("bankName6").checked = true;
      break;
  }
}

function functionSelectModePayment() {
  var x = document.getElementById("selectModePayment");
  var info = document.getElementById("infoSelectModePayment");

  if (x.value == "Choose..."){
    info.innerHTML = "Please select mode of payment";
  } else {
    info.innerHTML = "&nbsp;";
  }
}

function functionClientInfo(id) {
  var info = document.getElementById(id);

  switch(id) {
    case "fname":
      document.getElementById("afname").value = info.value.trim();
      break;
    case "lname":
      document.getElementById("alname").value = info.value.trim();
      break;
  }
}

function exportTableToExcel(tableID, filename = ''){
  var downloadLink;
  var dataType = 'application/vnd.ms-excel';
  var tableSelect = document.getElementById(tableID);
  var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
  
  // Specify file name
  filename = filename?filename+'.xls':'excel_data.xls';
  
  // Create download link element
  downloadLink = document.createElement("a");
  
  document.body.appendChild(downloadLink);
  
  if(navigator.msSaveOrOpenBlob){
      var blob = new Blob(['\ufeff', tableHTML], {
          type: dataType
      });
      navigator.msSaveOrOpenBlob( blob, filename);
  }else{
      // Create a link to the file
      downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
  
      // Setting the file name
      downloadLink.download = filename;
      
      //triggering the function
      downloadLink.click();
  }
}