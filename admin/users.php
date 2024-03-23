<?php
session_start();

if (isset($_SESSION["role"]) && $_SESSION["role"] != "admin") {
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
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myriad - Users</title>
    <?php include '../includes/style_include.html' ?>
</head>

<body>
    <?php include 'includes/navbar.php' ?>

</body>

</html>