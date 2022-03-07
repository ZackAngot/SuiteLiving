<?php
if (isset($_POST['submitEditUser'])){
    $hash = password_hash($_POST['newPassword'],PASSWORD_DEFAULT);
    switch($_POST['inlineRadioOptions1']) {
        case 'A':
            if(!changeData("UPDATE UserLogin SET Password = '$hash' WHERE UserID = '".$_POST['inputGroupSelect01']."'")){
                echo '<script>alert("Could not connect to database. Try again later!")</script>';
            }
            break;
        case 'M':
            if(!changeData("UPDATE UserLogin SET Password = '$hash' WHERE UserID = '".$_POST['inputGroupSelect02']."'")){
                echo '<script>alert("Could not connect to database. Try again later!")</script>';
            }
            break;
        case 'R':
            if(!changeData("UPDATE UserLogin SET Password = '$hash' WHERE UserID = '".$_POST['inputGroupSelect03']."'")){
                echo '<script>alert("Could not connect to database. Try again later!")</script>';
            }
            break;
    }
    unset($_POST['submitEditUser']);
}
?>

<div class="pb-5 container">
    <div class="row">
        <div class=" col-xl-9 mx-auto">
            <div class="cta-inner text-center rounded">
                <h2 class="section-heading mb-5">
                    <span class="section-heading-upper">Admin Page</span>
                    <span class="section-heading-lower">Edit User Password</span>
                </h2>
                <div class="card-body">
                    <form method="post" id = "editUser" action="index.php" onsubmit=" return checkFormEditUser()">
                        <div class="p-2" id = "editCheckUserDiv">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions1" id="Radio1" value="A">
                                <label class="form-check-label" for="inlineRadio1">Admin User</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions1" id="Radio2" value="M">
                                <label class="form-check-label" for="inlineRadio2">Maintenance User</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions1" id="Radio3" value="R">
                                <label class="form-check-label" for="inlineRadio3">Room User</label>
                            </div>
                            <div id="radio_Edit_error" class ="text-danger"></div>
                        </div>
                        <div style="display: none" id="Selector1">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">Admin Users</label>
                                </div>
                                <select class="custom-select" name="inputGroupSelect01" id="inputGroupSelect01">
                                    <option id="Select">Select</option>
                                    <?php
                                    $staffMembers = grabData("SELECT StaffID, FirstName, LastName FROM staff WHERE StaffType='A'");
                                    foreach ($staffMembers as $staff) {
                                        ?>
                                        <option value = '<?php echo $staff['StaffID']?>' ><?php echo $staff['FirstName'] . " " . $staff['LastName']?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div id="radio_Select1_error" class ="text-danger"></div>
                        </div>
                        <div style="display: none" id="Selector2">
                            <div  class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect02">Maintenance Users</label>
                                </div>
                                <select class="custom-select" name = 'inputGroupSelect02' id="inputGroupSelect02">
                                    <option id="Select">Select</option>
                                    <?php
                                    $staffMembers = grabData("SELECT StaffID, FirstName, LastName FROM staff WHERE StaffType='M'");
                                    foreach ($staffMembers as $staff) {
                                        ?>
                                        <option value = '<?php echo $staff['StaffID']?>' ><?php echo $staff['FirstName'] . " " . $staff['LastName']?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div id="radio_Select2_error" class ="text-danger"></div>
                        </div>
                        <div style="display: none" id="Selector3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect03">Room Users</label>
                                </div>
                                <select class="custom-select" name="inputGroupSelect03" id="inputGroupSelect03">
                                    <option id="Select">Select</option>
                                    <?php
                                    $staffMembers = grabData("SELECT UserID, UserType FROM userlogin WHERE UserType='R'");
                                    foreach ($staffMembers as $staff) {
                                        ?>
                                        <option value = '<?php echo $staff['UserID']?>' ><?php echo $staff['UserID']?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div id="radio_Select3_error" class ="text-danger"></div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="mb-1" for="newPassword">New Password</label>
                                <input type="password" class="form-control py-4" name="newPassword"  id="newPassword" placeholder="New Password">
                                <div id="newPassword_error" class ="text-danger"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="mb-1" for="confirmNewPassword">Confirm Password</label>
                                <input type="password" class="form-control py-4" name="confirmNewPassword"  id="confirmNewPassword" placeholder="Confirm Password">
                                <div id="confirmNewPassword_error" class ="text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                            <input class="btn btn-danger btn-xlonclick" type="reset" value="Reset">
                            <button name="submitEditUser" type="submit" class="btn btn-primary btn-xlonclick">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>