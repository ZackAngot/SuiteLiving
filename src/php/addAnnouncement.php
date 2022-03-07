<?php
if (isset($_POST['submitAddAnnouncement'])){
    $text = str_replace("'","\'",$_POST['addAnnouncementText']);
    $title = str_replace("'","\'",$_POST['addAnnouncementTitle']);
    if (!changeData("INSERT INTO Announcements (Title, Message, StartDate, EndDate) Values ('".$title."','".$text."','".$_POST['startDate']."','".$_POST['endDate']."')")) {
        echo '<script>alert("Could not connect to database. Try again later!")</script>';
    }
    unset($_POST['submitAddAnnouncement']);
}
?>

<div class="pb-5 container">
    <div class="row">
        <div class=" col-xl-9 mx-auto">
            <div class="cta-inner text-center rounded">
                <h2 class="section-heading mb-5">
                    <span class="section-heading-upper">Admin Page</span>
                    <span class="section-heading-lower">Add Announcement</span>
                </h2>
                <div class="card-body">
                <form method="post" id = "addAnnouncement" action="index.php" onsubmit="return checkformAddAnnouncement()">
                    <div class="form-group">
                        <label class="mb-1" for="addAnnouncementTitle">Announcement Title</label>
                        <input type="text" class="form-control py-4" name="addAnnouncementTitle" id="addAnnouncementTitle" placeholder="Announcement Title">
                        <div id="announcementTitle_error" class ="text-danger"></div>
                    </div>
                    <div class="justify-content-lg-between form-row" id="addAnnouncementDate">
                        <div class="form-group col-md-6">
                            <label class="mb-1" for="startDate">Start Date</label>
                            <input class="form-control py-4" type="date" id="startDate" name="startDate">
                            <div id="startDate_error" class ="text-danger"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="mb-1" for="endDate">End Date</label>
                            <input class="form-control py-4" type="date" id="endDate" name="endDate">
                            <div id="endDate_error" class ="text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="mb-1" for="addAnnouncementText">Announcement Text</label>
                        <textarea placeholder="Announcement Text" class="form-control py-4" name="addAnnouncementText" id="addAnnouncementText" aria-label="With textarea" rows="10"></textarea>
                        <div id="announcement_Text_error" class ="text-danger"></div>
                    </div>
                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                        <input class="btn btn-danger btn-xlonclick" type="reset" value="Reset">
                        <input name = 'submitAddAnnouncement' type="submit" class="btn btn-primary btn-xlonclick" value="submit">
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>