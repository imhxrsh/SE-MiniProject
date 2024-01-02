<?php
include 'conn.php';
$error_message = "Login failed. Please check your email and password.";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT id, email, password, phone, first_name, last_name FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id, $db_email, $db_password, $db_phone, $db_firstname, $db_lastname);
    $stmt->fetch();

    if (password_verify($password, $db_password)) {
        session_start();
        $_SESSION["user_id"] = $user_id;
        $_SESSION["email"] = $db_email;
        $_SESSION["phone"] = $db_phone;
        $_SESSION["first_name"] = $db_firstname;
        $_SESSION["last_name"] = $db_lastname;

        header("Location: /");
        exit;
    } else {
        $error_message = "Login failed. Please check your email and password.";
        header("Location: /login.php?error=loginFailed");
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myriad - Login</title>
    <?php include 'includes/style_include.html' ?>
</head>

<body>
    <?php include 'includes/navbar.php' ?>
    <?php if (isset($_GET["error"])) {
        if ($_GET["error"] == "notLoggedIn") {
            echo '<div class="container col-lg-5 col-12"><div class="alert alert-danger alert-dismissible fade show" role="alert">Please log in and then book again!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
        }
        if ($_GET["error"] == "loginFailed") {
            echo '<div class="container col-lg-5 col-12"><div class="alert alert-danger alert-dismissible fade show" role="alert">' . $error_message . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
        }

    }
    ?>
    <div class="register d-flex container justify-content-center align-items-center">
        <div class="d-flex row col-lg-8 col-12 justify-content-center align-items-center">
            <h1 class="text-center">Login</h1>
            <div class="col-lg-5 col-12">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" aria-describedby="email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <p>Not a User? <a class="link" href="/register">Register Now!</a></p>
                    <center><button type="submit" class="btn bg-gradient btn-secondary">Login</button></center>
                </form>
            </div>
        </div>

    </div>

    <?php include 'includes/footer.html' ?>

    <?php include 'includes/js_include.html' ?>
</body>

</html>