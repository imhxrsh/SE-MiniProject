<?php
session_start();

include('conn.php');

if (isset($_SESSION["user_id"])) {
    $isLoggedIn = true;
} else {
    $isLoggedIn = false;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];

    switch ($action) {
        case 'cancel':
            // Retrieve booking details to get the paid amount
            $booking_query = mysqli_query($conn, "SELECT * FROM `bookings` WHERE `id` = '$id'");
            $booking_data = mysqli_fetch_assoc($booking_query);
            $paid_amount = $booking_data['total_price'];

            // Retrieve user's current coins
            $user_id = $_SESSION['user_id'];
            $prev_mcoins_query = mysqli_query($conn, "SELECT mcoins FROM `users` WHERE `id` = '$user_id'");
            $prev_mcoins_data = mysqli_fetch_assoc($prev_mcoins_query);
            $prev_mcoins = $prev_mcoins_data['mcoins'];

            // Update user's coins by adding the paid amount
            $new_mcoins = $prev_mcoins + $paid_amount;
            $update_coins_query = mysqli_query($conn, "UPDATE `users` SET `mcoins` =  $new_mcoins WHERE `id` = '$user_id'");

            // Update booking status
            mysqli_query($conn, "UPDATE `bookings` SET `status` = FALSE WHERE `id` = '$id'") or die('Query failed');
            break;

        default:
            echo "Invalid action.";
            break;
    }
}

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myriad - Profile</title>
    <?php include 'includes/style_include.html' ?>
</head>

