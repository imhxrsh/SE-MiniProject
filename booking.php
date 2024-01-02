<?php
session_start();
$hotelId = intval($_GET['id']);
include 'conn.php';
if (isset($_SESSION["user_id"])) {
    $isLoggedIn = true;
} else {
    $isLoggedIn = false;
}

if (!$isLoggedIn) {
    header("Location: login?error=notLoggedIn");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hotel_id = $hotelId;
    $duration = $_POST['duration'];
    $total_price = $_POST['total_price'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $payment_status = 1;

    $sql = "INSERT INTO bookings (hotel_id, duration, total_price, first_name, last_name, dob, gender, phone, email, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('idsssssssi', $hotel_id, $duration, $total_price, $first_name, $last_name, $dob, $gender, $phone, $email, $payment_status);

        if ($stmt->execute()) {
            header('Location: /checkout');
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
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
    <div class="d-flex container flex-column justify-content-center align-items-center">
        <?php
        if (isset($_GET['id'])) {
            $sql = "SELECT * FROM hotels WHERE id = $hotelId";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $hotel = $result->fetch_assoc();
        ?>
                <div class="row listing m-4">
                    <div class="col-lg-4 col-12" style="padding: 0;">
                        <div id="carousel<?php echo $hotel['id']; ?>" class="carousel slide" data-bs-ride="carouse<?php echo $hotel['id']; ?>">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carousel<?php echo $hotel['id']; ?>" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carousel<?php echo $hotel['id']; ?>" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#carousel<?php echo $hotel['id']; ?>" data-bs-slide-to="2" aria-label="Slide 3"></button>

                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="<?php echo $hotel['image1']; ?>" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="<?php echo $hotel['image2']; ?>" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="<?php echo $hotel['image3']; ?>" class="d-block w-100" alt="...">
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?php echo $hotel['id']; ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel<?php echo $hotel['id']; ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col px-lg-5 py-lg-5 p-2">
                        <div class="row details my-lg-5 listing-text">
                            <p class="title"><?php echo $hotel['name']; ?></h1>
                            <div class="col">
                                <p class="inner-text">Location: <?php echo $hotel['location']; ?></p>
                                <p class="inner-text">Price: <?php echo $pricePerHour = round(((75 + $hotel['price'] + $hotel['taxes']) / 15), 2);; ?><span class="text-muted" style="font-size: 15px;">/hour</span></p>
                                <p class="inner-text">Rating: <?php echo $hotel['rating']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            } else {
                echo '<div class="alert alert-danger d-flex align-items-center" role="alert"><div><i class="bi bi-exclamation-triangle-fill me-2"></i>No Hotels found!</div></div>';
            }
        } else {
            echo '<div class="alert alert-danger d-flex align-items-center" role="alert"><div><i class="bi bi-exclamation-triangle-fill me-2"></i>Invalid request. Hotel ID not provided!</div></div>';
        }
        ?>
    </div>
    <?php
    if (isset($_GET['id'])) {
    ?>
        <div class="container">
            <form action="" method="POST">
                <div class="row">
                    <div class="col-lg-6 col-12 mt-2">
                        <label for="duration" class="form-label">Duration:</label>
                        <input type="text" class="form-control" id="duration" name="duration" required>
                    </div>
                    <div class="col-lg-6 col-12 mt-2">
                        <label for="total_price" class="form-label">Total Price:</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="text" class="form-control" readonly id="total_price" name="total_price" required>
                        </div>
                    </div>

                    <div class="col-lg-6 col-12 mt-2">
                        <label for="fname" class="form-label">First Name:</label>
                        <input type="text" class="form-control" id="fname" name="first_name" value="<?php echo $_SESSION['first_name']?>" required>
                    </div>
                    <div class="col-lg-6 col-12 mt-2">
                        <label for="lname" class="form-label">Last Name:</label>
                        <input type="text" class="form-control" id="lname" name="last_name" value="<?php echo $_SESSION['last_name']?>" required>
                    </div>
                    <div class="col-lg-6 col-12 mt-2">
                        <label for="dob" class="form-label">Date of Birth:</label>
                        <input type="date" min="1970-01-01" max="2025-12-31" class="form-control" name="dob" required>
                    </div>
                    <div class="col-lg-6 col-12 mt-2">
                        <label for="form-gender" class="form-label">Gender:</label>
                        <select name="gender" class="form-control" id="form-gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="col-lg-6 col-12 mt-2">
                        <label for="phone" class="form-label">Phone:</label>
                        <input type="number" class="form-control" id="phone" name="phone" required minlength="10" value="<?php echo $_SESSION['phone']?>" pattern="[1-9]{1}[0-9]{9}">
                    </div>
                    <div class="col-lg-6 col-12 mt-2">
                        <label for="email" class="form-label">E-Mail:</label>
                        <input type="email" class="form-control" id="email" value="<?php echo $_SESSION['email']?>" name="email" required>
                    </div>
                </div>
                <div class="py-3">
                    <input class="form-check-input" id="checkbox" type="checkbox" value="" required> I confirm that the information given in this from is true, complete and accurate
                </div>
                <center><button type="submit" class="btn bg-gradient btn-secondary">Proceed to Checkout</button></center>
            </form>
        </div>
    <?php
    }
    ?>
    <?php include 'includes/footer.html' ?>
    <?php include 'includes/js_include.html' ?>
    <script>
        const durationInput = document.getElementById("duration");
        const totalPriceInput = document.getElementById("total_price");

        durationInput.addEventListener("input", calculateTotalPrice);

        function calculateTotalPrice() {
            const durationValue = parseFloat(durationInput.value);

            const threshold = 1.5;

            const pricePerHour = <?php echo $pricePerHour; ?>;

            if (isNaN(durationValue)) {
                totalPriceInput.value = '';
                return;
            }

            if (durationValue >= threshold) {
                const ceiledDuration = Math.ceil(durationValue);
                const totalPrice = ceiledDuration * pricePerHour;
                durationInput.value = ceiledDuration;
                totalPriceInput.value = Math.ceil(totalPrice);
            } else {
                const flooredDuration = Math.floor(durationValue);
                const totalPrice = flooredDuration * pricePerHour;
                durationInput.value = flooredDuration;
                totalPriceInput.value = Math.ceil(totalPrice);
            }
        }
    </script>
</body>

</html>
<?php

?>