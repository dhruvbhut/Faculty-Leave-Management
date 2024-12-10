<?php

session_start();
error_reporting(0);
include('includes/dbconn.php');

if (strlen($_SESSION['emplogin']) == 0) {
    header('location:../index.php');
} else {

?>

    <!doctype html>
    <html class="no-js" lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Employee Leave Management System</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="../assets/css/themify-icons.css">
        <link rel="stylesheet" href="../assets/css/metisMenu.css">
        <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="../assets/css/slicknav.min.css">
        <!-- amchart css -->
        <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
        <!-- Start datatable css -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
        <!-- others css -->
        <link rel="stylesheet" href="../assets/css/typography.css">
        <link rel="stylesheet" href="../assets/css/default-css.css">
        <link rel="stylesheet" href="../assets/css/styles.css">
        <link rel="stylesheet" href="../assets/css/responsive.css">
        <!-- modernizr css -->
        <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
    </head>

    <body>
        <!-- preloader area start -->
        <div id="preloader">
            <div class="loader"></div>
        </div>
        <!-- preloader area end -->
        <!-- page container area start -->
        <div class="page-container">
            <!-- sidebar menu area start -->
            <div class="sidebar-menu">
                <div class="sidebar-header">
                    <div class="logo">
                        <a href="leave.php"><img src="logo.png" alt="logo"></a>
                    </div>
                </div>
                <div class="main-menu">
                    <div class="menu-inner">
                        <nav>
                            <ul class="metismenu" id="menu">

                                <li class="#">
                                    <a href="leave.php" aria-expanded="true"><i class="ti-user"></i><span>Apply Leave
                                        </span></a>
                                </li>

                                <li class="#">
                                    <a href="timetable.php" aria-expanded="true"><i class="ti-calendar"></i><span>Timetable</span></a>
                                </li>

                                <li class="active">
                                    <a href="my-loadrequest.php" aria-expanded="true"><i class="ti-user"></i><span>My Load Transfer Request
                                        </span></a>
                                </li>
                                 <li class="#">
                                    <a href="loadrequests.php" aria-expanded="true"><i class="ti-user"></i><span> Load Transfer Requests
                                        </span></a>
                                </li>

                                <li >
                                    <a href="leave-history.php" aria-expanded="true"><i class="ti-agenda"></i><span>View My Leave History
                                        </span></a>
                                </li>

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- sidebar menu area end -->
            <!-- main content area start -->
            <div class="main-content">
                <!-- header area start -->
                <div class="header-area">
                    <div class="row align-items-center">
                        <!-- nav and search button -->
                        <div class="col-md-6 col-sm-8 clearfix">
                            <div class="nav-btn pull-left">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>

                        </div>
                        <!-- profile info & task notification -->
                        <div class="col-md-6 col-sm-4 clearfix">
                            <ul class="notification-area pull-right">
                                <li id="full-view"><i class="ti-fullscreen"></i></li>
                                <li id="full-view-exit"><i class="ti-zoom-out"></i></li>



                            </ul>
                        </div>
                    </div>
                </div>
                <!-- header area end -->
                <!-- page title area start -->
                <div class="page-title-area">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <div class="breadcrumbs-area clearfix">
                                <h4 class="page-title pull-left">My Load Transfer Requests</h4>
                            </div>
                        </div>
                        <div class="col-sm-6 clearfix">
                            <?php include '../includes/employee-profile-section.php' ?>
                        </div>
                    </div>
                </div>
                <!-- page title area end -->
                <div class="main-content-inner">
                    <div class="row">
                        <!-- data table start -->
                        <div class="col-12 mt-5">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">My Load Transfer Request</h4>
                                    <?php if ($error) { ?><div class="alert alert-danger alert-dismissible fade show"><strong>Info: </strong><?php echo htmlentities($error); ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>

                                        </div><?php } else if ($msg) { ?><div class="alert alert-success alert-dismissible fade show"><strong>Info: </strong><?php echo htmlentities($msg); ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div><?php } ?>
                                    <div class="data-tables">
                                        <table id="dataTable" class="table table-hover progress-table text-center">
                                            <thead class="bg-light text-capitalize">
    <tr>
        <th>#</th>
        <th>Faculty To</th>
        <th>Subject</th>
        <th>Transfer Date</th>
        <th>Time Slot</th>
        <th>Faculty's Remark</th>
        <th>Status</th>
    </tr>
</thead>
<tbody>
    <?php
    $eid = $_SESSION['eid'];
    
    // Fetching data from tblloadtransfer table
    $sql = "SELECT faculty_to, subject, transfer_date, time_slot, status FROM tblloadtransfer WHERE faculty_from = :eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;
    
    function getEmployeeName($dbh, $facultyToId) {
    $sql = "SELECT FirstName, LastName FROM tblemployees WHERE id = :facultyToId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':facultyToId', $facultyToId, PDO::PARAM_INT);
    $query->execute();
    $employee = $query->fetch(PDO::FETCH_OBJ);
    return $employee ? $employee->FirstName . ' ' . $employee->LastName : 'Unknown';
}

    if ($query->rowCount() > 0) {
        foreach ($results as $result) {  

            $employeeName = getEmployeeName($dbh, $result->faculty_to);


?>
            <tr>
                <td> <?php echo htmlentities($cnt); ?></td>
                <td><?php echo htmlentities($employeeName); ?></td>
                <td><?php echo htmlentities($result->subject); ?></td>
                <td><?php echo htmlentities($result->transfer_date); ?></td>
                <td><?php echo htmlentities($result->time_slot); ?></td>
                <td><?php echo htmlentities('No remarks'); ?></td>
                <td> 
                    <?php 
                    $status = $result->status;
                    if ($status == 1) { ?>
                        <span style="color: green">Accepted</span>
                    <?php } elseif ($status == 2) { ?>
                        <span style="color: red">Declined</span>
                    <?php } elseif ($status == 0) { ?>
                        <span style="color: blue">Pending</span>
                    <?php } ?>
                </td>
            </tr>
    <?php 
            $cnt++;
        }
    } else {
        echo "<tr><td colspan='7'>No transfer requests found.</td></tr>";
    }
    ?>
</tbody>


                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- data table end -->
                    </div>
                </div>
            </div>
            <!-- main content area end -->
            <!-- footer area start-->
            <?php include '../includes/footer.php' ?>
            <!-- footer area end-->
        </div>
        <!-- page container area end -->
        <!-- offset area start -->
        <div class="offset-area">
            <div class="offset-close"><i class="ti-close"></i></div>


        </div>
        <!-- offset area end -->
        <!-- jquery latest version -->
        <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
        <!-- bootstrap 4 js -->
        <script src="../assets/js/popper.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/owl.carousel.min.js"></script>
        <script src="../assets/js/metisMenu.min.js"></script>
        <script src="../assets/js/jquery.slimscroll.min.js"></script>
        <script src="../assets/js/jquery.slicknav.min.js"></script>

        <!-- Start datatable js -->
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
        <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

        <!-- others plugins -->
        <script src="../assets/js/plugins.js"></script>
        <script src="../assets/js/scripts.js"></script>
    </body>

    </html>

<?php } ?>