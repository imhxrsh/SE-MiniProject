<?php

session_start();

if (isset($_SESSION["user_id"])) {
    $isLoggedIn = true;
} else {
    $isLoggedIn = false;
}

include 'conn.php';

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myriad - Failed</title>
    <?php include 'includes/style_include.html' ?>
</head>

<body>
    <?php include 'includes/navbar.php' ?>
    <style>
        .card {
            box-shadow: 0 15px 16.8px rgba(0, 0, 0, 0.031), 0 100px 134px rgba(0, 0, 0, 0.05);
            background-color: white;
            border-radius: 15px;
            padding: 35px;
        }

        .top {
            padding-bottom: 25px;
            min-width: 250px;
            text-align: center;
            border-bottom: dashed #dfe4f3 2px;
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
            border-left: 0.18em dashed #fff;
            position: relative;
        }

        .top:before {
            background-color: #fafcff;
            position: absolute;
            content: "";
            display: block;
            width: 20px;
            height: 20px;
            border-radius: 100%;
            bottom: 0;
            right: -10px;
            margin-bottom: -10px;
        }

        .svg,
        .h3 {
            color: #e5383b;
        }

        .svg {
            margin: 0 auto;
            width: 60px;
            height: 60px;
        }

        .h3 {
            margin-top: 0px;
            margin-bottom: 10px;
        }

        .span {
            color: #000;
            font-size: 16px;
        }

        .bottom {
            text-align: center;
            margin-top: 30px;
        }

        .key-value {
            display: flex;
            justify-content: center;
        }

        .key-value span:first-child {
            font-weight: 0;
        }

        .a {
            padding: 8px 20px;
            background-color: #e5383b;
            text-decoration: none;
            color: white;
            border-radius: 8px;
            font-size: 14px;
            margin-top: 20px;
            display: block;
        }

        .inner-container {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }

        .centered-content {
            display: inline-block;
            text-align: left;
            background: #fff;
            margin-top: 10px;
        }
    </style>
    <div class="confirm-container p-2">
        <div class="outer-container">
            <div class="inner-container">
                <div class="card centered-content">
                    <div class="top">

                        <svg class="svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <h3 class="h3">
                            Payment Failed!
                        </h3>
                    </div>
                    <div class="bottom">
                        <div class="key-value">
                            <span class="span">Contact Support with your details and payment screenshot!</span>
                        </div>
                        <a class="a" href="https://wa.me/919930546775">Support</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php include 'includes/footer.html' ?>
    <?php include 'includes/js_include.html' ?>
</body>

</html>