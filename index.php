<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myriad</title>
    <?php include 'includes/style_include.html' ?>
</head>

<body>
    <?php include 'includes/navbar.html' ?>

    <div class="hero">
        <div class="d-flex container justify-content-center align-items-center">
            <div class="center-vert m-5 p-5 text-center hero-body-tertiary rounded-3">
                <img src="/assets/img/hotel.gif" alt="" height="200">
                <h1 class="text-body-emphasis">Jumbotron with icon</h1>
                <p class="col-lg-8 mx-auto fs-5 text-muted">
                    This is a custom jumbotron featuring an SVG image at the top, some longer text that wraps early thanks to a responsive <code>.col-*</code> class, and a customized call to action.
                </p>
            </div>
        </div>
    </div>

    <div id="features">
        <div class="container px-4 py-5">
            <h2 class="pb-2 border-bottom">Features with title</h2>

            <div class="row row-cols-1 row-cols-md-2 align-items-md-center g-5 py-5">
                <div class="col d-flex flex-column align-items-start gap-2">
                    <h2 class="fw-bold text-body-emphasis">Left-aligned title explaining these awesome features</h2>
                    <p class="text-body-secondary">Paragraph of text beneath the heading to explain the heading. We'll add onto it with another sentence and probably just keep going until we run out of words.</p>
                </div>

                <div class="col">
                    <div class="row row-cols-1 row-cols-sm-2 g-4">
                        <div class="col d-flex flex-column gap-2">
                            <div class="feature-icon-small d-inline-flex align-items-center justify-content-center bg-gradient fs-4 rounded-3" style="width: 18%">
                                <i class="bi bi-collection"></i>

                            </div>
                            <h4 class="fw-semibold mb-0 text-body-emphasis">Featured title</h4>
                            <p class="text-body-secondary">Paragraph of text beneath the heading to explain the heading.</p>
                        </div>
                        <div class="col d-flex flex-column gap-2">
                            <div class="feature-icon-small d-inline-flex align-items-center justify-content-center bg-gradient fs-4 rounded-3" style="width: 18%">
                                <i class="bi bi-collection"></i>

                            </div>
                            <h4 class="fw-semibold mb-0 text-body-emphasis">Featured title</h4>
                            <p class="text-body-secondary">Paragraph of text beneath the heading to explain the heading.</p>
                        </div>
                        <div class="col d-flex flex-column gap-2">
                            <div class="feature-icon-small d-inline-flex align-items-center justify-content-center bg-gradient fs-4 rounded-3" style="width: 18%">
                                <i class="bi bi-collection"></i>

                            </div>
                            <h4 class="fw-semibold mb-0 text-body-emphasis">Featured title</h4>
                            <p class="text-body-secondary">Paragraph of text beneath the heading to explain the heading.</p>
                        </div>
                        <div class="col d-flex flex-column gap-2">
                            <div class="feature-icon-small d-inline-flex align-items-center justify-content-center bg-gradient fs-4 rounded-3" style="width: 18%">
                                <i class="bi bi-collection"></i>

                            </div>
                            <h4 class="fw-semibold mb-0 text-body-emphasis">Featured title</h4>
                            <p class="text-body-secondary">Paragraph of text beneath the heading to explain the heading.</p>
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