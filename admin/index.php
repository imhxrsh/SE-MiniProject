<?php
session_start();

if (isset($_SESSION["role"]) && $_SESSION["role"] != "Admin") {
    $_SESSION = array();
    session_destroy();
    header("Location: login?error=userLoggedIn");
    exit;
} else if (isset($_SESSION["user_id"])) {
    $isLoggedIn = true;
} else {
    $isLoggedIn = false;
    header("Location: login?error=notLoggedIn");
}

include('../conn.php');

$booking = mysqli_query($conn, "SELECT * FROM `bookings`") or die('query failed');
$bookings = mysqli_num_rows($booking);

$hotel = mysqli_query($conn, "SELECT * FROM `hotels`") or die('query failed');
$hotels = mysqli_num_rows($hotel);

$user = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
$users = mysqli_num_rows($user);

$sale = mysqli_query($conn, "SELECT `total_price` FROM `bookings`") or die('query failed');
$sales = 0;
while ($row = mysqli_fetch_assoc($sale)) {
    $sales += $row['total_price'];
}

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myriad - Admin</title>
    <?php include '../includes/style_include.html' ?>
</head>

<body>
    <?php include 'includes/navbar.php' ?>
    <div class="container">
        <div class="row justify-content-center py-5">
            <div class="text-center mb-5">
                <h1>Dashboard</h1>
            </div>
            <div class="d-flex row text-center justify-content-center align-items-center">
                <div class="text-center col-lg-4 col-md-6 col-sm-12 col-12 p-3">
                    <div class="card" style="height: 10rem;">
                        <div class="card-body mt-4">
                            <h5 class="card-title">Bookings</h5>
                            <p class="card-text mt-2">
                                <?php
                                echo $bookings;
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="text-center col-lg-4 col-md-6 col-sm-12 col-12 p-3">
                    <div class="card" style="height: 10rem;">
                        <div class="card-body mt-4">
                            <h5 class="card-title">Hotels</h5>
                            <p class="card-text mt-2">
                                <?php
                                echo $hotels;
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="text-center col-lg-4 col-md-6 col-sm-12 col-12 p-3">
                    <div class="card" style="height: 10rem;">
                        <div class="card-body mt-4">
                            <h5 class="card-title">Users</h5>
                            <p class="card-text mt-2">
                                <?php
                                echo $users;
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="text-center col-lg-4 col-md-6 col-sm-12 col-12 p-3">
                    <div class="card" style="height: 10rem;">
                        <div class="card-body mt-4">
                            <h5 class="card-title">Total Sales</h5>
                            <p class="card-text mt-2">
                            ₹ <?php echo $sales; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>