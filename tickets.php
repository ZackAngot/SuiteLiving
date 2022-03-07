<?php
session_start();
include 'src/php/functions.php';
if ($_SESSION['type'] == null || $_SESSION['type'] == "R") {
    header('Location: /SuiteLiving/');
    exit;
}

if(isset($_POST['updateTicket']) & isset($_POST['assignedTo'])) {
    if(changeData("UPDATE MaintenanceTicket SET Assigned = '".$_POST['assignedTo']."', Status = 'In Progress', DateStarted = CURDATE() WHERE TicketID = " . $_POST['updateTicket'])) {
        unset($_POST['updateTicket']);
        unset($_POST['assignedTo']);
    } else {
        $updateError = 'error';
        unset($_POST['updateTicket']);
        unset($_POST['assignedTo']);
    }
}
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

    <!--javascript stuff for tables-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <script>
        function AssignTicket(TicketID,StaffID) {
            $.ajax({
                method: "POST",
                url: "tickets.php",
                data: {updateTicket: TicketID, assignedTo: StaffID}
            })
                .done(function(response) {
                    $(TicketID).html(response);
                    $(StaffID).html(response);
                });
            location.reload();
        }
    </script>
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
    document.getElementById('tickets').classList.add('active');
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

<form class="cta" method="post" action="ticketForm.php">
    <div class="p-5 mx-auto">
        <div class="mb-4 shadow-lg bg-faded rounded">
            <h2 class="bg-primary card-header section-heading text-center mb-5">
                <span class="section-heading-upper">Suite Living</span>
                <span class="section-heading-lower">Ticket Dashboard</span>
            </h2>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr class = "bg-primary">
                            <th>Ticket Number</th>
                            <th>Type of Issue</th>
                            <th>Location</th>
                            <th>Description</th>
                            <th>Submission Date</th>
                            <th>Current Status</th>
                            <th>Assigned Details</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr class = "bg-primary">
                            <th>Ticket Number</th>
                            <th>Type of Issue</th>
                            <th>Location</th>
                            <th>Description</th>
                            <th>Submission Date</th>
                            <th>Current Status</th>
                            <th>Assigned Details</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php
                        $output ="";
                        $ticketData = grabData("SELECT * FROM maintenanceticket");
                        foreach ($ticketData as $Data) {
                            $output= "
                                    <tr>
                                        <td class = 'edit'><div class = 'ticketNumber'>T".$Data['TicketID']."</div><input style='display: none' class='editButton btn btn-primary btn-xlonclick' type = 'submit' id = 'edit' name ='edit' value='Edit T".$Data['TicketID']."'></td>
                                        <td>".$Data['IssueType']."</td>
                                        <td>".$Data['Location']."</td>
                                        <td>".$Data['Description']."</td>
                                        <td>".$Data['DateSubmitted']."</td>
                                        <td id = 'S".$Data['TicketID']."'>".$Data['Status']."</td>";
                            Switch($Data['Status']) {
                                case "Unassigned":
                                    if ($_SESSION['type'] == 'M') {
                                        $output .= "
                                            <td id = 'T".$Data['TicketID']."' ><p onclick = 'AssignTicket(".json_encode($Data['TicketID']).",".json_encode($_SESSION['ID']).");' class ='btn btn-primary btn-xlonclick'>Claim Ticket</p></td>";
                                    } else {
                                        $output .= "
                                                <td>No one Assigned Edit this ticket to Assign Someone</td>";
                                    }
                                    break;
                                case "In Progress":
                                    if($Data['Assigned'] == $_SESSION['ID']) {
                                        $output.="<td>Ticket is assigned to You</td>";
                                    } else {
                                        $assigned = grabData("SELECT FirstName, LastName FROM staff WHERE StaffID = '" . $Data['Assigned'] . "'");
                                        $output.="<td>Ticket assigned to " . $assigned[0]['FirstName'] . " " . $assigned[0]['LastName'] ."</td>";
                                    }
                                    break;
                                case "Complete":
                                    $output.= "<td>Date Started: " . $Data['DateStarted'] . "<br>Date Finished: " . $Data['DateFinished']."</td>";
                                    break;
                            }
                            $output.="</tr>";
                            echo $output;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>

<footer class="footer text-faded text-center py-5">
    <div class="container">
        <p class="m-0 small">Developed by Students of Indiana University Kokomo</p>
    </div>
</footer>
<!-- Bootstrap core JavaScript -->
<script src="src/vendor/jquery/jquery.min.js"></script>
<script src="src/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="src/vendor/datatable.js"></script>
<script>
    $(document).ready(function(){
        $(".edit").mouseover(function(){
            $(".editButton").show();
            $(".ticketNumber").hide();
        });
        $(".edit").mouseout(function(){
            $(".editButton").hide();
            $(".ticketNumber").show();
        });
    });
</script>
</body>
</html>

