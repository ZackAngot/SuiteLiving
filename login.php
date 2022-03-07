<?php
session_start();
include 'src/php/functions.php';
$_SESSION['ID'] = "";
$_SESSION['type'] = "";
$_SESSION['name'] = "";
$userInfo = "";
$userID = "";
$pass = "";
$IDError = "";
$passError = "";

if(isset($_POST['submit'])) {
    $userID = $_POST['UserID'];
    $pass = $_POST['pass'];

    if (!preg_match("/^([a-zA-Z]{3,})\s?([0-9]*)$/", $userID)) {
        $IDError = "Not a proper Room Number examples would be: Room101, Room102.";
    }

    if (!preg_match("/^([a-zA-Z0-9]{4,})$/", $pass)) {
        $passError = "passwords are at least 5 characters long and only contain numbers and letters.";
    }

    if(empty($passError) && empty($IDError)) {
        if (dataExist("SELECT * FROM UserLogin WHERE UserID = '$userID'")) {
            $userInfo = grabData("SELECT * FROM UserLogin WHERE UserID = '$userID'");
            if (!password_verify($pass, $userInfo[0]['Password'])) {
                $passError = "Password is incorrect";
            }
        } else {
            $IDError = "Room Number does not exist. Consult with a staff member";
        }
    }

    if(empty($passError) && empty($IDError)) {
        if($userInfo[0]['UserType'] == 'R') {
            $_SESSION['ID'] = $userInfo[0]['UserID'];
            $_SESSION['type'] = $userInfo[0]['UserType'];
        } else {
            $staff = $userInfo[0]['UserID'];
            $userInfo = grabData("SELECT * FROM Staff WHERE StaffID = '$staff'");
            $_SESSION['ID'] = $userInfo[0]['StaffID'];
            $_SESSION['type'] = $userInfo[0]['StaffType'];
            $_SESSION['name'] = $userInfo[0]['FirstName'] . " " . $userInfo[0]['LastName'];
        }
        header('Location: /SuiteLiving/');
        exit;
    }
}
?>
<html>

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
    <span class="site-heading-upper text-primary mb-3">Living Defined by You</span>
    <span class="site-heading-lower">Suite Living</span>
</h1>

<section class="cta">
    <div class="container">
        <div class="row">
            <div class=" col-xl-9 mx-auto">
                <div class="cta-inner  text-center rounded">
                    <h2 class="section-heading mb-5">
                        <span class="section-heading-upper">Suite Living</span>
                        <span class="section-heading-lower">Room Login</span>
                    </h2>
                    <div class="card-body">
                        <form method="post" action="login.php">
                            <div class="form-group">
                                <label class="small mb-1" for="inputEmailAddress">Room Number</label>
                                <input class="form-control py-4" name = "UserID" id="UserID" type="text" placeholder="Enter Room Number" value='<?php echo $userID?>'/>
                                <label class="text-danger"><?php echo $IDError?></label>
                            </div>
                            <div class="form-group">
                                <label class="small mb-1" for="inputPassword">Password</label>
                                <input class="form-control py-4" name = "pass" id="pass" type="password" placeholder="Enter Room password" value='<?php echo $pass?>'/>
                                <label class="text-danger"><?php echo $passError?></label>
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                <a class = "btn btn-danger btn-xlonclick" href="index.php">Go Back</a>
                                <input class = "btn btn-primary btn-xlonclick" type="submit" name="submit" id="submit" value="Login">
                            </div>
                        </form>
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
