<?php
session_start();
include 'src/php/functions.php';
if ($_SESSION['type'] != "A") {
    header('Location:/SuiteLiving/');
    exit;
}
if(isset($_POST['message'])) {
    $_SESSION['testing'] = "testing some shit bro";
    if(changeData("DELETE FROM Messages WHERE message_ID = ".$_POST['message'])) {
        unset($_POST['message']);
    } else {
        $updateError = 'error';
        unset($_POST['message']);
    }
}

$receivedMessages = grabData("SELECT * FROM Messages");
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <style>
        .message {
            display:none;
        }
        @media print {
            .printHead {
                font-size: 2em;
                font-weight: bold;
            }
            .printMessage {
                font-size: 1.5em;
            }
            .print {
                background-color: white;
                height: 100%;
                width: 100%;
                top: 0;
                left: 0;
                margin: 0;
            }
        }
    </style>
    <script>
        function printMessage(divID) {
            $( document ).ready(function() {
                document.getElementById(divID).classList.replace('d-print-none', 'd-print-block');
                document.getElementById(divID).classList.add('print');
                window.print();
                document.getElementById(divID).classList.replace('d-print-block', 'd-print-none');
            });

        }
        function removeMessage(messageID, divID) {
            $.ajax({
                method: "POST",
                url: "messages.php",
                data: {message: messageID}
            })
                .done(function( response ) {
                    $(messageID).html(response);
                });
            location.reload();
        }
    </script>

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
        document.getElementById('messages').classList.add('active');
</script>

<section class="d-print-none">
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
</section>
            <div class="justify-content-center mx-auto bg-faded">
                <h2 class="card-header bg-primary d-print-none text-center section-heading mb-5">
                    <span class="section-heading-upper">Suite Living</span>
                    <span class="section-heading-lower">Resident Messages</span>
                    <div class="d-print-none mb-2 d-flex justify-content-center">
                        <input class = 'btn-lg btn btn-light btn-xlonclick' type="button" id="previous1" value="<<"/>
                        <div class = 'pl-5 pr-5 section-heading-lower' id="pageNum1">Page 1</div>
                        <input class = 'btn-lg btn btn-light btn-xlonclick' type="button" id="next1" value=">>"/>
                    </div>
                </h2>
                <?php
                if(sizeof($receivedMessages) == 0) {
                    echo "
                <div class='container cta-inner rounded p-5'>
                    <h2 class='section-heading'>
                        <span class='section-heading-lower text-center'>You currently haven't received any messages. Check back later.</span>
                    </h2>
                    </div>";
                            } else {
                                ?>
                            <ul id = "messages" class="text-left mx-auto">
                            <?php
                                echo "<script>var endPage =".json_encode(sizeof($receivedMessages))."</script>";
                                $count = 1;
                                foreach($receivedMessages as $messageInfo) {
                                ?>
                                <div id = '<?php echo "R" . $count;?>' class="message">
                                    <span class = 'd-print-none btn btn-primary btn-xlonclick' onclick = 'printMessage(<?php echo json_encode("P" . $messageInfo['message_ID'])?>)'>Print Message</span>
                                    <span class = 'd-print-none btn btn-primary btn-xlonclick' onclick = 'removeMessage(<?php echo json_encode($messageInfo['message_ID'])?>,<?php echo json_encode("R" . $count)?>)'>Remove Message</span>
                                    <div ID = '<?php echo "P" . $messageInfo['message_ID'];?>' class="d-print-none">
                                        <p class = 'printHead'>To <?php echo $messageInfo['room_Number']?></p>
                                        <p class = 'printHead'>Sent By <?php echo $messageInfo['sender_Name']?></p>
                                        <p class = 'printMessage'>Message: <br> <?php echo $messageInfo['message_Body']?></p>
                                    </div>
                                </div>
                                <?php
                                    $count++;
                                }
                            }
                            ?>
                        </ul>
                <div class="d-print-none text-center section-heading card-footer bg-primary d-flex justify-content-center">
                    <input class = 'btn btn-light btn-xlonclick btn-lg' type="button" id="previous2" value="<<"/>
                    <div class = 'pl-5 pr-5 section-heading-lower' id="pageNum2">Page 1</div>
                    <input class = 'btn btn-light btn-xlonclick btn-lg' type="button" id="next2" value=">>"/>
                </div>
            </div>
<footer class="d-print-none footer text-faded text-center py-5">
    <div class="container">
        <p class="m-0 small">Developed by Students of Indiana University Kokomo</p>
    </div>
</footer>
<!-- Bootstrap core JavaScript -->
<script src="src/vendor/jquery/jquery.min.js"></script>
<script src="src/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
    var page = 0;
    var pageSize = 3;
    if(endPage%pageSize==0) {
        endPage = (endPage/pageSize) - 1;
    } else {
        endPage = Math.floor(endPage/pageSize);
    }

    $(document).ready(function () {

        togglePage(page);

        $("#next1").click(function () {
            if(page < endPage) {
                togglePage(page);
                page++;
                togglePage(page);
                document.getElementById('pageNum1').innerHTML = "Page " + (page+1);
                document.getElementById('pageNum2').innerHTML = "Page " + (page+1);
            }
        });
        $("#previous1").click(function () {

            if( page > 0) {
                togglePage(page);
                page--;
                togglePage(page);}
                document.getElementById('pageNum1').innerHTML = "Page " + (page+1);
            document.getElementById('pageNum2').innerHTML = "Page " + (page+1);
            }

        );
        $("#next2").click(function () {
            if(page < endPage) {
                togglePage(page);
                page++;
                togglePage(page);
                document.getElementById('pageNum1').innerHTML = "Page " + (page+1);
                document.getElementById('pageNum2').innerHTML = "Page " + (page+1);
            }
        });
        $("#previous2").click(function () {

                if( page > 0)
                {
                    togglePage(page);
                    page--;
                    togglePage(page);}
            document.getElementById('pageNum1').innerHTML = "Page " + (page+1);
            document.getElementById('pageNum2').innerHTML = "Page " + (page+1);
            }

        );

    });

    function togglePage(page) {
        for (var i = 1 ; i < pageSize  + 1; i++) {
            //alert("#product-" + ((page * pageSize) + i));
            $("#R" + ((page * pageSize) + i)).toggle();
        }
    }
</script>
</script>
</body>
</html>