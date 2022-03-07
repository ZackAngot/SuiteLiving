<style>
    .error{
        color: red;
    }
</style>
<head>
    <script>
        // Add user form validation and ajax call to run sql query
        function checkformAddUser(){
            var errorCount = 0;
            var usertype;
            var frm = document.getElementById("addUser");
            var userID = document.getElementById("inputUserID").value;
            var userPassword = document.getElementById("inputPassword").value;
            var confirmPassword = document.getElementById("confirmPassword").value;
            var userType = document.getElementsByName("inlineRadioOptions");
            for(i = 0; i < userType.length; i++) {
                if(userType[i].checked)
                    usertype=userType[i];
            }
            var firstName = document.getElementById("firstName").value;
            var lastName = document.getElementById("lastName").value;

            if (frm.inputUserID.value === ""){
                document.getElementById("userID_error").innerHTML = " User ID for user is required!";
                errorCount++;
            } else {
                if(frm.inputUserID.value.match(/^[0-9]+$|^[a-zA-Z]+[0-9]*$/g) == null) {
                    document.getElementById("userID_error").innerHTML = "letters and numbers only with numbers at the end!";
                    errorCount++;
                } else {
                    document.getElementById("userID_error").innerHTML = "";
                }
            }

            if (frm.inputPassword.value === ""){
                document.getElementById("inputPassword_error").innerHTML = " Password for user is required!";
                errorCount++;
            } else {
                if (frm.inputPassword.value.match(/^[a-zA-Z0-9]{5,}$/g) == null) {
                    document.getElementById("inputPassword_error").innerHTML = "you can only use letters and numbers and it has to be at least 5 characters long!";
                    errorCount++;
                } else {
                    document.getElementById("inputPassword_error").innerHTML = "";
                }
            }

            if (frm.confirmPassword.value === ""){
                document.getElementById("confirmPassword_error").innerHTML = "Confirm Password for user is required!";
                errorCount++;
            } else {
                if (userPassword !== confirmPassword) {
                    document.getElementById("confirmPassword_error").innerHTML = "Passwords do not match!";
                    errorCount++;
                } else {
                    document.getElementById("confirmPassword_error").innerHTML = "";
                }
            }


            if ( !(frm.inlineRadio1.checked) & !(frm.inlineRadio2.checked) & !(frm.inlineRadio3.checked)) {
                document.getElementById("radio_error").innerHTML = " Please select an option!";
                errorCount++;
            }else document.getElementById("radio_error").innerHTML = "";


            if ( (frm.inlineRadio1.checked || frm.inlineRadio2.checked)) {
                if (frm.firstName.value === ""){
                    document.getElementById("fname_error").innerHTML = " First Name is required!";
                    errorCount++;
                }else document.getElementById("fname_error").innerHTML = "";

                if (frm.lastName.value === ""){
                    document.getElementById("lname_error").innerHTML = " Last name is required!";
                    errorCount++;
                }else document.getElementById("lname_error").innerHTML = "";
            }   if (errorCount > 0) {
                return false;
            } if (confirm('Are you sure you want to add this user?')) {
                return true;
            }else{
                return false;

            }


        }
        //--------------------------------------------------------------------
        function checkformAddAnnouncement() {
            var errorCount = 0;
            var frm = document.getElementById("addAnnouncement");

            if (frm.addAnnouncementText.value === ""){
                document.getElementById("announcement_Text_error").innerHTML = "Announcement Text is required!";
                errorCount++;
            }else{
                document.getElementById("announcement_Text_error").innerHTML = "";
            }

            if (frm.addAnnouncementTitle.value === "") {
                document.getElementById("announcementTitle_error").innerHTML = " Announcement Title is required!";
                errorCount++;
            } else {
                document.getElementById("announcementTitle_error").innerHTML = "";
            }

            if (frm.startDate.value === "") {
                document.getElementById("startDate_error").innerHTML = " Start Date is required!";
                errorCount++;
            } else{
                document.getElementById("startDate_error").innerHTML = "";
            }

            if (frm.endDate.value === "") {
                document.getElementById("endDate_error").innerHTML = " End Date is required!";
                errorCount++;
            } else {
                document.getElementById("endDate_error").innerHTML = "";
            }

            if (errorCount > 0) {
                return false;
            }

            if (confirm('Are you sure you want to add this announcement?')) {
                alert("Announcement has been added!");
                return true;
            }else{
                return false;

            }
        }

        function checkFormEditUser() {
            var errorCount = 0;
            var frm = document.getElementById("editUser");
            var newPassword = document.getElementById("newPassword").value;
            var confirmNewPassword = document.getElementById("confirmNewPassword").value;
            if (!(frm.Radio1.checked) & !(frm.Radio2.checked) && !(frm.Radio3.checked)) {
                document.getElementById("radio_Edit_error").innerHTML = " Please select an option!";
                errorCount++;
            } else document.getElementById("radio_Edit_error").innerHTML = "";
            if (frm.Radio1.checked) {
                if (frm.inputGroupSelect01.value === "Select") {
                    document.getElementById("radio_Select1_error").innerHTML = " Please select a User option!";
                    errorCount++;
                } else document.getElementById("radio_Select1_error").innerHTML = "";

            }
            if (frm.Radio2.checked) {
                if (frm.inputGroupSelect02.value === "Select") {
                    document.getElementById("radio_Select2_error").innerHTML = " Please select a User option!";
                    errorCount++;
                } else document.getElementById("radio_Select2_error").innerHTML = "";


            }
            if (frm.Radio3.checked) {
                if (frm.inputGroupSelect03.value === "Select") {
                    document.getElementById("radio_Select3_error").innerHTML = " Please select a User option!";
                    errorCount++;
                } else document.getElementById("radio_Select3_error").innerHTML = "";


            }

            if (frm.newPassword.value === "") {
                document.getElementById("newPassword_error").innerHTML = " New Password for user is required!";
                errorCount++;
            } else {
                if (frm.newPassword.value.match(/^[a-zA-Z0-9]{5,}$/g) == null) {
                    document.getElementById("newPassword_error").innerHTML = "you can only use letters and numbers and it has to be at least 5 characters long!";
                    errorCount++;
                } else {
                    document.getElementById("newPassword_error").innerHTML = "";
                }
            }

            if (frm.confirmNewPassword.value === "") {
                document.getElementById("confirmNewPassword_error").innerHTML = " New Password for user is required!";
                errorCount++;
            } else {
                if (confirmNewPassword !== newPassword) {
                    document.getElementById("confirmNewPassword_error").innerHTML = "Passwords do not match!";
                    errorCount++;
                } else {
                    document.getElementById("confirmNewPassword_error").innerHTML = "";
                }
            }

            if (errorCount > 0) {
                return false;
            } if (confirm('Are you sure you want to change this user\'s password?')) {
                alert("The selected user's password has been updated");
                return true;
            }else{
                return false;

            }
        }
        function checkFormEditForm(){
            var errorCount=0;
            var frm = document.getElementById("editAnnouncement");
            if (frm.inputGroupSelect1.value ==="Select"){
                document.getElementById("selector_error").innerHTML = " Please select an Announcement option!";
                errorCount++;
            }else document.getElementById("selector_error").innerHTML = "";
            if (frm.editAnnouncementText.value === ""){
                document.getElementById("editAnnouncement_Text_error").innerHTML = "Announcement Text is required!";
                errorCount++;
            }else document.getElementById("editAnnouncement_Text_error").innerHTML = "";
            if (errorCount > 0) {
                return false;
            } if (confirm('Are you sure you want to update this announcement?')) {
                alert("The Selected Announcement Text Has Been Updated");
                return true;
            }else{
                return false;

            }

        }


        //Radio button hide and show function
        $(document).ready(function(){
            $("#inlineRadio3").click(function(){
                $("#NameDiv").hide(500);
            });
            $("#inlineRadio1").click(function(){
                $("#NameDiv").show(500);
            });
            $("#inlineRadio2").click(function(){
                $("#NameDiv").show(500);
            });
        });
        $(document).ready(function(){
            $("#Radio1").click(function(){
                $("#Selector1").show(500);
                $("#Selector2").hide(500);
                $("#Selector3").hide(500);
            });
            $("#Radio2").click(function(){
                $("#Selector1").hide(500);
                $("#Selector2").show(500);
                $("#Selector3").hide(500);
            });
            $("#Radio3").click(function(){
                $("#Selector1").hide(500);
                $("#Selector2").hide(500);
                $("#Selector3").show(500);
            });
        });
        //--------------------------------------------------------------------
        //Admin Nav hid and show function
        $(document).ready(function(){
            $("#AddUserNav").click(function(){
                $("#editUserDiv").slideUp(850);
                $("#deleteUserDiv").slideUp(850);
                $("#addAnnouncementDiv").slideUp(850);
                $("#editAnnouncementDiv").slideUp(850);
                $("#deleteAnnouncementDiv").slideUp(850);
                setTimeout(function(){ $("#addUserDiv").slideDown(850);}, 850);
            });
            $("#EditUserNav").click(function(){
                $("#addUserDiv").slideUp(850);
                $("#deleteUserDiv").slideUp(850);
                $("#addAnnouncementDiv").slideUp(850);
                $("#editAnnouncementDiv").slideUp(850);
                $("#deleteAnnouncementDiv").slideUp(850);
                setTimeout(function(){$("#editUserDiv").slideDown(850); }, 850);

            });
            $("#DeleteUserNav").click(function(){
                $("#editUserDiv").slideUp(850);
                $("#addUserDiv").slideUp(850);
                $("#addAnnouncementDiv").slideUp(850);
                $("#editAnnouncementDiv").slideUp(850);
                $("#deleteAnnouncementDiv").slideUp(850);
                setTimeout(function(){$("#deleteUserDiv").slideDown(850); }, 850);

            });
            $("#aAnnouncementNav").click(function(){
                $("#editUserDiv").slideUp(850);
                $("#deleteUserDiv").slideUp(850);
                $("#addUserDiv").slideUp(850);
                $("#editAnnouncementDiv").slideUp(850);
                $("#deleteAnnouncementDiv").slideUp(850);
                setTimeout(function(){$("#addAnnouncementDiv").slideDown(850); }, 850);

            });
            $("#eAnnouncementNav").click(function(){
                $("#editUserDiv").slideUp(850);
                $("#deleteUserDiv").slideUp(850);
                $("#addAnnouncementDiv").slideUp(850);
                $("#addUserDiv").slideUp(850);
                $("#deleteAnnouncementDiv").slideUp(850);
                setTimeout(function(){$("#editAnnouncementDiv").slideDown(850); }, 850);

            });
            $("#dAnnouncementNav").click(function(){
                $("#editUserDiv").slideUp(850);
                $("#deleteUserDiv").slideUp(850);
                $("#addAnnouncementDiv").slideUp(850);
                $("#editAnnouncementDiv").slideUp(850);
                $("#addUserDiv").slideUp(850);
                setTimeout(function(){ $("#deleteAnnouncementDiv").slideDown(850);}, 850);

            });
        });

        function removeStaff(StaffID) {
            if (confirm('Are you sure you want to delete this user?')) {
                document.getElementById(StaffID).remove();
                $.ajax({
                    method: "POST",
                    url: "index.php",
                    data: {removeStaff: StaffID}
                })
                    .done(function(response) {
                        $(StaffID).html(response);
                    });
                alert("The user has been deleted!");
            }
        }
        function removeRoom(userID) {
            if (confirm('Are you sure you want to delete this user?')) {
                document.getElementById(userID).remove();
                $.ajax({
                    method: "POST",
                    url: "index.php",
                    data: {removeUser: userID}
                })
                    .done(function (response) {
                        $(userID).html(response);
                    });
                alert("The user has been deleted!");
            }
        }
        function removeAnnouncement(announcementID){
            if (confirm('Are you sure you want to delete this Announcement?')) {
                document.getElementById(announcementID).remove();
                $.ajax({
                    method: "POST",
                    url: "index.php",
                    data: {removeAnnouncement: announcementID}
                })
                    .done(function (response) {
                        $(announcementID).html(response);
                    });
                alert("The Announcement has been deleted!");
            }
        }


    </script>
