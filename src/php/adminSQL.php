<?php
session_start();
include "src/functions.php";
if (isset($_POST['addUser'])) {
    $userID = $_POST['userID'];
    $userPassword = $_POST['userPassword'];
    $userType = $_POST['userType'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
//    $hash= password_hash($userPassword, PASSWORD_DEFAULT);
    if($userType=="R"){
    $query_user_Resident = changeData("INSERT INTO userlogin (userID,Password,UserType ) VALUES ('$userID' ,'$userPassword','$userType')");
    }

    if($userType=="A"|"M"){
        $query_user_login=changeData(  "INSERT INTO userlogin (userID,Password,UserType ) VALUES ('$userID' ,'$userPassword','S')");

        $query_visitors =changeData( "INSERT INTO staff (StaffID,FirstName,LastName,Password,UserType )VALUES ('$userID' ,'$firstName','$lastName','$userPassword','$userType')");

    }
}
if (isset($_POST['submitAddAnnouncement'])) {
    $announcementTitle = $_POST['announcementTitle'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $announcementText = $_POST['announcementText'];
    $query_announcement =changeData("INSERT INTO announcements (Title,Message,StartDate,EndDate) VALUES('$announcementTitle','$announcementText','$startDate','$endDate')");

}

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