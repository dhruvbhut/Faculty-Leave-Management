<?php
session_start();
error_reporting(0);
include('../includes/dbconn.php');

if (strlen($_SESSION['emplogin']) == 0) {
    header('location:../index.php');
} else {

    // Fetch all pending transfer requests
    $sql = "SELECT * FROM class_transfers WHERE status = 'Pending'";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    // Handle Approve action
    if (isset($_POST['approve'])) {
        $id = $_POST['approve'];
        $sql = "UPDATE class_transfers SET status = 'Approved' WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        header('location:request-from-others.php');
    }

    // Handle Reject action
    if (isset($_POST['reject'])) {
        $id = $_POST['reject'];
        $sql = "UPDATE class_transfers SET status = 'Rejected' WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        header('location:request-from-others.php');
    }
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Faculty Timetable Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/metisMenu.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/css/slicknav.min.css">
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!-- Preloader Area Start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- Preloader Area End -->

    <!-- Page Container Area Start -->
    <div class="page-container">
        <!-- Sidebar Menu Area Start -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="timetable.php"><img src="logo.png" alt="logo"></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li class="#">
                                <a href="leave.php" aria-expanded="true"><i class="ti-user"></i><span>Apply Leave</span></a>
                            </li>
                            <li class="active">
                                <a href="timetable.php" aria-expanded="true"><i class="ti-calendar"></i><span>Timetable</span></a>
                            </li>
                            <li class="#">
                                    <a href="my-loadrequest.php" aria-expanded="true"><i class="ti-user"></i><span>My Load Transfer Request
                                        </span></a>
                                </li>
                                 <li class="#">
                                    <a href="loadrequests.php" aria-expanded="true"><i class="ti-user"></i><span> Load Transfer Requests
                                        </span></a>
                                </li>
                            <li class="#">
                                <a href="leave-history.php" aria-expanded="true"><i class="ti-agenda"></i><span>View My Leave History</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Sidebar Menu Area End -->

        <!-- Main Content Area Start -->
        <div class="main-content">
            <!-- Header Area Start -->
            <div class="header-area">
                <div class="row align-items-center">
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <li id="full-view"><i class="ti-fullscreen"></i></li>
                            <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Header Area End -->

            <!-- Page Title Area Start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Manage Timetable</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <?php include '../includes/employee-profile-section.php' ?>
                    </div>
                </div>
            </div>
            <!-- Page Title Area End -->

            <!-- Main Content Inner Start -->
            <div class="main-content-inner">
                <div class="row">
                    <div class="col-lg-12 col-ml-12">
                        <div class="row">
                            <div class="col-12 mt-5">
                                <!-- Timetable Table -->
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Your Timetable</h4>
                                        <p class="text-muted font-14 mb-4">Here is the timetable.</p>

                                        <!-- Timetable Data Table -->
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Period</th>
                                                    <th>Monday</th>
                                                    <th>Tuesday</th>
                                                    <th>Wednesday</th>
                                                    <th>Thursday</th>
                                                    <th>Friday</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Period 1 -->
                                                <tr>
                                                    <td>09:15 AM - 10:10 AM</td>
                                                    <td>Mathematics<br><small>Dr. Smith</small></td>
                                                    <td>Physics<br><small>Saurav Darji</small></td>
                                                    <td>Chemistry<br><small>Dr. Lee</small></td>
                                                    <td>Biology<br><small>Prof. White</small></td>
                                                    <td>Computer Science<br><small>Dr. Brown</small></td>
                                                </tr>
                                                <!-- Period 2 -->
                                                <tr>
                                                    <td>10:15 AM - 11:10 AM</td>
                                                    <td>English<br><small>Ms. Parker</small></td>
                                                    <td>Mathematics<br><small>Dr. Green</small></td>
                                                    <td>Physics<br><small>Saurav Darji</small></td>
                                                    <td>Chemistry<br><small>Dr. Davis</small></td>
                                                    <td>Mathematics<br><small>Dr. Thomas</small></td>
                                                </tr>
                                                <!-- Short Break -->
                                                <tr>
                                                    <td><b>Break</b></td>
                                                    <td><b>Short Break</b></td>
                                                    <td><b>Short Break</b></td>
                                                    <td><b>Short Break</b></td>
                                                    <td><b>Short Break</b></td>
                                                    <td><b>Short Break</b></td>
                                                </tr>
                                                <!-- Period 3 -->
                                                <tr>
                                                    <td>11:30 AM - 12:25 PM</td>
                                                    <td>History<br><small>Mr. Taylor</small></td>
                                                    <td>Computer Science<br><small>Dr. Miller</small></td>
                                                    <td>English<br><small>Ms. Walker</small></td>
                                                    <td>Physics<br><small>Saurav Darji</small></td>
                                                    <td>English<br><small>Mr. Allen</small></td>
                                                </tr>
                                                <!-- Period 4 -->
                                                <tr>
                                                    <td>12:30 PM - 01:25 PM</td>
                                                    <td>Geography<br><small>Prof. Adams</small></td>
                                                    <td>History<br><small>Mr. Carter</small></td>
                                                    <td>Geography<br><small>Prof. Turner</small></td>
                                                    <td>Computer Science<br><small>Dr. Mitchell</small></td>
                                                    <td>History<br><small>Mr. Young</small></td>
                                                </tr>
                                                <!-- Long Break -->
                                                <tr>
                                                    <td><b>Break</b></td>
                                                    <td><b>Long Break</b></td>
                                                    <td><b>Long Break</b></td>
                                                    <td><b>Long Break</b></td>
                                                    <td><b>Long Break</b></td>
                                                    <td><b>Long Break</b></td>
                                                </tr>
                                                <!-- Period 5 -->
                                                <tr>
                                                    <td>01:40 PM - 02:35 PM</td>
                                                    <td>Computer Science<br><small>Dr. Scott</small></td>
                                                    <td>History<br><small>Mr. Young</small></td>
                                                    <td>Geography<br><small>Prof. Carter</small></td>
                                                    <td>Biology<br><small>Dr. Robinson</small></td>
                                                    <td>Computer Science<br><small>Dr. Mitchell</small></td>
                                                </tr>
                                                <!-- Period 6 -->
                                                <tr>
                                                    <td>02:40 PM - 03:35 PM</td>
                                                    <td>Physics<br><small>Saurav Darji</small></td>
                                                    <td>Biology<br><small>Dr. Oliver</small></td>
                                                    <td>Chemistry<br><small>Prof. Williams</small></td>
                                                    <td>History<br><small>Mr. Carter</small></td>
                                                    <td>Geography<br><small>Prof. Jackson</small></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main Content Inner End -->
        </div>
        <!-- Main Content Area End -->

        <!-- Footer Area Start-->
        <?php include '../includes/footer.php' ?>
        <!-- Footer Area End-->
    </div>
    <!-- Page Container Area End -->

    <!-- jQuery -->
    <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/owl.carousel.min.js"></script>
    <script src="../assets/js/metisMenu.min.js"></script>
    <script src="../assets/js/jquery.slimscroll.min.js"></script>
    <script src="../assets/js/jquery.slicknav.min.js"></script>

    <!-- Other Plugins -->
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/scripts.js"></script>
</body>

</html>

<?php } ?>
