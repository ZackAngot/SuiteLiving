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
<?php
} else {
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
}
?>
