<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myriad - Login</title>
    <?php include 'includes/style_include.html' ?>
</head>

<body>
    <?php include 'includes/navbar.html' ?>

    <div class="register d-flex container justify-content-center align-items-center">
        <div class="d-flex row col-8 justify-content-center align-items-center">
            <h1 class="text-center">Login</h1>
            <div class="col-5">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" aria-describedby="email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password">
                    </div>
                    <p>Not a User? <a class="link" href="/register">Register Now!</a></p>
                    <center><button type="submit" class="btn bg-gradient btn-secondary">Login</button></center>
                </form>
            </div>
        </div>

    </div>

    <?php include 'includes/footer.html' ?>
    
    <?php include 'includes/js_include.html' ?>
</body>

</html>