<?php
session_start();

include('../conn.php');

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
        case 'promote':
            mysqli_query($conn, "UPDATE `users` SET `role` = 'Admin' WHERE `id` = '$id'") or die('Query failed');
            break;

        case 'demote':
            mysqli_query($conn, "UPDATE `users` SET `role` = 'User' WHERE `id` = '$id'") or die('Query failed');
            break;

        case 'activate':
            mysqli_query($conn, "UPDATE `users` SET `status` = TRUE WHERE `id` = '$id'") or die('Query failed');
            break;
        
        case 'deactivate':
            mysqli_query($conn, "UPDATE `users` SET `status` = FALSE WHERE `id` = '$id'") or die('Query failed');
            break;

        default:
            echo "Invalid action.";
            break;
    }
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
    <div class="container">
        <div class="row justify-content-center my-5">
            <h5 class="d-flex justify-content-center align-items-center col-lg-7 text-center" style="margin: 0;">Users</h5>
            <input type="text" class="col form-control pe-lg-5 mx-lg-0 mx-5 me-lg-5" id="searchInput" placeholder="Search" aria-label="Search" aria-describedby="search">
        </div>
        <div class="d-flex container flex-column justify-content-center align-items-center">
            <?php
            $select_users = mysqli_query($conn, "SELECT * FROM `users` ORDER BY `id` DESC") or die('query failed');
            if (mysqli_num_rows($select_users) > 0) {
                while ($fetch_users = mysqli_fetch_assoc($select_users)) {

            ?>
                    <div class="row listing m-4">
                        <div class="col px-lg-5">
                            <div class="row details my-5 mx-4 listing-text">
                                <div class="col-8">
                                    <p class="inner-text">ID: <?php echo $fetch_users['id']; ?></p>
                                    <p class="inner-text">Name: <?php echo $fetch_users['first_name'] . " " . $fetch_users['last_name']; ?></p>
                                    <p class="inner-text">Phone: <?php echo $fetch_users['phone']; ?></p>
                                    <p class="inner-text">Email: <?php echo $fetch_users['email']; ?></p>
                                    <p class="inner-text">Role: <?php echo $fetch_users['role']; ?></p>
                                    <p class="inner-text">Status: <?php echo $fetch_users['status'] ? "Active" : "Inactive"; ?></p>
                                </div>
                                <div class="col d-flex flex-column justify-content-center align-items-center">
                                    <a href="/admin/users?action=promote&id=<?php echo $fetch_users['id']; ?>"><button type="button" class="btn bg-gradient btn-success my-2">Make Admin</button></a>
                                    <a href="/admin/users?action=demote&id=<?php echo $fetch_users['id']; ?>"><button type="button" class="btn bg-gradient btn-success my-2">Make User</button></a>
                                    <a href="/admin/users?action=activate&id=<?php echo $fetch_users['id']; ?>"><button type="button" class="btn bg-gradient btn-success my-2">Activate</button></a>
                                    <a href="/admin/users?action=deactivate&id=<?php echo $fetch_users['id']; ?>"><button type="button" class="btn bg-gradient btn-danger my-2">Deactivate</button></a>
                                </div>

                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<div class="container"><div class="text-center"><h1>No users registered yet!</h1></div></div>';
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