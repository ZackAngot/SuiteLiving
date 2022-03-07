<?php
if(isset($_POST['removeAnnouncement'])){
    changeData("DELETE FROM Announcements WHERE announcementID = ".$_POST['removeAnnouncement']);
    unset($_POST['removeAnnouncement']);
}
?>
<div class="p-5 mx-auto">
    <div class="mb-4 shadow-lg bg-faded rounded">
        <h2 class="bg-primary card-header section-heading text-center mb-5">
            <span class="fas fa-table mr-1"></span>
            <span class="section-heading-lower">Delete Announcements</span>
        </h2>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr class = "bg-primary">
                        <th>Title</th>
                        <th>Message</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Remove Announcement</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr class = "bg-primary">
                        <th>Title</th>
                        <th>Message</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Remove Announcement</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                    $output ="";
                    $staffData = grabData("SELECT * FROM announcements");
                    foreach ($staffData as $Data) {
                        $output= "
                                                <tr id = ".json_encode($Data['AnnouncementID']).">
                                                <td>Title: ".$Data['Title']."</td>
                                                <td>Message: ".$Data['Message']."</td>
                                                <td>Start Date: ".$Data['StartDate']."</td>
                                                <td>End Date: ".$Data['EndDate']."</td>
                                                <td><p onclick = 'removeAnnouncement(".json_encode($Data['AnnouncementID']). ")' class ='btn btn-primary btn-xlonclick'>Remove Announcement</p></td>";

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