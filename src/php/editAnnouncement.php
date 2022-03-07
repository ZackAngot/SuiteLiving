<?php
if (isset($_POST['submitEditAnnouncement'])){
    $text = str_replace("'","\'",$_POST['editAnnouncementText']);
    if(!changeData("UPDATE Announcements SET Message = '".$text."' WHERE AnnouncementID = ".$_POST['editAnnouncement'])){
        echo '<script>alert("Could not connect to database. Try again later!")</script>';}
    unset($_POST['submitEditAnnouncement']);
}
?>

<div class="pb-5 container">
    <div class="row">
        <div class=" col-xl-9 mx-auto">
            <div class="cta-inner text-center rounded">
                <h2 class="section-heading mb-5">
                    <span class="section-heading-upper">Admin Page</span>
                    <span class="section-heading-lower">Edit Announcement Text</span>
                </h2>
                <div class="card-body">
                    <form method="post" id = "editAnnouncement" action="index.php" onsubmit="return checkFormEditForm();">
                        <div id="SelectorAnnouncement">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label class="mb-1" for="inputGroupSelect01">Announcements</label>
                                    <select class="form-control custom-select" name="editAnnouncement" id="inputGroupSelect1">
                                        <option id="Select">Select</option>
                                        <?php
                                        $editAnnouncement = grabData("SELECT * FROM announcements");
                                        foreach ($editAnnouncement as $announcement) {
                                            ?>
                                            <option value = '<?php echo $announcement['AnnouncementID']?>'><?php echo "Title: ". $announcement['Title'] . "  || "."Start Date: " . $announcement['StartDate']. " ||  "."End Date: " . $announcement['EndDate']?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                <div id="selector_error" class ="text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="mb-1" for="editAnnouncementText">Announcement Text</label>
                                <textarea placeholder="Announcement Text" class = "form-control py-4" name="editAnnouncementText" id="editAnnouncementText" aria-label="With textarea" rows="10"></textarea>
                                <div id="editAnnouncement_Text_error" class ="text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                            <input class="btn btn-danger btn-xlonclick" type="reset" value="Reset">
                            <button name="submitEditAnnouncement" type="submit" class="btn btn-primary btn-xlonclick">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
