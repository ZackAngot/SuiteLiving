<?php
$displayForm = true;
$lError = "";
$typeError = "";
$dError = "";
$location = "";
$issueType = "";
$description = "";
$assign = "";

if(isset($_POST['reset'])) {
    unset($_POST['submit']);
    unset($_POST['reset']);
}

if ($_SESSION['edit'] != null) {
    $status = '';
    $startDate = '';
    $editTicket = grabData("SELECT * FROM MaintenanceTicket WHERE TicketID =".str_replace("Edit T", "", $_SESSION['edit']));
    $location = $editTicket[0]['Location'];
    $issueType = $editTicket[0]['IssueType'];
    $description = $editTicket[0]['Description'];
    $assign = $editTicket[0]['Assigned'];
    $startDate = $editTicket[0]['DateStarted'];
    $status = $editTicket[0]['Status'];
}

if(isset($_POST['submit'])) {
    $location = $_POST['location'];
    $issueType = $_POST['issueType'];
    $description = str_replace("'","\'", $_POST['description']);
    if ($_SESSION['type'] == "A") {
        $assign = $_POST['assign'];
    } else {
        if (isset($_POST['assign'])){
            $assign = $_POST['assign'];
        } else {
            $assign = 'no';
        }
    }

    if(empty($location)) {
        $lError = "Please provide the location of this issue!";
    } else {
        if(!preg_match("/^[a-zA-Z]{3,}\s?[0-9]+$|^[a-zA-Z\s]+$/", $location)) {
            $lError = "If the location is a resident room please provide the Room number, Otherwise this form only accepts letters";
        }
    }

    if(strcmp($issueType, "select") == 0) {
        $typeError = "Please choose the type of issue, if none match please select other.";
    }

    if (empty($description)) {
        $dError = "Please provide a short description about the issue.";
    }

    if(empty($lError) & empty($dError) & empty($typeError)) {
        str_replace("'","\'", $description);
        $displayForm = false;
    }
}

