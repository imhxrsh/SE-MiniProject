<?php
include 'conn.php';

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myriad - Listings</title>
    <?php include 'includes/style_include.html' ?>
</head>

<body>
    <?php include 'includes/navbar.html' ?>

    <div class="container">
        <div class="row justify-content-between my-5">
            <h5 class="col-8 text-center">Hotel Listings</h5>
            <input type="text" class="col form-control me-2" id="search" placeholder="Search" aria-label="Search" aria-describedby="search">
        </div>
        <div class="d-flex container">
            <div class="row listing">
                <div class="col-4" style="padding: 0;">
                    <div id="carousel1" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carousel1" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carousel1" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://aminandwilsonrealty.com/landing/assets/img/maimoon/2.jpg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="https://aminandwilsonrealty.com/landing/assets/img/maimoon/2.jpg" class="d-block w-100" alt="...">
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel1" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel1" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col px-5 py-5 py-lg-0 property-box-text">
                    <div class="row details my-5">
                        <h1>Name</h1>
                        <div class="col">
                            <h5>Location: </h5>
                            <h5>Landmark: </h5>
                        </div>
                        <div class="col">
                            <h5>Price: </h5>
                            <h5>Rating: </h5>
                        </div>
                        <div class="col-3 justify-content-center">
                            <button type="button" class="btn bg-gradient btn-secondary">Book Now</button>
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