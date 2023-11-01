<?php
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, phone, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $phone, $email, $hashedPassword);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        $error_message = "Registration failed. Please try again.";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myriad - Register</title>

    <?php include 'includes/style_include.html' ?>

</head>

<body>
    <?php include 'includes/navbar.php' ?>

    <div class="register d-flex container justify-content-center align-items-center">
        <div class="d-flex row col-8 justify-content-center align-items-center">
            <h1 class="text-center">Register</h1>
            <div class="col-5">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name<span style="color: red;">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" aria-describedby="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Phone<span style="color: red;">*</span></label><br>
                        <input type="number" class="form-control" name="phone" id="phone" aria-describedby="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address<span style="color: red;">*</span></label>
                        <input type="email" class="form-control" name="email" id="email" aria-describedby="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password<span style="color: red;">*</span></label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <p>A User already? <a href="/login">Login!</a></p>
                    <center><button type="submit" class="btn bg-gradient btn-secondary">Submit</button></center>
                </form>
            </div>
        </div>

    </div>

    <?php include 'includes/footer.html' ?>

    <?php include 'includes/js_include.html' ?>
</body>

</html>