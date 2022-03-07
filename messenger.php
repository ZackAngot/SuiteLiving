<?php
session_start();
include 'src/php/functions.php';
//=============================================================================================
$displayForm  = true;
$sender_Name              = "";
$sender_Name_error        = "";
$room_Number              = "";
$room_Number_error        = "";
$message_Body             = "";
$message_Body_error       = "";
//=============================================================================================
if(isset($_POST['submit'])) {

    $sender_Name = $_POST['sender_Name'];
    if (empty($sender_Name))
        $sender_Name_error = "Name is required";

    $room_Number = $_POST['room_Number'];
    if (empty($room_Number))
        $room_Number_error = "Room Number is required";
    else if (!preg_match("/^[0-9]+$|^[a-zA-Z]+\s?[0-9]+$/", $room_Number))
        $room_Number_error = "Room/apt Number can be entered as just the number or Room/apt then number Examples: room15, Room 50, 25, apt2, apartment 2.";

    $message_Body = $_POST['message_Body'];
    if (empty($message_Body))
        $message_Body_error = "Message is required";

    if (empty($sender_Name_error) & empty($room_Number_error) & empty($message_Body_error)) {
        $displayForm = false;
        $sender_Name = str_replace("'","\'",$_POST['sender_Name']);
        $message_Body = str_replace("'", "\'", $_POST['message_Body']);
    }

}
//=============================================================================================
?>
<!DOCTYPE html>
<html xmlns = "http://www.w3.org/1999/xhtml" lang="">
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
                            <span class="section-heading-upper">Message a Resident</span>
                            <span class="section-heading-lower">Contact Form</span>
                        </h2>
                        <div class="card-body">
                            <?php
                            if ($displayForm) {
                            ?>
                            <form method= "post" action="messenger.php">
                                <div class="form-group">
                                    <label class="small mb-1" for="sender_Name">Your Name</label>
                                    <input class="form-control py-4" type="text" id="sender_Name" name="sender_Name" value="<?php echo $sender_Name; ?>" placeholder="Please Enter Your Name:">
                                    <label class="text-danger"><?php echo $sender_Name_error; ?></label>
                                </div>
                                <div class="form-group">
                                    <label class="small mb-1 for="room_Number">Room Number</label>
                                    <input class="form-control py-4" type="text" id="room_Number" name="room_Number" value="<?php echo $room_Number; ?>" placeholder="Please Enter A Room Number:">
                                    <label class="text-danger"><?php echo $room_Number_error; ?></label>
                                </div>
                                <div class="form-group">
                                    <label class="small mb-1" for="message_Body">Subject (5000 Character Limit)</label>
                                    <textarea class="form-control py-4" id="message_Body" name="message_Body" placeholder="Please Write your Message Here:" style="height:200px"><?php echo $message_Body ; ?></textarea>
                                    <label class="text-danger"><?php echo $message_Body_error; ?></label>
                                </div>
                                <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <a class = "btn btn-danger btn-xlonclick" href="index.php">Go Back</a>
                                    <input class = "btn btn-primary btn-xlonclick" type="submit" name="submit" id="submit" value="Send Message">
                                </div>
                            </form>
                                <?php
                            } else {
                                if(!preg_match("/^[a-zA-Z]+\s?[0-9]*$/", $room_Number)) {
                                    if (changeData("INSERT INTO messages (sender_Name, room_Number, message_Body) VALUES ('$sender_Name', 'Room" . $room_Number . "', '$message_Body')")) {
                                        echo "Message Successfully Sent to Room $room_Number<br>";
                                        echo "<div class='form-group d-flex align-items-center justify-content-between mt-4 mb-0'>";
                                        echo "<a class = 'btn btn-danger btn-xlonclick' href = 'index.php'>Go Back to Homepage</a>";
                                        echo "<a class = 'btn btn-primary btn-xlonclick' href = 'messenger.php'>Send another Message</a></div>";
                                    } else {
                                        echo "Error occurred try again in a few minutes<br>";
                                        echo "<a class = 'btn btn-primary btn-xlonclick' href = 'index.php'>Go Back to Homepage</a>";
                                    }
                                } else {
                                    if (changeData("INSERT INTO messages (sender_Name, room_Number, message_Body) VALUES ('$sender_Name', '".str_replace(" ","",$room_Number)."', '$message_Body')")) {
                                        echo "Message Successfully Sent to $room_Number<br>";
                                        echo "<div class='form-group d-flex align-items-center justify-content-between mt-4 mb-0'>";
                                        echo "<a class = 'btn btn-danger btn-xlonclick' href = 'index.php'>Go Back to Homepage</a>";
                                        echo "<a class = 'btn btn-primary btn-xlonclick' href = 'messenger.php'>Send another Message</a></div>";
                                    } else {
                                        echo "Error occurred try again in a few minutes<br>";
                                        echo "<a class = 'btn btn-primary btn-xlonclick' href = 'index.php'>Go Back to Homepage</a>";
                                    }
                                }
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
