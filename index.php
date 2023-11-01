<?php
session_start();

if (isset($_SESSION["user_id"])) {
    $isLoggedIn = true;
} else {
    $isLoggedIn = false;
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myriad</title>
    <?php include 'includes/style_include.html' ?>
</head>

<body>
    <?php include 'includes/navbar.php' ?>

    <div class="hero">
        <div class="d-flex container justify-content-center align-items-center">
            <div class="center-vert m-5 p-5 text-center hero-body-tertiary rounded-3">
                <img src="/assets/img/hotel.gif" alt="" height="200">
                <h1 class="text-body-emphasis">Myriad</h1>
                <p class="col-lg-8 mx-auto fs-5 text-muted">
                    Stay Your Way Anytime, Anywhere.
                </p>
            </div>
        </div>
    </div>

    <div id="features">
        <div class="container px-4 py-5">
            <h2 class="pb-2 border-bottom">Our Features</h2>

            <div class="row row-cols-1 row-cols-md-2 align-items-md-center g-5 py-5">
                <div class="col d-flex flex-column align-items-start gap-2">
                    <h2 class="fw-bold text-body-emphasis">Convenience & Flexibility</h2>
                    <p class="text-body-secondary">With Myriad, you're in charge of your travel schedule. Book a room for as little as one hour or as long as you need, giving you the freedom to tailor your stay to your exact needs. No more rigid check-in and check-out times.
                        Hourly stays can be significantly more budget-friendly than booking a full day or night at a hotel.
                        Myriad offers a hassle-free booking process, accessible from the comfort of your device. It's perfect for layovers, business travelers, or those looking for a quiet spot in the city. </p>
                </div>

                <div class="col">
                    <div class="row row-cols-1 row-cols-sm-2 g-4">
                        <div class="col d-flex flex-column gap-2">
                            <div class="feature-icon-small d-inline-flex align-items-center justify-content-center bg-gradient fs-4 rounded-3" style="width: 18%">
                                <i class="bi bi-clock"></i>

                            </div>
                            <h4 class="fw-semibold mb-0 text-body-emphasis">Hourly Rooms</h4>
                            <p class="text-body-secondary">Book according to your time convenience</p>
                        </div>
                        <div class="col d-flex flex-column gap-2">
                            <div class="feature-icon-small d-inline-flex align-items-center justify-content-center bg-gradient fs-4 rounded-3" style="width: 18%">
                                <i class="bi bi-luggage"></i>

                            </div>
                            <h4 class="fw-semibold mb-0 text-body-emphasis">Airport Shuttle</h4>
                            <p class="text-body-secondary">Airport pick up and drop available along with taxi services for longer hours.</p>
                        </div>
                        <div class="col d-flex flex-column gap-2">
                            <div class="feature-icon-small d-inline-flex align-items-center justify-content-center bg-gradient fs-4 rounded-3" style="width: 18%">
                                <i class="bi bi-person-raised-hand"></i>

                            </div>
                            <h4 class="fw-semibold mb-0 text-body-emphasis">Hygeine</h4>
                            <p class="text-body-secondary">Get the cleanest rooms at your fingertips.</p>
                        </div>
                        <div class="col d-flex flex-column gap-2">
                            <div class="feature-icon-small d-inline-flex align-items-center justify-content-center bg-gradient fs-4 rounded-3" style="width: 18%">
                                <i class="bi bi-cash-stack"></i>

                            </div>
                            <h4 class="fw-semibold mb-0 text-body-emphasis">Budget Friendly</h4>
                            <p class="text-body-secondary">Pay only for the hours you stay </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include 'includes/footer.html' ?>

    <?php include 'includes/js_include.html' ?>
</body>

</html>