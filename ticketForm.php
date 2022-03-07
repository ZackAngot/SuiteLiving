<?php
session_start();
include 'src/php/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Suite Living</title>
    <!-- Bootstrap core CSS -->
    <link href="src/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="src/css/business-casual.css" rel="stylesheet">
</head>
<body>

<h1 class="site-heading text-center text-white d-none d-lg-block">
    <span class="site-heading-lower" id="suiteHead" name="home.html">Suite Living</span>
    <span class="site-heading-upper text-primary mb-3">Living Defined by You</span>
</h1>

<nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
    <div class="container">
        <a class="navbar-brand text-expanded text-white d-lg-none" href="javascript:void(0);" name="home.html" id="cellTitle">Suite Living</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mx-auto">
                <?php
                if ($_SESSION["type"] == null) {
                    include "src/html/gNav.html";
                } else {
                    switch ($_SESSION["type"]) {
                        case "R":
                            include "src/html/rNav.html";
                            break;
                        case "A":
                            include "src/html/aNav.html";
                            break;
                        case "M":
                            include "src/html/mNav.html";
                            break;
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<script>
    document.getElementById('homeBut').classList.remove('active');
    document.getElementById('ticketForm').classList.add('active');
</script>

<section>
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-4 mb-4">
            <a href="messenger.php"><button type="button" class="btn btn-primary btn-lg">Message a Resident</button></a>
            <?php
            if($_SESSION['type'] == null) {
                echo "<a href='login.php'><button type='button' class='btn btn-primary btn-lg'>Login</button></a>";
            } else {
                echo "<a href='signout.php'><button type='button' class='btn btn-primary btn-lg'>Sign out</button></a>";
            }
            ?>
        </div>
    </div>
</section>
    <section class="cta">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <div class="cta-inner text-center rounded">
                        <h2 class="section-heading mb-5">
                            <span class="section-heading-upper">Suite Living</span>
                            <span class="section-heading-lower">Maintenance Request</span>
                        </h2>
                        <div class="card-body">
                        <?php
                        switch ($_SESSION['type']) {
                            case "R":
                                include 'src/php/rForm.php';
                                break;
                            case "A":
                            case "M":
                                include 'src/php/sForm.php';
                                break;
                        }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<footer class="footer text-faded text-center py-5">
    <div class="container">
        <p class="m-0 small">Developed by Students of Indiana University Kokomo</p>
    </div>
</footer>
<!-- Bootstrap core JavaScript -->
<script src="src/vendor/jquery/jquery.min.js"></script>
<script src="src/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>