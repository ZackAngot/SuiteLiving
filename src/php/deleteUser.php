<?php
if(isset($_POST['removeStaff'])){
    changeData("UPDATE MaintenanceTicket SET Assigned = null, Status = 'Unassigned', DateStarted = null WHERE Assigned = '" . $_POST['removeStaff']."' AND Status != 'Complete'");
    changeData("DELETE FROM Staff WHERE StaffID = '".$_POST['removeStaff']."'");
    changeData("DELETE FROM UserLogin WHERE UserID = '".$_POST['removeStaff']."'");
    unset($_POST['removeStaff']);
}

if(isset($_POST['removeUser'])){
    changeData("DELETE FROM UserLogin WHERE UserID = '".$_POST['removeUser']."'");
    unset($_POST['removeUser']);
}
?>
<div class="row">
<div class="col-md-6 p-5 mx-auto">
    <div class="mb-4 shadow-lg bg-faded rounded">
        <h2 class="bg-primary card-header section-heading text-center mb-5">
            <span class="fas fa-table mr-1"></span>
            <span class=" section-heading-lower">Delete Staff Users</span>
        </h2>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless" width="100%" cellspacing="0">
                    <thead>
                    <tr class = "bg-primary">
                        <th>Staff Type</th>
                        <th>Staff ID</th>
                        <th>Name</th>
                        <th>Remove User</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr class = "bg-primary">
                        <th>Staff Type</th>
                        <th>Staff ID</th>
                        <th>Name</th>
                        <th>Remove User</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                    $output ="";
                    $staffData = grabData("SELECT * FROM staff");
                    foreach ($staffData as $Data) {
                        if($Data['StaffType'] == 'A') {
                            $type = 'Admin';
                        } else {
                            $type = 'Maintenance';
                        }
                        $output= "
                                                <tr id = ".json_encode($Data['StaffID']).">
                                                <td>Staff Type: ".$type."</td>
                                                <td>Staff ID: ".$Data['StaffID']."</td>
                                                <td>Name: ".$Data['FirstName']." ".$Data['LastName']."</td>
                                                <td><p onclick = 'removeStaff(".json_encode($Data['StaffID']). ")' class ='btn btn-primary btn-xlonclick'>Remove User</p></td>";

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
<div class="col-md-6 p-5 mx-auto">
    <div class="mb-4 shadow-lg bg-faded rounded">
        <h2 class="bg-primary card-header section-heading text-center mb-5">
            <span class="fas fa-table mr-1"></span>
            <span class=" section-heading-lower">Remove Room Log In</span>
        </h2>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr class = "bg-primary">
                        <th>User ID</th>
                        <th>Remove Room Log in</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr class = "bg-primary">
                        <th>User ID</th>
                        <th>Remove Room Log in</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                    $output ="";
                    $staffData = grabData("SELECT * FROM userlogin WHERE UserType = 'R'");
                    foreach ($staffData as $Data) {
                        $output= "
                                                <tr id = ".json_encode($Data['UserID']).">
                                                <td>User ID: ".$Data['UserID']."</td>
                                                   <td><p onclick = 'removeRoom(".json_encode($Data['UserID']).")' class ='btn btn-primary btn-xlonclick'>Remove User</p></td>";
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
</div>