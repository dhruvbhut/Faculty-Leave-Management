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
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Request from Others</title>
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
        <style>
            .tab-btn {
                display: inline-block;
                margin-right: 10px;
                padding: 10px 20px;
                background: purple;
                /* Change to purple */
                color: #fff;
                /* Text color remains white */
                border-radius: 20px;
                /* Cylindrical shape */
                text-decoration: none;
                transition: background 0.3s;
                /* Transition effect */
            }

            .tab-btn.active {
                background: purple;
                /* Active button color changed to purple */
            }

            .tab-btn:hover {
                background: blue;
                /* Change to blue on hover for all buttons */
                color: #fff;
                /* Ensure text stays white on hover */
            }

            .tab-btn.active:hover {
                background: blue;
                /* Active button changes to blue on hover */
            }
        </style>
    </head>

    <body>
        <div id="preloader">
            <div class="loader"></div>
        </div>

        <div class="page-container">
            <div class="sidebar-menu">
                <div class="sidebar-header">
                    <div class="logo">
                        <a href="class-transfer.php"><img src="logo.png" alt="logo"></a>
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
                                    <a href="class-transfer.php" aria-expanded="true"><i class="ti-user"></i><span>Class Transfer
                                        </span></a>
                                </li>

                                <li class="#">
                                    <a href="leave-history.php" aria-expanded="true"><i class="ti-agenda"></i><span>View My Leave History
                                        </span></a>
                                </li>

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="main-content">
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

                <div class="page-title-area">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <div class="breadcrumbs-area clearfix">
                                <h4 class="page-title pull-left">Class Transfer</h4>
                                <ul class="breadcrumbs pull-left">
                                    <li><span>Request from Others</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6 clearfix">
                            <?php include '../includes/employee-profile-section.php'; ?>
                        </div>
                    </div>
                </div>

                <div class="main-content-inner">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Tab Buttons -->
                            <div class="mb-4">
                                <a href="class-transfer.php" class="tab-btn">Request to Transfer</a>
                                <a href="my-transfer-requests.php" class="tab-btn">My Transfer Requests</a>
                                <a href="request-from-others.php" class="tab-btn active">Request from Others</a>
                            </div>

                            <!-- Display Requests from Others -->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Class Transfer Requests from Others</h4>
                                    <p class="text-muted font-14 mb-4">Below is the list of class transfer requests from other employees.</p>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Employee ID</th>
                                                <th>Current Class</th>
                                                <th>Desired Class</th>
                                                <th>Reason</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) { ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($cnt); ?></td>
                                                        <td><?php echo htmlentities($result->empid); ?></td>
                                                        <td><?php echo htmlentities($result->current_class); ?></td>
                                                        <td><?php echo htmlentities($result->desired_class); ?></td>
                                                        <td><?php echo htmlentities($result->reason); ?></td>
                                                        <td>
                                                            <form method="post">
                                                                <button type="submit" name="approve" value="<?php echo $result->id; ?>" class="btn btn-success">Approve</button>
                                                                <button type="submit" name="reject" value="<?php echo $result->id; ?>" class="btn btn-danger">Reject</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php $cnt++;
                                                }
                                            } else { ?>
                                                <tr>
                                                    <td colspan="6">No requests found</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include '../includes/footer.php'; ?>
        </div>

        <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
        <script src="../assets/js/popper.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/owl.carousel.min.js"></script>
        <script src="../assets/js/metisMenu.min.js"></script>
        <script src="../assets/js/jquery.slimscroll.min.js"></script>
        <script src="../assets/js/jquery.slicknav.min.js"></script>
        <script src="../assets/js/plugins.js"></script>
        <script src="../assets/js/scripts.js"></script>
    </body>

    </html>

<?php } ?>