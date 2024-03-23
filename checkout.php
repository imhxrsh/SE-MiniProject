<?php

session_start();

if (isset($_SESSION["user_id"])) {
    $isLoggedIn = true;
} else {
    $isLoggedIn = false;
}

include 'conn.php';

$sql = "SELECT id FROM bookings ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$id = $row['id'];

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myriad - Confirmed</title>
    <?php include 'includes/style_include.html' ?>
</head>

<body>
    <?php include 'includes/navbar.php' ?>
    <div class="confirm-container p-2">
        <div class="printer-top"></div>

        <div class="paper-container">
            <div class="printer-bottom"></div>

            <div class="paper">
                <div class="main-contents">
                    <div class="success-icon">&#10004;</div>
                    <div class="success-title">
                        Booking Complete
                    </div>
                    <div class="success-description">
                        Your booking has been confirmed. Please check your email for more details.
                    </div>
                    <div class="order-details">
                        <div class="order-number-label">Booking ID</div>
                        <div class="order-number"><?php echo $id; ?></div>
                    </div>
                    <div class="order-footer">Thank you!</div>

                </div>
                <div class="jagged-edge"></div>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.html' ?>
    <?php include 'includes/js_include.html' ?>
</body>

</html>