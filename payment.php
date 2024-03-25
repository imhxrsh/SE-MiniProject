<?php
session_start();

if(isset($_POST['razorpay_payment_id']) && isset($_POST['razorpay_order_id']) && isset($_POST['razorpay_signature'])) {
    $_SESSION['razorpay_payment_id'] = $_POST['razorpay_payment_id'];
    $_SESSION['razorpay_order_id'] = $_POST['razorpay_order_id'];
    $_SESSION['razorpay_signature'] = $_POST['razorpay_signature'];
    echo "Session variables set successfully.";
} else {
    echo "Error: One or more variables not received.";
}
?>
