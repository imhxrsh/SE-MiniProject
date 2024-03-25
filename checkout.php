<?php
session_start();

include 'config.php';

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myriad - Checkout</title>
    <?php include 'includes/style_include.html' ?>
</head>

<body>
    <?php include 'includes/navbar.php' ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12 mt-2">
                <label for="duration" class="form-label">Duration:</label>
                <input type="text" class="form-control" id="duration" name="duration" value="<?php echo $_SESSION['duration']; ?>" required readonly>
            </div>
            <div class="col-lg-6 col-12 mt-2">
                <label for="total_price" class="form-label">Total Price:</label>
                <div class="input-group">
                    <span class="input-group-text">₹</span>
                    <input type="text" class="form-control" readonly id="total_price" name="total_price" value="<?php echo $_SESSION['total_price']; ?>" required>
                </div>
            </div>
            <div class="col-lg-6 col-12 mt-2">
                <label for="checkin_date" class="form-label">Check In Date</label>
                <input type="date" min="1970-01-01" max="2025-12-31" class="form-control text-center" name="checkin_date" id="checkin_date" value="<?php echo $_SESSION['checkin_date']; ?>" required readonly>
            </div>
            <div class="col-lg-6 col-12 mt-2">
                <label for="checkin_time" class="form-label">Check In Time:</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control text-center" readonly id="checkin_hours" name="checkin_hours" required value="<?php echo $_SESSION['checkin_hours']; ?>" placeholder="Hours">
                    <input type="text" class="form-control text-center" readonly id="checkin_minutes" name="checkin_minutes" required value="<?php echo $_SESSION['checkin_minutes']; ?>" placeholder="Minutes">
                    <input type="text" class="form-control text-center" readonly id="checkin_meridiem" name="checkin_meridiem" required value="<?php echo $_SESSION['checkin_meridiem']; ?>" placeholder="Meridiem">
                </div>
            </div>
            <div class="col-lg-6 col-12 mt-2">
                <label for="checkout_date" class="form-label">Check Out Date</label>
                <input type="date" min="1970-01-01" max="2025-12-31" class="form-control text-center" name="checkout_date" id="checkout_date" readonly value="<?php echo $_SESSION['checkout_date']; ?>" required>
            </div>
            <div class="col-lg-6 col-12 mt-2">
                <label for="checkin_time" class="form-label">Check Out Time:</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control text-center" readonly id="checkout_hours" name="checkout_hours" required value="<?php echo $_SESSION['checkout_hours']; ?>" placeholder="Hours">
                    <input type="text" class="form-control text-center" readonly id="checkout_minutes" name="checkout_minutes" required value="<?php echo $_SESSION['checkout_minutes']; ?>" placeholder="Minutes">
                    <input type="text" class="form-control text-center" readonly id="checkout_meridiem" name="checkout_meridiem" required value="<?php echo $_SESSION['checkout_meridiem']; ?>" placeholder="Meridiem">
                </div>
            </div>
            <h3 class="mt-5">Customer Details</h3>
            <div class="col-lg-6 col-12 mt-2">
                <label for="fname" class="form-label">First Name:</label>
                <input type="text" class="form-control" id="fname" name="first_name" value="<?php echo $_SESSION['first_name'] ?>" required readonly>
            </div>
            <div class="col-lg-6 col-12 mt-2">
                <label for="lname" class="form-label">Last Name:</label>
                <input type="text" class="form-control" id="lname" name="last_name" value="<?php echo $_SESSION['last_name'] ?>" required readonly>
            </div>
            <div class="col-lg-6 col-12 mt-2">
                <label for="dob" class="form-label">Date of Birth:</label>
                <input type="date" min="1970-01-01" max="2025-12-31" class="form-control text-center" name="dob" required value="<?php echo $_SESSION['dob']; ?>" readonly>
            </div>
            <div class="col-lg-6 col-12 mt-2">
                <label for="form-gender" class="form-label">Gender:</label>
                <input type="text" class="form-control" readonly id="gender" name="gender" required value="<?php echo $_SESSION['gender']; ?>" readonly>
            </div>
            <div class="col-lg-6 col-12 mt-2">
                <label for="phone" class="form-label">Phone:</label>
                <input type="number" class="form-control" id="phone" name="phone" required minlength="10" value="<?php echo $_SESSION['phone'] ?>" pattern="[1-9]{1}[0-9]{9}" readonly>
            </div>
            <div class="col-lg-6 col-12 mt-2">
                <label for="email" class="form-label">E-Mail:</label>
                <input type="email" class="form-control" id="email" value="<?php echo $_SESSION['email'] ?>" name="email" required readonly>
            </div>
        </div>
        <center><button id="pay-btn" class="mt-4 px-5 py-2 btn btn-outline-success"><span style="font-size: 1.3rem;">Pay</span></button></center>
    </div>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "<?php echo $keyId; ?>",
            "amount": "<?php echo $_SESSION['total_price'] * 100; ?>",
            "currency": "INR",
            "name": "Myriad - Hotel Services",
            "description": "Hotel booking for <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?>",
            "image": "https://myriad.hxrsh.tech/assets/img/logo.jpg",
            "order_id": "<?php echo $_SESSION['order_id']; ?>",
            "handler": function(response) {
                $.ajax({
                    type: 'POST',
                    url: 'processing',
                    data: {
                        razorpay_payment_id: response.razorpay_payment_id,
                        razorpay_order_id: response.razorpay_order_id,
                        razorpay_signature: response.razorpay_signature
                    },
                    success: function(data) {
                        console.log('Session variables set successfully.');
                        if (data.trim() === "success") {
                            window.location.href = "/success";
                        } else {
                            window.location.href = "/failed";
                        }
                    }
                });
            },
            "prefill": {
                "name": "<?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?>",
                "email": "<?php echo $_SESSION['email']; ?>",
                "contact": "<?php echo $_SESSION['phone']; ?>"
            },
            "theme": {
                "color": "#3399cc"
            }
        };
        var rzp = new Razorpay(options);
        rzp.on('payment.failed', function(response) {
            alert("Payment failed!");
            $.ajax({
                type: 'POST',
                url: 'failed',
                data: {
                    error_code: response.error.code,
                    error_description: response.error.description,
                    error_source: response.error.source,
                    error_step: response.error.step,
                    error_reason: response.error.reason,
                    error_metadata_order_id: response.error.metadata.order_id,
                    error_metadata_payment_id: response.error.metadata.payment_id
                },
                success: function(data) {
                    console.log('Failure Recorded Successfully.');;
                }
            });
        });
        document.getElementById('pay-btn').onclick = function(e) {
            rzp.open();
            e.preventDefault();
        }
    </script>

    <?php include 'includes/footer.html' ?>
    <?php include 'includes/js_include.html' ?>
</body>

</html>