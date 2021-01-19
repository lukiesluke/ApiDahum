<?php
namespace Phppot;

use \Phppot\DataSource;

class Entry
{
    private $ds;

    function __construct()
    {
        require_once __DIR__ . './DataSource.php';
        $this->ds = new DataSource();
    }
    
    public function getAllEntry($newDate) 
    {
        $query = "SELECT DATE_FORMAT(`deposite_date`,'%M %d, %Y') AS deposite_date, CONCAT(first_name,' ', middle_name,' ', last_name) AS 'name',
        `percent_interest`, `payin_amount`, `profit_amount`, `payout_amount`, DATE_FORMAT(`payin_date`,'%M %d, %Y') AS payin_date, DATE_FORMAT(`payout_date`,'%M %d, %Y') AS payout_date, `move_payment`,
        `reference_number`, `proof_deposit`,`notes`, `bank_account_name`, `bank_name`, `bank_account_number`,`status` FROM `entries` WHERE `deposite_date`=?";
        $cars = array($newDate);
        $result = $this->ds->select($query, 's', $cars);
        return $result;
    }

    public function exportProductDatabase($entryResult) {
        $timestamp = time();
        $filename = 'Export_excel_' . $timestamp . '.xls';
        
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        
        $isPrintHeader = false;
        foreach ($entryResult as $row) {
            if (! $isPrintHeader) {
                echo implode("\t", array_keys($row)) . "\n";
                $isPrintHeader = true;
            }
            echo implode("\t", array_values($row)) . "\n";
        }
        exit();
    }
}
?>