<body>
    <?php include 'includes/navbar.php' ?>

    <div class="d-flex flex-column justify-content-center align-items-center profile container">
        <h1>Profile</h1>
        <div class="d-flex justify-content-center align-items-center row">
            <div class="container-xl px-4 mt-4">
                <div class="row">
                    <div class="col-xl-4">
                        <!-- Profile picture card-->
                        <div class="card mb-4 mb-xl-0 h-100">
                            <div class="card-header">Profile Picture</div>
                            <div class="d-flex justify-content-center align-items-center card-body text-center">
                                <!-- Profile picture image-->
                                <img class="img-account-profile rounded-circle mb-2" src="https://avatar.iran.liara.run/username?username=<?php echo ($_SESSION['first_name'] . ' ' . $_SESSION['last_name']) ?>" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <!-- Account details card-->
                        <div class="card">
                            <div class="card-header">Account Details</div>
                            <div class="card-body">
                                <form>
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (first name)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputFirstName">First name</label>
                                            <input class="form-control" id="inputFirstName" type="text" placeholder="Enter your first name" value="<?php echo $_SESSION['first_name']; ?>">
                                        </div>
                                        <!-- Form Group (last name)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputLastName">Last name</label>
                                            <input class="form-control" id="inputLastName" type="text" placeholder="Enter your last name" value="<?php echo $_SESSION['last_name']; ?>">
                                        </div>
                                    </div>
                                    <!-- Form Group (email address)-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                        <input class="form-control" id="inputEmailAddress" type="email" placeholder="Enter your email address" value="<?php echo $_SESSION['email']; ?>">
                                    </div>
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (phone number)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputPhone">Phone number</label>
                                            <input class="form-control" id="inputPhone" type="tel" placeholder="Enter your phone number" value="<?php echo $_SESSION['phone']; ?>">
                                        </div>
                                        <!-- Form Group (birthday)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputBirthday">Birthday</label>
                                            <input class="form-control" id="inputBirthday" type="date" name="birthday" placeholder="Enter your birthday" value="<?php echo $_SESSION['dob']; ?>">
                                        </div>
                                    </div>
                                    <!-- Save changes button-->
                                    <!-- <center><button class="btn btn-outline-light" type="button">Save changes</button></center> -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column justify-content-center align-items-center profile container mt-5">
    <h1>Your Bookings</h1>
    <div class="d-flex container flex-column justify-content-center align-items-center">
        <?php
        // Check if the user is logged in
        if ($isLoggedIn) {
            $user_email = $_SESSION['email'];
            // Query to fetch bookings for the logged-in user
            $select_bookings = mysqli_query($conn, "SELECT * FROM `bookings` WHERE `email` = '$user_email' ORDER BY `id` DESC") or die('query failed');
            // Check if there are any bookings
            if (mysqli_num_rows($select_bookings) > 0) {
                // Loop through each booking
                while ($fetch_bookings = mysqli_fetch_assoc($select_bookings)) {
                    $select_hotels = mysqli_query($conn, "SELECT * FROM `hotels` WHERE `id` = " . $fetch_bookings['hotel_id'] . " ORDER BY `rating` DESC") or die('query failed');
                    $fetch_hotels = mysqli_fetch_assoc($select_hotels);
                    ?>
                    <div class="row listing m-4">
                        <div class="col-lg-5 col-12" style="padding: 0;">
                            <div id="carousel<?php echo $fetch_hotels['id']; ?>" class="carousel slide" data-bs-ride="carouse<?php echo $fetch_hotels['id']; ?>">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carousel<?php echo $fetch_hotels['id']; ?>" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carousel<?php echo $fetch_hotels['id']; ?>" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#carousel<?php echo $fetch_hotels['id']; ?>" data-bs-slide-to="2" aria-label="Slide 3"></button>

                                </div>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="<?php echo $fetch_hotels['image1']; ?>" class="d-block w-100" style="height: 65vh;" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="<?php echo $fetch_hotels['image2']; ?>" class="d-block w-100" style="height: 65vh;" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="<?php echo $fetch_hotels['image3']; ?>" class="d-block w-100" style="height: 65vh;" alt="...">
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?php echo $fetch_hotels['id']; ?>" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carousel<?php echo $fetch_hotels['id']; ?>" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <style>
                            .inner-text{
                                margin-bottom: 0.5rem;
                            }
                        </style>
                        <div class="d-flex justify-content-center align-items-center col px-lg-5">
                            <div class="row details my-3 listing-text">
                                <p class="title"><?php echo $fetch_hotels['name']; ?></h1>
                                <div class="col-8">
                                    <p class="inner-text">Location: <?php echo $fetch_hotels['location']; ?></p>
                                    <p class="inner-text">Duration: <?php echo $fetch_bookings['duration'] . " hours"; ?></p>
                                    <p class="inner-text">Check In: <?php echo $fetch_bookings['checkin_date'] . " at " . $fetch_bookings['checkin_time']; ?></p>
                                    <p class="inner-text">Check Out: <?php echo $fetch_bookings['checkout_date'] . " at " . $fetch_bookings['checkout_time']; ?></p>
                                    <p class="inner-text">Name: <?php echo $fetch_bookings['first_name'] . " " . $fetch_bookings['last_name']; ?></p>
                                    <div class="row">
                                        <p class="col-lg-6 col-12 inner-text">Paid: <?php if ($fetch_bookings['payment_status'] == TRUE) {
                                                                            echo "Yes";
                                                                        } else {
                                                                            echo "No";
                                                                        } ?></p>
                                    </div>
                                    <p class="inner-text">Paid Amount: <?php echo "₹ " . $fetch_bookings['total_price'] . " /-"; ?></p>
                                    <p class="inner-text">Approved: <?php if ($fetch_bookings['status'] == TRUE) {
                                                                        echo 'Yes';
                                                                    } else {
                                                                        echo '<span style="color: red">No</span>';
                                                                    } ?></p>
                                </div>
                                <div class="col d-flex flex-column justify-content-center align-items-center">
                                    <?php
                                    if($fetch_bookings['status'] == TRUE){
                                        echo '<a href="/profile?action=cancel&id= ' . $fetch_bookings['id'] . '"><button type="button" class="btn bg-gradient btn-danger my-2">Cancel</button></a>';
                                    }
                                    ?>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {
                // If no bookings found for the user, display a message
                echo '<div class="container"><div class="text-center"><h1>No Bookings yet!</h1></div></div>';
            }
        } else {
            // If user is not logged in, display a message to prompt login
            echo '<div class="container"><div class="text-center"><h1>Please login to view your bookings!</h1></div></div>';
        }
        ?>
    </div>
</div>


    <?php include 'includes/footer.html' ?>

    <?php include 'includes/js_include.html' ?>
</body>

</html>