<?php
session_start();
$hotelId = intval($_GET['id']);
include 'conn.php';

require 'config.php';
require 'assets/vendor/autoload.php';

use Razorpay\Api\Api;

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
    $checkin_time = $_POST['checkin_hours'] . ':' . $_POST['checkin_minutes'] . ' ' . $_POST['checkin_meridiem'];
    $checkout_time = $_POST['checkout_hours'] . ':' . $_POST['checkout_minutes'] . ' ' . $_POST['checkout_meridiem'];
    $checkin_date = $_POST['checkin_date'];
    $checkout_date = $_POST['checkout_date'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    
    $payment_api = new Api($keyId, $keySecret);

    $orderData = [
        'amount'          => ($total_price*100),
        'currency'        => 'INR'
    ];
    
    $razorpayOrder = $payment_api->order->create($orderData);

    $sql = "INSERT INTO bookings (hotel_id, duration, total_price, checkin_time, checkout_time, checkin_date, checkout_date, first_name, last_name, dob, gender, phone, email, payment_status, rzp_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $payment_status = '0';
    $razorpay_id = $razorpayOrder['id'];


    if ($stmt) {
        $stmt->bind_param('idsssssssssssis', $hotel_id, $duration, $total_price, $checkin_time, $checkout_time, $checkin_date, $checkout_date, $first_name, $last_name, $dob, $gender, $phone, $email, $payment_status, $razorpay_id);

        if ($stmt->execute()) {
            $_SESSION['duration'] = $duration;
            $_SESSION['total_price'] = $total_price;
            $_SESSION['checkin_date'] = $checkin_date;
            $_SESSION['checkin_hours'] = $_POST['checkin_hours'];
            $_SESSION['checkin_minutes'] = $_POST['checkin_minutes'];
            $_SESSION['checkin_meridiem'] = $_POST['checkin_meridiem'];
            $_SESSION['checkout_date'] = $checkout_date;
            $_SESSION['checkout_hours'] = $_POST['checkout_hours'];
            $_SESSION['checkout_minutes'] = $_POST['checkout_minutes'];
            $_SESSION['checkout_meridiem'] = $_POST['checkout_meridiem'];
            $_SESSION['gender'] = $gender;
            $_SESSION['dob'] = $dob;
            $sql = "UPDATE users SET dob = ? WHERE email = ?";
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phone;
            $_SESSION['order_id'] = $razorpay_id;
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
                    <div class="col px-lg-5 p-2">
                        <div class="row details my-lg-5 listing-text">
                            <p class="title"><?php echo $hotel['name']; ?></h1>
                            <div class="col">
                                <p class="inner-text">Location: <?php echo $hotel['location']; ?></p>
                                <p class="inner-text">Price: <?php echo $pricePerHour = round(((75 + $hotel['original_price'] + $hotel['taxes']) / 15), 2); ?><span class="text-muted" style="font-size: 15px;">/hour</span></p>
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
                        <label for="checkin_date" class="form-label">Check In Date</label>
                        <input type="date" min="<?php echo date('Y-m-d', strtotime('+1 week')); ?>" max="2025-12-31" class="form-control text-center" name="checkin_date" id="checkin_date" required>
                    </div>
                    <div class="col-lg-6 col-12 mt-2">
                        <label for="checkin_time" class="form-label">Check In Time:</label>
                        <div class="input-group mb-3">
                            <select class="form-select text-center" id="checkin_hours" name="checkin_hours">
                                <option selected disabled>Hours</option>
                                <option value="01">1</option>
                                <option value="02">2</option>
                                <option value="03">3</option>
                                <option value="04">4</option>
                                <option value="05">5</option>
                                <option value="06">6</option>
                                <option value="07">7</option>
                                <option value="08">8</option>
                                <option value="09">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <select class="form-select text-center" id="checkin_minutes" name="checkin_minutes">
                                <option selected disabled>Minutes</option>
                                <option value="00">00</option>
                                <option value="30">30</option>
                            </select>
                            <select class="form-select text-center" id="checkin_meridiem" name="checkin_meridiem">
                                <option value="AM">AM</option>
                                <option value="PM">PM</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12 mt-2">
                        <label for="checkout_date" class="form-label">Check Out Date</label>
                        <input type="date" min="<?php echo date('Y-m-d', strtotime('+1 week')); ?>" max="2025-12-31" class="form-control text-center" name="checkout_date" id="checkout_date" readonly required>
                    </div>
                    <div class="col-lg-6 col-12 mt-2">
                        <label for="checkin_time" class="form-label">Check Out Time:</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control text-center" readonly id="checkout_hours" name="checkout_hours" required placeholder="Hours">
                            <input type="text" class="form-control text-center" readonly id="checkout_minutes" name="checkout_minutes" required placeholder="Minutes">
                            <input type="text" class="form-control text-center" readonly id="checkout_meridiem" name="checkout_meridiem" required placeholder="Meridiem">
                        </div>
                    </div>
                    <h3 class="mt-5">Customer Details</h3>
                    <div class="col-lg-6 col-12 mt-2">
                        <label for="fname" class="form-label">First Name:</label>
                        <input type="text" class="form-control" id="fname" name="first_name" value="<?php echo $_SESSION['first_name'] ?>" required>
                    </div>
                    <div class="col-lg-6 col-12 mt-2">
                        <label for="lname" class="form-label">Last Name:</label>
                        <input type="text" class="form-control" id="lname" name="last_name" value="<?php echo $_SESSION['last_name'] ?>" required>
                    </div>
                    <div class="col-lg-6 col-12 mt-2">
                        <label for="dob" class="form-label">Date of Birth:</label>
                        <input type="date" min="1970-01-01" max="<?php echo (date('Y-m-d', strtotime('-18 years'))); ?>" class="form-control text-center" name="dob" required>
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
                        <input type="number" class="form-control" id="phone" name="phone" required minlength="10" value="<?php echo $_SESSION['phone'] ?>" pattern="[0-9]{10,}" title="Please enter a valid 10-digit phone number">
                    </div>
                    <div class="col-lg-6 col-12 mt-2">
                        <label for="email" class="form-label">E-Mail:</label>
                        <input type="email" class="form-control" id="email" value="<?php echo $_SESSION['email'] ?>" name="email" required>
                    </div>
                </div>
                <div class="py-3">
                    <input class="form-check-input" id="checkbox" type="checkbox" value="" required> I confirm that the information given in this from is true, complete and accurate
                </div>
                <center><button type="submit" class="btn btn-outline-light">Proceed to Checkout</button></center>
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
        const checkinDateInput = document.getElementById("checkin_date");
        const checkinHoursSelect = document.getElementById("checkin_hours");
        const checkinMinutesSelect = document.getElementById("checkin_minutes");
        const checkinMeridiemSelect = document.getElementById("checkin_meridiem");
        const checkoutDateInput = document.getElementById("checkout_date");
        const checkoutHoursInput = document.getElementById("checkout_hours");
        const checkoutMinutesInput = document.getElementById("checkout_minutes");
        const checkoutMeridiemInput = document.getElementById("checkout_meridiem");

        durationInput.addEventListener("input", updateTotalPriceAndCheckoutDate);
        checkinDateInput.addEventListener("input", updateTotalPriceAndCheckoutDate);
        checkinHoursSelect.addEventListener("change", updateCheckoutTime);
        checkinMinutesSelect.addEventListener("change", updateCheckoutTime);
        checkinMeridiemSelect.addEventListener("change", updateCheckoutTime);

        function updateTotalPriceAndCheckoutDate() {
            updateTotalPrice();

            const durationValue = parseFloat(durationInput.value);
            const checkinDate = new Date(checkinDateInput.value);

            if (!isNaN(durationValue) && !isNaN(checkinDate.getTime())) {
                const checkoutDate = new Date(checkinDate.getTime() + durationValue * 3600 * 1000);
                const checkoutDateString = checkoutDate.toISOString().split('T')[0];
                checkoutDateInput.value = checkoutDateString;
            } else {
                checkoutDateInput.value = '';
                checkoutHoursInput.value = '';
                checkoutMinutesInput.value = '';
                checkoutMeridiemInput.value = '';
            }
        }

        function updateTotalPrice() {
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

        function updateCheckoutTime() {
            const durationValue = parseFloat(durationInput.value);

            const checkinHours = parseInt(checkinHoursSelect.value);
            const checkinMinutes = parseInt(checkinMinutesSelect.value);
            const checkinMeridiem = checkinMeridiemSelect.value;

            if (isNaN(durationValue) || isNaN(checkinHours) || isNaN(checkinMinutes)) {
                return;
            }

            let totalHours = checkinHours;
            let totalMinutes = checkinMinutes;
            let totalMeridiem = checkinMeridiem;

            totalHours += Math.floor(durationValue);
            totalMinutes += Math.round((durationValue % 1) * 60);

            if (totalMinutes >= 60) {
                totalHours += Math.floor(totalMinutes / 60);
                totalMinutes %= 60;
            }

            if (totalHours >= 12) {
                if (totalHours > 12) {
                    totalHours %= 12;
                }
                totalMeridiem = totalMeridiem === "AM" ? "PM" : "AM";
            }

            checkoutHoursInput.value = totalHours.toString().padStart(2, '0');
            checkoutMinutesInput.value = totalMinutes.toString().padStart(2, '0');
            checkoutMeridiemInput.value = totalMeridiem;
        }
    </script>

</body>

</html>