if ($displayForm) {
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
            <div class="col-xl-9 mx-auto">
                <div class="cta-inner text-center rounded">
                    <h2 class="section-heading mb-5">
                        <span class="section-heading-upper">Suite Living</span>
                        <span class="section-heading-lower">Maintenance Request</span>
                    </h2>
                    <div class="card-body">
                        <form method="post" action="ticketForm.php">
                            <div class="form-group">
                                <label class="mb-1">Location of Issue</label>
                                <input class="form-control py-4" name = "location" id="location" type="text" placeholder="Location of Issue" value=<?php echo $location?>>
                                <label class="text-danger"><?php echo $lError?></label>
                            </div>
                            <div class="form-group">
                                <label class="mb-1">Type of Issue</label>
                                <select class="form-control" name="issueType" id="issueType">
                                    <option value="select">Select Type</option>
                                    <option value="Electrical" <?php if(strcmp($issueType, 'Electrical') == 0){echo 'selected';}?>>Electrical</option>
                                    <option value="Plumbing"<?php if(strcmp($issueType, 'Plumbing') == 0){echo 'selected';}?>>Plumbing</option>
                                    <option value="AC/Heating"<?php if(strcmp($issueType, "AC/Heating") == 0){echo 'selected';}?>>AC/Heating</option>
                                    <option value="Other"<?php if(strcmp($issueType, 'Other') == 0){echo 'selected';}?>>Other</option>
                                </select>
                                <label class="text-danger"><?php echo $typeError?></label>
                            </div>
                            <div class="form-group">
                                <label class="mb-1">Detailed Description of Issue</label>
                                <textarea class="form-control py-4" name="description" id="description" rows="5" cols="20" placeholder="Provide a Short Description Please"><?php echo $description?></textarea>
                                <label class="text-danger"><?php echo $dError?></label>
                            </div>
                            <?php
                            if ($_SESSION['type'] == "M") {
                                ?>
                                <div class="form-group">
                                    <label class="mb-1">Assign Ticket to Your Self</label>
                                    <input class="form-control py-4" type="checkbox" id="yes" name="assign" value=<?php echo $_SESSION['ID']?>>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="form-group">
                                    <label class="mb-1">Assign Ticket</label>
                                    <select class="form-control" name="assign" id="assign">
                                        <option value="no">No Selection</option>
                                        <?php
                                        $staffMembers = grabData("SELECT StaffID, FirstName, LastName FROM staff WHERE staffType = 'M'");
                                        foreach ($staffMembers as $staff) {
                                            ?>
                                            <option value = '<?php echo $staff['StaffID']?>' <?php if(strcmp($assign, $staff['StaffID']) == 0){echo 'selected';}?>><?php echo $staff['FirstName'] . " " . $staff['LastName']?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                <input class = "btn btn-danger btn-xlonclick" type="submit" name="reset" id="reset" value="Start Over">
                                <input class = "btn btn-primary btn-xlonclick" type="submit" name="submit" id="submit" value="Submit Request">
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
    <?php
} else {
    if ($_SESSION['edit'] == null) {
        if (strcmp($assign, 'no') == 0) {
            if (changeData("INSERT INTO maintenanceticket (IssueType, Description, Location, DateSubmitted, Status) VALUES ('$issueType', '$description', '$location', CURDATE(), 'Unassigned')")) {
                echo "Ticket Submitted successfully. Thank You<br>";
                echo "<a class = 'btn btn-primary btn-xlonclick' href = 'TicketForm.php'>Enter Another Ticket</a>";
            } else {
                echo "Error occurred try again in a few minutes<br>";
                echo "<a class = 'btn btn-primary btn-xlonclick' href = 'index.php'>Go Back to Homepage</a>";
            }
        } else {
            if (changeData("INSERT INTO maintenanceticket (Assigned,IssueType, Description, Location, DateSubmitted, Status,DateStarted) VALUES ('$assign','$issueType', '$description', '$location', CURDATE(), 'In Progress',CURDATE())")) {
                echo "Ticket Submitted successfully. Thank You<br>";
                echo "<a class = 'btn btn-primary btn-xlonclick' href = 'TicketForm.php'>Enter Another Ticket</a>";
            } else {
                echo "Error occurred try again in a few minutes<br>";
                echo "<a class = 'btn btn-primary btn-xlonclick' href = 'index.php'>Go Back to Homepage</a>";
            }
        }
    } else {
        if (strcmp($assign, 'no') == 0) {
            if (changeData("UPDATE maintenanceticket SET IssueType = '$issueType', Description = '$description', Location = '$location', Status = 'Unassigned', DateStarted = null WHERE TicketID = " . str_replace("Edit Ticket", "", $_SESSION['edit']))) {
                echo "Ticket Submitted successfully. Thank You<br>";
                echo "<a class = 'btn btn-primary btn-xlonclick' href = 'TicketForm.php'>Enter Another Ticket</a>";
            } else {
                echo "Error occurred try again in a few minutes<br>";
                echo "<a class = 'btn btn-primary btn-xlonclick' href = 'index.php'>Go Back to Homepage</a>";
            }
        } else {
            if (empty($startDate)) {
                if (changeData("UPDATE maintenanceticket SET Assigned = '$assign', IssueType = '$issueType', Description = '$description', Location = '$location', Status = 'In Progress', DateStarted = CURDATE() WHERE TicketID = " . str_replace("Edit Ticket", "", $_SESSION['edit']))) {
                    echo "Ticket Submitted successfully. Thank You<br>";
                    echo "<a class = 'btn btn-primary btn-xlonclick' href = 'TicketForm.php'>Enter Another Ticket</a>";
                } else {
                    echo "Error occurred try again in a few minutes<br>";
                    echo "<a class = 'btn btn-primary btn-xlonclick' href = 'index.php'>Go Back to Homepage</a>";
                }
            } else {
                if (changeData("UPDATE maintenanceticket SET Assigned = '$assign', IssueType = '$issueType', Description = '$description', Location = '$location', Status = '$status' WHERE TicketID = " . str_replace("Edit Ticket", "", $_SESSION['edit']))) {
                    echo "Ticket Submitted successfully. Thank You<br>";
                    echo "<a class = 'btn btn-primary btn-xlonclick' href = 'TicketForm.php'>Enter Another Ticket</a>";
                } else {
                    echo "Error occurred try again in a few minutes<br>";
                    echo "<a class = 'btn btn-primary btn-xlonclick' href = 'index.php'>Go Back to Homepage</a>";
                }
            }
        }
    }
}
?>
