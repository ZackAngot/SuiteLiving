<?php
session_start();
include 'src/php/functions.php';
//=============================================================================================
$displayForm = true;
$startDate = "";
$startDateError = "";
$endDate = "";
$endDateError = "";
$issue = "";
$issueError = "";
$pieData = "";
$pieLabel = "";
$barData = "";
$barLabel = "";
//=============================================================================================
if (isset($_POST['submit'])) {
    unset($_POST['submit']);
    $startDate = $_POST['ReportStartDate'];
    if (empty($startDate))
        $startDateError = "start Date is required";

    $endDate = $_POST['ReportEndDate'];
    if (empty($endDate))
        $endDateError = "End Date is required";

    if (empty($startDateError) & empty($endDateError)) {
        $displayForm = false;

        $typeData = grabData("SELECT IssueType, COUNT(*) AS Count FROM MaintenanceTicket WHERE DateSubmitted BETWEEN '$startDate' AND '$endDate' GROUP BY IssueType ORDER BY IssueType");
        foreach ($typeData as $data) {
            if (empty($pieData)){
                $pieData.= $data['Count'];
            } else {
                $pieData.=",".$data['Count'];
            }
            if (empty($pieLabel)){
                $pieLabel.="'".$data['IssueType']."'";
            } else {
                $pieLabel.=",'".$data['IssueType']."'";
            }
        }

        $locationData = grabData("SELECT Location, COUNT(*) AS Count FROM MaintenanceTicket WHERE DateSubmitted BETWEEN '$startDate' AND '$endDate'GROUP BY Location");
        $maxCount = 0;
        foreach ($locationData as $data) {
            $maxCount = max($maxCount, $data['Count']);
            if (empty($barData)){
                $barData.= $data['Count'];
            } else {
                $barData.=",".$data['Count'];
            }
            if (empty($barLabel)){
                $barLabel.="'".$data['Location']."'";
            } else {
                $barLabel.=",'".$data['Location']."'";
            }
        }
    }
}
//=============================================================================================
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Suite Living</title>
    <!-- Bootstrap core CSS -->
    <link href="src/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="src/css/business-casual.css" rel="stylesheet">

<!--    head info for charts-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body>

<h1 class="d-print-none site-heading text-center text-white d-none d-lg-block">
    <span class="site-heading-lower" id="suiteHead" name="home.html">Suite Living</span>
    <span class="site-heading-upper text-primary mb-3">Living Defined by You</span>
</h1>

