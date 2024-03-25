<?php

include('../conn.php');

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

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];

    switch ($action) {
        case 'approve':
            mysqli_query($conn, "UPDATE `bookings` SET `status` = TRUE WHERE `id` = '$id'") or die('Query failed');
            break;

        case 'refuse':
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
    <title>Myriad - Bookings</title>
    <?php include '../includes/style_include.html' ?>
</head>

<body>
    <?php include 'includes/navbar.php' ?>

    <div class="container">
        <div class="row justify-content-center my-5">
            <h5 class="d-flex justify-content-center align-items-center col-lg-7 text-center" style="margin: 0;">Bookings</h5>
            <input type="text" class="col form-control pe-lg-5 mx-lg-0 mx-5 me-lg-5" id="searchInput" placeholder="Search" aria-label="Search" aria-describedby="search">
        </div>
        <div class="d-flex container flex-column justify-content-center align-items-center">
            <?php
            $select_bookings = mysqli_query($conn, "SELECT * FROM `bookings` ORDER BY `id` DESC") or die('query failed');
            if (mysqli_num_rows($select_bookings) > 0) {
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
                                <p class="title"><?php echo $fetch_hotels['name']; ?> <a href="<?php echo $fetch_hotels['url'] ?>" style="font-size: 1rem;">(Link)</a> </h1>
                                <div class="col-8">
                                    <p class="inner-text">Location: <?php echo $fetch_hotels['location']; ?></p>
                                    <p class="inner-text">Duration: <?php echo $fetch_bookings['duration'] . " hours"; ?></p>
                                    <p class="inner-text">Check In: <?php echo $fetch_bookings['checkin_date'] . " at " . $fetch_bookings['checkin_time']; ?></p>
                                    <p class="inner-text">Check Out: <?php echo $fetch_bookings['checkout_date'] . " at " . $fetch_bookings['checkout_time']; ?></p>
                                    <p class="inner-text">Name: <?php echo $fetch_bookings['first_name'] . " " . $fetch_bookings['last_name']; ?></p>
                                    <p class="inner-text">DOB: <?php echo $fetch_bookings['dob']; ?></p>
                                    <p class="inner-text">Phone: <?php echo $fetch_bookings['phone']; ?></p>
                                    <p class="inner-text">E-Mail: <?php echo $fetch_bookings['email']; ?></p>
                                    <div class="row">
                                        <p class="col-lg-6 col-12 inner-text">Paid: <?php if ($fetch_bookings['payment_status'] == TRUE) {
                                                                            echo "Yes";
                                                                        } else {
                                                                            echo "No";
                                                                        } ?></p>
                                        <p class="col-lg-6 col-12 inner-text">Payment ID: <?php echo $fetch_bookings['payment_id']; ?></p>
                                    </div>
                                    <p class="inner-text">Paid Amount: <?php echo "₹ " . $fetch_bookings['total_price'] . " /-"; ?></p>
                                    <p class="inner-text">Approved: <?php if ($fetch_bookings['status'] == TRUE) {
                                                                        echo 'Yes';
                                                                    } else {
                                                                        echo '<span style="color: red">No</span>';
                                                                    } ?></p>
                                </div>
                                <div class="col d-flex flex-column justify-content-center align-items-center">
                                    <a href="/admin/bookings?action=approve&id=<?php echo $fetch_bookings['id']; ?>"><button type="button" class="btn bg-gradient btn-success my-2">Approve</button></a>
                                    <a href="/admin/bookings?action=refuse&id=<?php echo $fetch_bookings['id']; ?>"><button type="button" class="btn bg-gradient btn-danger my-2">Refuse</button></a>
                                </div>

                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<div class="container"><div class="text-center"><h1>No Bookings yet!</h1></div></div>';
            }
            ?>
        </div>
    </div>

    <?php include('includes/js_include.html'); ?>
    <script>
        const searchInput = document.getElementById("searchInput");
        const cards = document.querySelectorAll(".row.listing.m-4");

        searchInput.addEventListener("input", () => {
            const searchTerm = searchInput.value.toLowerCase();

            cards.forEach(card => {
                const cardContent = card.textContent.toLowerCase();
                if (cardContent.includes(searchTerm)) {
                    card.style.display = "flex";
                } else {
                    card.style.display = "none";
                }
            });
        });
    </script>
</body>

</html>