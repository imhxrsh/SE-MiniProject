<?php
session_start();
include 'conn.php';

require 'config.php';
$order_id = $conn->query("SELECT rzp_id FROM bookings ORDER BY rzp_id DESC LIMIT 1")->fetch_assoc()['rzp_id'] ?? null;
$razorpay_payment_id = $_SESSION['razorpay_payment_id'];
$razorpay_signature = $_SESSION['razorpay_signature'];

$generated_signature = hash_hmac('sha256', $order_id . '|' . $razorpay_payment_id, $keySecret);
if ($generated_signature == $razorpay_signature) {
    $conn->query("UPDATE bookings SET `payment_status` = TRUE, `payment_id` = '$razorpay_payment_id' WHERE rzp_id = '$order_id'");
    sleep(2);
    header('Location: /success');
} else {
    $conn->query("UPDATE bookings SET `payment_status` = FALSE WHERE rzp_id = '$order_id'");
    sleep(2);
    header('Location: /failed');
}

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myriad - Booking</title>
    <?php include 'includes/style_include.html' ?>
</head>

<body>
    <?php include 'includes/navbar.php' ?>
    <style>
        svg rect,
        svg path {
            fill: #FFF;
        }
    </style>
    <div class="d-flex align-items-center justify-content-center">
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="240px" height="300px" viewBox="0 0 24 30" style="enable-background:new 0 0 50 50;" xml:space="preserve">
            <rect x="0" y="10" width="4" height="10" fill="#333" opacity="0.2">
                <animate attributeName="opacity" attributeType="XML" values="0.2; 1; .2" begin="0s" dur="0.6s" repeatCount="indefinite" />
                <animate attributeName="height" attributeType="XML" values="10; 20; 10" begin="0s" dur="0.6s" repeatCount="indefinite" />
                <animate attributeName="y" attributeType="XML" values="10; 5; 10" begin="0s" dur="0.6s" repeatCount="indefinite" />
            </rect>
            <rect x="8" y="10" width="4" height="10" fill="#333" opacity="0.2">
                <animate attributeName="opacity" attributeType="XML" values="0.2; 1; .2" begin="0.15s" dur="0.6s" repeatCount="indefinite" />
                <animate attributeName="height" attributeType="XML" values="10; 20; 10" begin="0.15s" dur="0.6s" repeatCount="indefinite" />
                <animate attributeName="y" attributeType="XML" values="10; 5; 10" begin="0.15s" dur="0.6s" repeatCount="indefinite" />
            </rect>
            <rect x="16" y="10" width="4" height="10" fill="#333" opacity="0.2">
                <animate attributeName="opacity" attributeType="XML" values="0.2; 1; .2" begin="0.3s" dur="0.6s" repeatCount="indefinite" />
                <animate attributeName="height" attributeType="XML" values="10; 20; 10" begin="0.3s" dur="0.6s" repeatCount="indefinite" />
                <animate attributeName="y" attributeType="XML" values="10; 5; 10" begin="0.3s" dur="0.6s" repeatCount="indefinite" />
            </rect>
        </svg>
    </div>
    <?php include 'includes/footer.html' ?>
    <?php include 'includes/js_include.html' ?>
</body>

</html>