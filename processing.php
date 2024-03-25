<?php
session_start();
include 'conn.php';

require 'config.php';
$order_id = $_POST['razorpay_order_id'];
$razorpay_payment_id = $_POST['razorpay_payment_id'];
$razorpay_signature = $_POST['razorpay_signature'];

$generated_signature = hash_hmac('sha256', $order_id . '|' . $razorpay_payment_id, $keySecret);
if ($generated_signature == $razorpay_signature) {
    $conn->query("UPDATE bookings SET `payment_status` = TRUE, `payment_id` = '$razorpay_payment_id' WHERE rzp_id = '$order_id'");
    echo "success";
} else {
    $conn->query("UPDATE bookings SET `payment_status` = FALSE WHERE rzp_id = '$order_id'");
    echo "failure";
}
?>