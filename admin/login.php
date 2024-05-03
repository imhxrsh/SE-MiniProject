<?php
include '../conn.php';

$error_message = "Login failed. Please check your email and password.";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $recaptcha_response = $_POST['g-recaptcha-response'];

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => $recaptcha_secret_key,
        'response' => $recaptcha_response
    );

    $options = array(
        'http' => array(
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );

    $context = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captcha_success = json_decode($verify);

    if ($captcha_success->success == false || $captcha_success->score < 0.5) {
        $error_message = "reCAPTCHA verification failed. Please try again.";
        header("Location: /login?error=captchaFailed");
        exit;
    }

    $sql = "SELECT id, email, password, phone, first_name, last_name, role FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $db_email, $db_password, $db_phone, $db_firstname, $db_lastname, $db_role);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $db_password)) {
        session_start();
        $_SESSION["user_id"] = $user_id;
        $_SESSION["email"] = $db_email;
        $_SESSION["phone"] = $db_phone;
        $_SESSION["first_name"] = $db_firstname;
        $_SESSION["last_name"] = $db_lastname;
        $_SESSION["role"] = $db_role;

        header("Location: /admin");
        exit;
    } else {
        $error_message = "Login failed. Please check your email and password.";
        header("Location: /admin/login?error=loginFailed");
        exit;
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
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $recaptcha_site_key; ?>"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('<?php echo $recaptcha_site_key; ?>', {
                action: 'login'
            }).then(function(token) {
                document.getElementById('g-recaptcha-response').value = token;
            });
        });
    </script>
</head>

<body>
    <?php include 'includes/navbar.php' ?>
    <?php if (isset($_GET["error"])) {
        if ($_GET["error"] == "notLoggedIn") {
            echo '<div class="container col-lg-5 col-12"><div class="alert alert-danger alert-dismissible fade show" role="alert">Please log in!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
        }
        if ($_GET["error"] == "loginFailed") {
            echo '<div class="container col-lg-5 col-12"><div class="alert alert-danger alert-dismissible fade show" role="alert">' . $error_message . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
        }
        if ($_GET["error"] == "userLoggedIn") {
            echo '<div class="container col-lg-5 col-12"><div class="alert alert-danger alert-dismissible fade show" role="alert">Please log in as admin!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
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
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="password" required>
                            <button class="btn btn-outline-secondary" type="button" id="password-toggle">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                    <center><button type="submit" class="btn btn-outline-light">Login</button></center>
                </form>
            </div>
        </div>

    </div>

    <?php include 'includes/js_include.html' ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordField = document.getElementById('password');
            const passwordToggle = document.getElementById('password-toggle');

            passwordToggle.addEventListener('click', function() {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                this.querySelector('i').classList.toggle('bi-eye');
                this.querySelector('i').classList.toggle('bi-eye-slash');
            });
        });
    </script>
</body>

</html>