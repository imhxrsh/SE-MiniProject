<?php
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

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
    } else if ($captcha_success->success == true) {
        $sql = "INSERT INTO users (first_name, last_name,  phone, email, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $first_name, $last_name,  $phone, $email, $hashedPassword);

        if ($stmt->execute()) {
            header("Location: /login");
            exit;
        } else {
            $error_message = "Registration failed. Please try again.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myriad - Register</title>
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

    <div class="register d-flex container justify-content-center align-items-center">
        <div class="d-flex row col-lg-8 col-12 justify-content-center align-items-center">
            <h1 class="text-center">Register</h1>
            <div class="col-lg-5 col-12">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name<span style="color: red;">*</span></label>
                        <input type="text" class="col mb-2 form-control" name="first_name" id="first_name" aria-describedby="first_name" placeholder="First Name" required>
                        <input type="text" class="col mb-2 form-control" name="last_name" id="last_name" aria-describedby="last_name" placeholder="Last Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Phone<span style="color: red;">*</span></label><br>
                        <input type="text" class="form-control" name="phone" id="phone" aria-describedby="phone" required pattern="[0-9]{10,}" title="Please enter a valid 10-digit phone number">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address<span style="color: red;">*</span></label>
                        <input type="email" class="form-control" name="email" id="email" aria-describedby="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password<span style="color: red;">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="password" required>
                            <button class="btn btn-outline-secondary" type="button" id="password-toggle">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                    <p>A User already? <a href="/login">Login!</a></p>
                    <br>
                    <?php if (isset($error_message)) { ?>
                        <div class="alert alert-danger" role="alert"><?php echo $error_message; ?></div>
                    <?php } ?>
                    <center><button type="submit" class="btn btn-outline-light">Submit</button></center>
                </form>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.html' ?>
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