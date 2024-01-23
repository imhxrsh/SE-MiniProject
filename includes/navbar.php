<?php
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $first_name = $_SESSION["first_name"];
    $last_name = $_SESSION["last_name"];
}
?>

<div class="container">
    <nav class="navbar navbar-expand-lg bg-body-tertiary rounded m-3">
        <div class="container-fluid">
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
                aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse d-lg-flex collapse" id="navbar">
                <a class="navbar-brand col-lg-3 me-0 d-flex justify-content-center" href="/">Myriad</a>
                <ul class="d-flex justify-content-center align-items-center navbar-nav col-lg-6 justify-content-center">
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
                <div class="d-flex justify-content-center col-lg-3 justify-content-lg-end">
                    <?php
                    if (isset($_SESSION["user_id"])) {
                        echo "<p class='d-flex align-items-center welcome-center'>Hi, " . $first_name . ' ' . $last_name . '</p>';
                        echo '<a href="/logout"><button class="mx-2 btn btn-secondary">Logout</button></a>';
                    } else {
                        echo '<a href="/register"><button class="mx-2 btn btn-secondary">Register</button></a>';
                        echo '<a href="/login"><button class="mx-2 btn btn-secondary">Login</button></a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>
</div>
