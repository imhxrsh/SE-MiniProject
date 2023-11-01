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
    <title>Myriad - Listings</title>
    <?php include 'includes/style_include.html' ?>
</head>

<body>
    <?php include 'includes/navbar.php' ?>

    <div class="container">
        <div class="row justify-content-center my-5">
            <h5 class="col-lg-7 text-center">Hotel Listings</h5>
            <input type="text" class="col form-control pe-lg-5 mx-lg-0 mx-5 me-lg-5" id="searchInput" placeholder="Search" aria-label="Search" aria-describedby="search">
        </div>
        <div class="d-flex container flex-column justify-content-center align-items-center">
            <?php
            $select_hotels = mysqli_query($conn, "SELECT * FROM `hotels` ORDER BY `price` ASC") or die('query failed');
            if (mysqli_num_rows($select_hotels) > 0) {
                while ($fetch_hotels = mysqli_fetch_assoc($select_hotels)) {

            ?>
                    <div class="row listing m-4">
                        <div class="col-lg-4 col-12" style="padding: 0;">
                            <div id="carousel<?php echo $fetch_hotels['id'];?>" class="carousel slide" data-bs-ride="carouse<?php echo $fetch_hotels['id'];?>">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carousel<?php echo $fetch_hotels['id'];?>" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carousel<?php echo $fetch_hotels['id'];?>" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#carousel<?php echo $fetch_hotels['id'];?>" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                    
                                </div>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="<?php echo $fetch_hotels['image1'];?>" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="<?php echo $fetch_hotels['image2'];?>" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="<?php echo $fetch_hotels['image3'];?>" class="d-block w-100" alt="...">
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?php echo $fetch_hotels['id'];?>" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carousel<?php echo $fetch_hotels['id'];?>" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col px-lg-5 py-lg-5 p-2">
                            <div class="row details my-lg-5 listing-text">
                                <p class="title"><?php echo $fetch_hotels['name'];?></h1>
                                <div class="col">
                                    <p class="inner-text">Location: <?php echo $fetch_hotels['location'];?></p>
                                    <p class="inner-text">Price: <?php echo round(((75+$fetch_hotels['price']+$fetch_hotels['taxes'])/15),2);?><span class="text-muted" style="font-size: 15px;">/hour</span></p>
                                    <p class="inner-text">Rating: <?php echo $fetch_hotels['rating'];?></p>
                                </div>
                                <div class="col d-flex justify-content-center align-items-center">
                                    <a href="/booking?id=<?php echo $fetch_hotels['id'];?>"><button type="button" class="btn bg-gradient btn-secondary">Book Now</button></a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<div class="container"><div class="text-center"><h1>No Hotels listed yet!</h1></div></div>';
            }
            ?>
        </div>
    </div>

    <?php include 'includes/footer.html' ?>

    <?php include 'includes/js_include.html' ?>
    <script>
        const searchInput = document.getElementById("searchInput");
        const cards = document.querySelectorAll(".row.listing.m-4");

        searchInput.addEventListener("input", () => {
            const searchTerm = searchInput.value.toLowerCase();

            cards.forEach(card => {
                const cardContent = card.textContent.toLowerCase();
                if (cardContent.includes(searchTerm)) {
                    card.style.display = "flex";
                } else {
                    card.style.display = "none";
                }
            });
        });
    </script>
</body>

</html>