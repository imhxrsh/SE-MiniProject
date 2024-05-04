<?php
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $first_name = $_SESSION["first_name"];
    $last_name = $_SESSION["last_name"];
    include('conn.php');
    $mcoins_result = mysqli_query($conn, "SELECT `mcoins` FROM `users` WHERE `id` = '$user_id'");
    if ($mcoins_result) {
        // Fetching mcoins value
        $mcoins_row = mysqli_fetch_assoc($mcoins_result);
        $mcoins = $mcoins_row['mcoins'];
    } else {
        // Handle query error
        echo "Error: " . mysqli_error($conn);
    }
}


?>

<div class="container">
    <nav class="navbar navbar-expand-lg bg-body-tertiary rounded m-3">
        <div class="container-fluid">
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse d-lg-flex collapse" id="navbar">
                <a class="navbar-brand col-lg-3 me-0 d-flex justify-content-center" href="/"> <img src="../assets/img/fav.png" alt="Myriad" height="30" style="filter: invert(1); margin-right: 3px;"> Myriad</a>
                <ul class="d-flex justify-content-center align-items-center navbar-nav col justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/listings">Hotels</a>
                    </li>
                </ul>
                <div class="d-flex justify-content-center col-lg-4 flex-lg-row flex-column align-items-center justify-content-lg-end">
                    <?php
                    if (isset($_SESSION["user_id"])) {
                        echo "<p class='d-flex align-items-center col-lg-3 welcome-center'>Hi, " . $first_name . '</p>';
                        echo '<a href="/profile"><button class="mx-2 btn btn-outline-light">Profile</button></a>';
                        echo '<a href="/logout"><button class="mx-2 btn btn-outline-light">Logout</button></a>';
                        echo '<div class="input-group"><span class="input-group-text" id="myriad-coins"><i class="bi bi-coin"></i></span><input type="text" class="form-control" placeholder="" aria-label="myriad-coins" aria-describedby="myriad-coins" disabled value="' . $mcoins . '"></div>';
                    } else {
                        echo '<a href="/register"><button class="mx-2 btn btn-outline-light">Register</button></a>';
                        echo '<a href="/login"><button class="mx-2 btn btn-outline-light">Login</button></a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>
</div>