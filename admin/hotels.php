<?php
include('../conn.php');
session_start();

if (isset($_SESSION["role"]) && $_SESSION["role"] != "Admin") {
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
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];

    switch ($action) {
        case 'list':
            mysqli_query($conn, "UPDATE `hotels` SET `status` = TRUE WHERE `id` = '$id'") or die('Query failed');
            break;

        case 'delist':
            mysqli_query($conn, "UPDATE `hotels` SET `status` = FALSE WHERE `id` = '$id'") or die('Query failed');
            break;

        default:
            echo "Invalid action.";
            break;
    }
}


?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myriad - Hotels</title>
    <?php include '../includes/style_include.html' ?>
</head>

<body>
    <?php include 'includes/navbar.php' ?>
    <div class="container">
        <div class="row justify-content-center my-5">
            <h5 class="d-flex justify-content-center align-items-center col-lg-7 text-center" style="margin: 0;">Hotels</h5>
            <input type="text" class="col form-control pe-lg-5 mx-lg-0 mx-5 me-lg-5" id="searchInput" placeholder="Search" aria-label="Search" aria-describedby="search">
        </div>
        <div class="d-flex container flex-column justify-content-center align-items-center">
            <?php
            $select_hotels = mysqli_query($conn, "SELECT * FROM `hotels` ORDER BY `rating` DESC") or die('query failed');
            if (mysqli_num_rows($select_hotels) > 0) {
                while ($fetch_hotels = mysqli_fetch_assoc($select_hotels)) {

            ?>
                    <div class="row listing m-4">
                        <div class="col-lg-5 col-12" style="padding: 0;">
                            <div id="carousel<?php echo $fetch_hotels['id'];?>" class="carousel slide" data-bs-ride="carouse<?php echo $fetch_hotels['id'];?>">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carousel<?php echo $fetch_hotels['id'];?>" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carousel<?php echo $fetch_hotels['id'];?>" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#carousel<?php echo $fetch_hotels['id'];?>" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                    
                                </div>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="<?php echo $fetch_hotels['image1'];?>" style="height: 35vh;" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="<?php echo $fetch_hotels['image2'];?>" style="height: 35vh;" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="<?php echo $fetch_hotels['image3'];?>" style="height: 35vh;" class="d-block w-100" alt="...">
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
                        <div class="col px-lg-5">
                            <div class="row details my-lg-5 listing-text">
                                <p class="title"><?php echo $fetch_hotels['name'];?></h1>
                                <div class="col">
                                    <p class="inner-text">Location: <?php echo $fetch_hotels['location'];?></p>
                                    <p class="inner-text">Price: <?php echo round(((75+$fetch_hotels['original_price']+$fetch_hotels['taxes'])/15),2);?><span class="text-muted" style="font-size: 15px;">/hour</span></p>
                                    <p class="inner-text">Rating: <?php echo $fetch_hotels['rating'];?></p>
                                    <p class="inner-text">Listed: <?php if ($fetch_hotels['status'] == TRUE) {
                                                                        echo 'Yes';
                                                                    } else {
                                                                        echo '<span style="color: red">No</span>';
                                                                    } ?></p>
                                </div>
                                <div class="col d-flex flex-column justify-content-center align-items-center">
                                    <a href="/admin/hotels?action=list&id=<?php echo $fetch_hotels['id'];?>"><button type="button" class="btn bg-gradient btn-success my-2">List</button></a>
                                    <a href="/admin/hotels?action=delist&id=<?php echo $fetch_hotels['id'];?>"><button type="button" class="btn bg-gradient btn-danger my-2">Delist</button></a>
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