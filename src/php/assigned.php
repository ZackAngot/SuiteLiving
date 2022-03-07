<?php
if (!$_SESSION['type'] == "M") {
    header('Location:/SuiteLiving/');
    exit;
}
if(isset($_POST['sql'])) {
    if(changeData("UPDATE MaintenanceTicket SET Status = 'Complete', DateFinished = CURDATE() WHERE TicketID = " . str_replace("T", "", $_POST['sql']))) {
        unset($_POST['sql']);
    } else {
        $updateError = 'error';
        unset($_POST['sql']);
    }
}
$assignedTickets = grabData("SELECT TicketID,Location,Description FROM MaintenanceTicket WHERE Assigned = '" . $_SESSION['ID'] . "' AND Status != 'Complete'");
?>
<script>
    function removeTicket(divID) {
        $.ajax({
            method: "POST",
            url: "index.php",
            data: {sql: divID}
        })
            .done(function( response ) {
                $(divID).html(response);
            });
        location.reload();
    }
</script>
    <section class="cta">
        <div class="container">
                <div class="col-xl-9 mx-auto">
                    <div class="bg-faded text-center rounded">
                        <h2 class="bg-primary card-header section-heading mb-5">
                            <span class="section-heading-upper"><?php echo $_SESSION["name"]?></span>
                            <span class="section-heading-lower">Your Assigned Tickets</span>
                        </h2>
                        <ul class="pl-4 pr-4 list-unstyled list-hours text-left mx-auto">
                            <?php
                            if(sizeof($assignedTickets) == 0) {
                                echo "
                                    <h2 class='text-center'>
                                        <span class='section-heading-upper'>You currently have no assigned tickets</span>
                                        <a class = 'btn btn-primary btn-xlonclick' href = 'tickets.php'>Claim Some Tickets Now</a><br>
                                    </h2>";
                            }
                            foreach($assignedTickets as $ticketInfo) {
                            ?>
                                <div ID = '<?php echo "T" . $ticketInfo['TicketID'];?>'>
                                    <p class = 'btn btn-primary btn-xlonclick' onclick = 'removeTicket(<?php echo json_encode("T" . $ticketInfo['TicketID'])?>)'>Mark As Complete</p>
                            <li  class="list-unstyled-item list-hours-item d-flex">
                                Location: <?php echo $ticketInfo['Location']?><br>
                                Description: <?php echo $ticketInfo['Description']?>
                            </li>
                                </div>
                                <?php
                            }
                            ?>
                        </ul>
                        <div class="card-footer bg-primary"></div>
                    </div>
                </div>
        </div>
    </section>
