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

    <!-- Bootstrap core JavaScript -->
    <script src="src/vendor/jquery/jquery.min.js"></script>
    <script src="src/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!--javascript stuff for tables-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body>

<h1 class="site-heading text-center text-white d-none d-lg-block">
    <span class="site-heading-lower" id="suiteHead" name="src/html/home.html">Suite Living</span>
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

<div id="indexPageCont">
    <div class="pageCont">
        <?php
        if(($_SESSION['type']) == null) {
            include 'src/html/home.html';
        } else {
            switch ($_SESSION['type']) {
                case "R":
                    include 'src/html/home.html';
                    break;
                case "A":
                    include 'src/php/admin.php';
                    break;
                case "M":
                    include 'src/php/assigned.php';
                    break;
            }
        }
        ?>
    </div>
</div>

<footer class="footer text-faded text-center py-5">
    <div class="container">
        <p class="m-0 small">Developed by Students of Indiana University Kokomo</p>
    </div>
</footer>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="src/vendor/datatable.js"></script>
<?php
if($_SESSION['type'] == null) {
    echo "
    <script>
    var contHtml;
    $('.nav-item').click(function() {
        if (!$(this).hasClass('active')) {
            $('.nav-item').removeClass('active');
            $(this).addClass('active');
            $('#indexPageCont').css({
                opacity: 0,
            });
            contHtml = $(this).children().attr('name');
            setTimeout(function() {
                $('.pageCont').load(contHtml);
            }, 500);
            setTimeout(function() {
                $('#indexPageCont').css({
                    opacity: 1,
                });
            }, 600);
        } else {

        }
    });
    $('#suiteHead').click(function() {
        if (!$('#homeBut').hasClass('active')) {
            $('.nav-item').removeClass('active');
            $('#homeBut').addClass('active');
            $('#indexPageCont').css({
                opacity: 0,
            });
            contHtml = $(this).attr('name');
            setTimeout(function() {
                $('.pageCont').load(contHtml);
            }, 500);
            setTimeout(function() {
                $('#indexPageCont').css({
                    opacity: 1,
                });
            }, 600);
        } else {

        }
    });
    $('#cellTitle').click(function() {
        if (!$('#homeBut').hasClass('active')) {
            $('.nav-item').removeClass('active');
            $('#homeBut').addClass('active');
            $('#indexPageCont').css({
                opacity: 0,
            });
            contHtml = $(this).attr('name');
            setTimeout(function() {
                $('.pageCont').load(contHtml);
            }, 500);
            setTimeout(function() {
                $('#indexPageCont').css({
                    opacity: 1,
                });
            }, 600);
        } else {

        }
    });
</script>
    ";
}
?>
</body>
</html>