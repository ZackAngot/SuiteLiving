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
<!-- Navigation -->
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
    document.getElementById('contactUs').classList.add('active');
</script>

<section class="mb-4">
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
        <?php
        if ($_SESSION['type'] == 'R' || $_SESSION['type'] == null) {
        $AnnouncementInfo = array();
        $AnnouncementInfo = grabData("SELECT * FROM Announcements WHERE StartDate <= CURDATE()");
        changeData('DELETE FROM Announcements WHERE EndDate < CURDATE()');
        if(sizeof($AnnouncementInfo) == 0) {
            echo "<div><div class='alert alert-warning' role='alert' id='anno'>There is no announcements today</div></div>";
        } else {
        ?>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="10000">
            <div class="carousel-inner alert alert-warning">
                <?php
                $first = true;
                foreach ($AnnouncementInfo as $info) {
                    if ($first) {
                        echo "<div style='height: 20vh' class='carousel-item active'><span role='alert' id='anno'><h2 style='font-weight: bold'>" . $info['Title'] . "</h2><h4>" . $info['Message'] . "</h4></span></div>";
                        $first = false;
                    } else {
                        echo "<div style='height: 20vh' class='carousel-item'><span role='alert' id='anno'><h1 style='font-weight: bold'>" . $info['Title'] . "</h1><h4>" . $info['Message'] . "</h4></span></div>";
                    }
                }
                ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev" data-toggle="tooltip" data-placement="left" title="Previous Announcement">
                <span class="carousel-control-prev" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next" data-toggle="tooltip" data-placement="right" title="Next Announcement">
                <span class="carousel-control-next" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            <?php
            }
            }
            ?>
        </div>
    </div>
</section>


<section class="page-section about-heading">
    <div class="container">
        <img class="img-fluid rounded about-heading-img mb-3 mb-lg-0" src="src/img/introSL.jpg" alt="">
        <div class="about-heading-content">
            <div class="row">
                <div class="col-xl-9 col-lg-10 mx-auto">
                    <div class="bg-faded rounded p-5">
                        <h2 class="section-heading mb-4">
                            <span class="section-heading-lower">Contact Information</span>
                            <span class="section-heading-upper">Address</span>
                        </h2>
                        <p>Suite Living</p>
                        <p>1256 North 400 West</p>
                        <p>Marion, IN 46952</p>
                        <br>
                        <h2 class="section-heading mb-4">
                            <span class="section-heading-upper">Phone</span>
                        </h2>
                        <p>765-384-4323</p>
                        <div class = "container">
                            <iframe width="450" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;hl=en&amp;geocode=&amp;q=1256+N+400+W,+Marion+IN+46952&amp;sll=37.0625,-95.677068&amp;sspn=44.744674,99.052734&amp;ie=UTF8&amp;s=AARTsJods3YOMjx5zc_Z6zMpL8-GxBOy2g&amp;ll=40.588016,-85.741596&amp;spn=0.045626,0.072956&amp;z=13&amp;iwloc=addr&amp;output=embed"></iframe>
                            <br>
                            <br>
                            <a href="http://maps.google.com/maps?f=q&amp;hl=en&amp;geocode=&amp;q=1256+N+400+W,+Marion+IN+46952&amp;sll=37.0625,-95.677068&amp;sspn=44.744674,99.052734&amp;ie=UTF8&amp;ll=40.588016,-85.741596&amp;spn=0.045626,0.072956&amp;z=13&amp;iwloc=addr&amp;source=embed" target="_blank"><button type="button" class="btn btn-primary float-left btn-lg">View Larger Map</button></a>
                        </div>
                        <br>
                        <br>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
</div>
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