</head>

<section class="p-5 cta">
    <div class="mx-auto">
        <div class="bg-faded mb-4 rounded">
            <div id = "adminNavDiv" class="bg-primary card-header section-heading text-center mb-5">
                <h2 class="mt-2 p-1" role="presentation">
                    <button id = "AddUserNav" type="button" class="btn btn-light btn-lg" >Add User</button>
                    <button id = "EditUserNav" type="button" class="btn btn-light btn-lg" >Edit User Password</button>
                    <button id = "DeleteUserNav" type="button" class="btn btn-light btn-lg" >Delete User</button>
                    <button id = "aAnnouncementNav" type="button" class="btn btn-light btn-lg" >Add Announcement</button>
                    <button id = "dAnnouncementNav" type="button" class="btn btn-light btn-lg" >Delete Announcement</button>
                    <button id = "eAnnouncementNav" type="button" class="btn btn-light btn-lg">Edit Announcement Text</button>
                </h2>
            </div>
            <div id = "addUserDiv">
                <?php include 'addUser.php';?>
            </div>
            <div style="display: none" id = "editUserDiv" >
                <?php include 'editUser.php';?>
            </div>
            <div style="display: none" id = "deleteUserDiv">
                <?php include 'deleteUser.php';?>
            </div>
            <div style="display: none" id = "addAnnouncementDiv">
                <?php include 'addAnnouncement.php';?>
            </div>
            <div style="display: none" id = "editAnnouncementDiv">
                <?php include 'editAnnouncement.php';?>
            </div>
            <div style="display: none" id = "deleteAnnouncementDiv">
                <?php include 'deleteAnnouncement.php';?>
            </div>
            </div>
        </div>
</section>