<nav class="d-print-none navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
    <div class="container">
        <a class="navbar-brand text-expanded text-white d-lg-none" href="javascript:void(0);" name="home.html" id="cellTitle">Suite Living</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mx-auto">
                <?php
                if ($_SESSION["type"] == null) {
                    include "src/html/gNav.html";
                } else {
                    switch ($_SESSION["type"]) {
                        case "R":
                            include "src/html/rNav.html";
                            break;
                        case "A":
                            include "src/html/aNav.html";
                            break;
                        case "M":
                            include "src/html/mNav.html";
                            break;
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<script>
    document.getElementById('homeBut').classList.remove('active');
    document.getElementById('report').classList.add('active');
</script>

<section class="d-print-none">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-4 mb-4">
            <a href="messenger.php"><button type="button" class="btn btn-primary btn-lg">Message a Resident</button></a>
            <?php
            if($_SESSION['type'] == null) {
                echo "<a href='login.php'><button type='button' class='btn btn-primary btn-lg'>Login</button></a>";
            } else {
                echo "<a href='signout.php'><button type='button' class='btn btn-primary btn-lg'>Sign out</button></a>";
            }
            ?>
        </div>
    </div>
</section>

<?php
if ($displayForm) {
?>
<section class="d-print-none cta">
    <div class="container">
        <div class="row">
            <div class=" col-xl-9 mx-auto">
                <div class="cta-inner  text-center rounded">
                    <h2 class="section-heading mb-5">
                        <span class="section-heading-upper">Suite Living</span>
                        <span class="section-heading-lower">Maintenance Report</span>
                    </h2>
                    <div class="card-body">
                        <form method="post" action="report.php">
                            <div class="form-group">
                                <label class="small mb-1"> Start Date:</label>
                                <input class="form-control py-4" type="date" name="ReportStartDate" value="<?php echo $startDate?>">
                                <label class="text-danger"> <?php echo $startDateError?></label>
                            </div>
                            <div class="form-group">
                                <label class="small mb-1"> End Date: </label>
                                <input class="form-control py-4" type="date" name="ReportEndDate" value="<?php echo $endDate?>">
                                <label class="text-danger"> <?php echo $endDateError?></label>
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                <input class = "btn btn-primary btn-xlonclick" type="submit" id="submit" name="submit" value="Generate Report" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
} else {
?>
    <main class="cta">
        <div class="container-fluid mb-4 text-center">
            <span class = 'd-print-none btn btn-primary btn-xlonclick' onclick = 'window.print();'>Print Report</span>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="bg-faded rounded mb-4">
                        <div class="card-header bg-primary">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Number of Tickets Per Location
                        </div>
                        <div class="card-body"><canvas id="myBarChart" width="100%" height="50"></canvas></div>
                        <div class="bg-primary card-footer">Ticket Location Breakdown</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bg-faded rounded mb-4">
                        <div class="card-header bg-primary">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Number of Tickets Per Department
                        </div>
                        <div class="card-body"><canvas id="myPieChart" width="100%" height="50"></canvas></div>
                        <div class="bg-primary card-footer">Ticket Department Breakdown</div>
                    </div>
                </div>
            </div>
            <div class="bg-faded mb-4 rounded">
                <h2 class="bg-primary card-header section-heading text-center mb-5">
                    <i class="fas fa-table mr-1"></i>
                    <span class="section-heading-upper">Ticket History</span>
                    <span class=" section-heading-lower">Completed Tickets</span>
                </h2>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr class = "bg-primary">
                                <th>Ticket Number</th>
                                <th>Type of Issue</th>
                                <th>Location</th>
                                <th>Description</th>
                                <th>Submission Date</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr class = "bg-primary">
                                <th>Ticket Number</th>
                                <th>Type of Issue</th>
                                <th>Location</th>
                                <th>Description</th>
                                <th>Submission Date</th>
                            </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $output ="";
                                $ReportInfo = grabData("SELECT * FROM maintenanceticket WHERE DateSubmitted BETWEEN '" . $startDate . "' AND  '" . $endDate . "' AND Status = 'Complete' ORDER BY TicketID DESC");
                                foreach ($ReportInfo as $Data) {
                                    $output= "
                                <tr>
                                    <td>T".$Data['TicketID']."</td>
                                    <td>".$Data['IssueType']."</td>
                                    <td>".$Data['Location']."</td>
                                    <td>".$Data['Description']."</td>
                                    <td>".$Data['DateSubmitted']."</td>";
                                    $output.="</tr>";
                                    echo $output;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="bg-faded mb-4 rounded">
                <h2 class="bg-primary card-header section-heading text-center mb-5">
                    <i class="fas fa-table mr-1"></i>
                    <span class="section-heading-upper">Ticket History</span>
                    <span class=" section-heading-lower">In Progress Tickets</span>
                </h2>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr class = "bg-primary">
                                <th>Ticket Number</th>
                                <th>Type of Issue</th>
                                <th>Location</th>
                                <th>Description</th>
                                <th>Submission Date</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr class = "bg-primary">
                                <th>Ticket Number</th>
                                <th>Type of Issue</th>
                                <th>Location</th>
                                <th>Description</th>
                                <th>Submission Date</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php
                            $output ="";
                            $ReportInfo = grabData("SELECT * FROM maintenanceticket WHERE DateSubmitted BETWEEN '" . $startDate . "' AND  '" . $endDate . "' AND Status = 'In Progress' ORDER BY TicketID DESC");
                            foreach ($ReportInfo as $Data) {
                                $output= "
                                <tr>
                                    <td>T".$Data['TicketID']."</td>
                                    <td>".$Data['IssueType']."</td>
                                    <td>".$Data['Location']."</td>
                                    <td>".$Data['Description']."</td>
                                    <td>".$Data['DateSubmitted']."</td>";
                                $output.="</tr>";
                                echo $output;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="bg-faded mb-4 rounded">
                <h2 class="bg-primary card-header section-heading text-center mb-5">
                    <i class="fas fa-table mr-1"></i>
                    <span class="section-heading-upper">Ticket History</span>
                    <span class=" section-heading-lower">Unassigned Tickets</span>
                </h2>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr class = "bg-primary">
                                <th>Ticket Number</th>
                                <th>Type of Issue</th>
                                <th>Location</th>
                                <th>Description</th>
                                <th>Submission Date</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr class = "bg-primary">
                                <th>Ticket Number</th>
                                <th>Type of Issue</th>
                                <th>Location</th>
                                <th>Description</th>
                                <th>Submission Date</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php
                            $output ="";
                            $ReportInfo = grabData("SELECT * FROM maintenanceticket WHERE DateSubmitted BETWEEN '" . $startDate . "' AND  '" . $endDate . "' AND Status = 'Unassigned' ORDER BY TicketID DESC");
                            foreach ($ReportInfo as $Data) {
                                $output= "
                                <tr>
                                    <td>T".$Data['TicketID']."</td>
                                    <td>".$Data['IssueType']."</td>
                                    <td>".$Data['Location']."</td>
                                    <td>".$Data['Description']."</td>
                                    <td>".$Data['DateSubmitted']."</td>";
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
    </main>
<?php
}
?>
<footer class="d-print-none footer text-faded text-center py-5">
    <div class="container">
        <p class="m-0 small">Developed by Students of Indiana University Kokomo</p>
    </div>
</footer>

<!-- Bootstrap core JavaScript -->
<script src="src/vendor/jquery/jquery.min.js"></script>
<script src="src/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<?php
if (!$displayForm) {

    echo "
<script src='https://code.jquery.com/jquery-3.5.1.slim.min.js' crossorigin='anonymous'></script>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js' crossorigin='anonymous'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js' crossorigin='anonymous'></script>
<script>
    var ctx = document.getElementById('myBarChart');
    let graphLabel;
    var myLineChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [$barLabel],
            datasets: [{
                label: 'Tickets',
                backgroundColor: 'rgba(2,117,216,1)',
                borderColor: 'rgba(2,117,216,1)',
                data: [$barData],
            }],
        },
        options: {
            scales: {
                xAxes: [{
                    time: {
                        unit: 'Locations'
                    },
                    gridLines: {
                        display: false
                    },
                    ticks: {
                        maxTicksLimit: 10
                    }
                }],
                yAxes: [{
                    ticks: {
                        min: 0,
                        max: $maxCount + (10 - ($maxCount%10)),
                        maxTicksLimit:($maxCount + (10 - ($maxCount%10)))/10
                    },
                    gridLines: {
                        display: true
                    }
                }],
            },
            legend: {
                display: false
            }
        }
    });
</script>
<script>
    var ctx = document.getElementById('myPieChart');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: [$pieLabel],
            datasets: [{
                data: [$pieData],
                backgroundColor: ['#dc3545', '#ffc107', '#28a745', '#007bff'],
            }],
        },
    });
</script>";
}
?>
</body>
</html>