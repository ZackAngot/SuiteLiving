<?php
if (isset($_POST['submitAdduser'])) {
    $userID = $_POST['inputUserID'];
    $userPassword = $_POST['inputPassword'];
    $userType = $_POST['inlineRadioOptions'];
    $firstName = str_replace("'","\'",$_POST['firstName']);
    $lastName = str_replace("'","\'",$_POST['lastName']);
    $hash = password_hash($userPassword, PASSWORD_DEFAULT);
    if(dataExist("SELECT * FROM UserLogin WHERE UserID = '$userID'")) {
        echo '<script>alert("Can not add user, userID already exist")</script>';
    } else {
        if ($userType == 'R') {
            $query_user_Resident = changeData("INSERT INTO userlogin (UserID,Password,UserType ) VALUES ('$userID' ,'$hash','$userType')");
        } else {

            if ($userType == 'A' | $userType == 'M') {
                if ($userType == 'A') {
                    $query_user_M2 = changeData("INSERT INTO userlogin (UserID,Password,UserType ) VALUES ('$userID' ,'$hash','S')");

                    $query_user_M2 = changeData("INSERT INTO staff (StaffID,FirstName,LastName,StaffType)VALUES ('$userID' ,'$firstName','$lastName','A')");
                }
                if ($userType == 'M') {
                    $query_user_M1 = changeData("INSERT INTO userlogin (UserID,Password,UserType ) VALUES ('$userID' ,'$hash','S')");

                    $query_userM2 = changeData("INSERT INTO staff (StaffID,FirstName,LastName,StaffType)VALUES ('$userID' ,'$firstName','$lastName','M')");

                }
            }
        }
        echo '<script>alert("New user has been added!")</script>';
    }
    unset($_POST['submitAdduser']);
}

?>
<div class="pb-5 container">
    <div class="row">
        <div class=" col-xl-9 mx-auto">
            <div class="cta-inner text-center rounded">
                <h2 class="section-heading mb-5">
                    <span class="section-heading-upper">Admin Page</span>
                    <span class="section-heading-lower">Add User</span>
                </h2>
                <div class="card-body">
                    <form method="post" id = "addUser" action="index.php" onsubmit=" return checkformAddUser()">
                        <div class="form-group">
                            <label class="mb-1" for="inputUserID">UserID</label>
                            <input type="text" class="form-control py-4" name="inputUserID" id="inputUserID" placeholder="UserID">
                            <div id="userID_error" class ="text-danger"></div>
                        </div>
                        <div class="justify-content-lg-between form-row" id="addAnnouncementDate">
                            <div class="form-group col-md-6">
                                <label class="mb-1" for="inputPassword">Password</label>
                                <input type="password" class="form-control py-4" name="inputPassword" id="inputPassword" placeholder="Password">
                                <div id="inputPassword_error" class ="text-danger"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="mb-1" for="confirmPassword">Confirm Password</label>
                                <input type="password" class="form-control py-4" name="confirmPassword" id="confirmPassword" placeholder="Confirmed Password">
                                <div id="confirmPassword_error" class ="text-danger"></div>
                            </div>
                        </div>

                        <div class="p-2" id = "checkUserDiv">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="A">
                                <label class="form-check-label" for="inlineRadio1">Admin User</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="M">
                                <label class="form-check-label" for="inlineRadio2">Maintenance User</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="R">
                                <label class="form-check-label" for="inlineRadio3">Room User</label>
                            </div>
                            <div id="radio_error" class ="text-danger"></div>
                        </div>
                        <div id = "NameDiv">
                            <div class="form-group">
                                <label class="mb-1" for="firstName">First Name</label>
                                <input type="text" class="form-control py-4" name="firstName" id="firstName" placeholder="First Name">
                                <div id="fname_error" class ="text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label class="mb-1" for="lastName">Last Name</label>
                                <input type="text" class="form-control py-4" name="lastName" id="lastName" placeholder="Last Name">
                                <div id="lname_error" class ="text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                            <input class="btn btn-danger btn-xlonclick" type="reset" value="Reset">
                            <input name="submitAdduser" type="submit" class="btn btn-primary btn-xlonclick">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>