<?php
/*
Callback location, set this in blockonmics merchant page

For testing payments locally, use this:
localhost/wptest/check?secret=escrowtics&addr=dfghkjhgfdfgjkhghkjhgfhjkhgfhjkhghjkhghjhg&status=2&txid=RTRYUY235566&value=7800
*/


use Escrowtics\api\BitcoinPay\BitcoinPayConfig;

defined('ABSPATH') or die();

if(!isset($_GET['code'])){ exit(); }

$btc_obj = new BitcoinPayConfig();

$secretlocal = "escrowtics"; // Code in the callback, make sure this matches to what youve set

// Check all are set
if(!isset($_GET['txid']) || !isset($_GET['value']) || !isset($_GET['status']) || !isset($_GET['addr']) !isset($_GET['secret'])){
    exit();
}

// Get all these values
$status = 0;
$txid = $_GET['txid'];
$value = $_GET['value'];
$status = $_GET['status'];
$addr = $_GET['addr'];
$secret = $_GET['secret'];


if($secret != $secretlocal){
    exit();
}


/* $sql = "INSERT INTO `payments` (`txid`, `value`, `addr`, `status`)
VALUES ('$txid', '$value', '$addr', '$status')";
mysqli_query($conn, $sql);
echo $sql; */

// Get invoice information
$code = $btc_obj->getInvoiceDataByAddr($addr);
$invoice = $btc_obj->getInvoiceDataByCode($code);

// Get invoice price
$amount = $invoice['amount'];

// Convert amount to satoshi for check
$amount = $btc_obj->USDtoBTC($amount);
$amount = $amount *100000000;

// Expired
if($status < 0){
    exit();
}


if($value >= round($amount)){
    // Update invoice status
    $btc_obj->updateInvoiceStatus($code, $status);
    if($status == 2){ // Correct amount paid and fully confirmed
	
        //Update User Balance
		$user_id = $invoice['user_id'];
		$bal = escrot_get_user_data($user_id)['balance'];
		$new_bal = $bal + $amount;
		$data = ['balance' => $new_bal, 'user_id' => $user_id]
		$btc_obj->updateUser($data);
    }
}else {
    // Buyer hasnt paid enough
    $btc_obj->updateInvoiceStatus($code, -2);
}
?>