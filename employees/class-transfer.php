<?php
session_start();
error_reporting(0);
include('../includes/dbconn.php');
include('../path/to/timetable.php'); // Adjust path to actual timetable.php location

// Redirect to login if not logged in
if (!isset($_SESSION['emplogin']) || strlen($_SESSION['emplogin']) == 0) {
    header('location:../index.php');
    exit;
} else {
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Request Class Transfer</title>
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
            color: #fff;
            border-radius: 20px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .tab-btn.active, .tab-btn:hover {
            background: blue;
        }
        .form-control, .select {
            max-width: 600px;
            width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        .transfer-button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        .transfer-button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="page-container">
        <!-- Sidebar Menu -->
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
                            <li><a href="leave.php" aria-expanded="true"><i class="ti-user"></i><span>Apply Leave</span></a></li>
                            <li><a href="timetable.php" aria-expanded="true"><i class="ti-calendar"></i><span>Timetable</span></a></li>
                            <li class="active"><a href="class-transfer.php" aria-expanded="true"><i class="ti-user"></i><span>Class Transfer</span></a></li>
                            <li><a href="leave-history.php" aria-expanded="true"><i class="ti-agenda"></i><span>View My Leave History</span></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <div class="main-content">
            <!-- Page Title Area -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Request Class Transfer</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><span>Class Transfer Form</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <?php include '../includes/employee-profile-section.php'; ?>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="main-content-inner">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Tab Buttons -->
                        <div class="mb-4">
                            <a href="class-transfer.php" class="tab-btn active">Request to Transfer</a>
                            <a href="my-transfer-requests.php" class="tab-btn">My Transfer Requests</a>
                            <a href="request-from-others.php" class="tab-btn">Request from Other</a>
                        </div>

                        <!-- Date Selection with Validation -->
                        <label for="selectDate">Select Date:</label>
                        <input type="date" id="selectDate">

                        <!-- Transfer Table -->
                        <table>
                            <thead>
                                <tr>
                                    <th>Day & Time</th>
                                    <th>Course/Subject</th>
                                    <th>Transfer To</th>
                                    <th>Transfer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Monday<br> 09:15 AM - 10:10 AM</td>
                                    <td>Mathematics</td>
                                    <td>
                                        <select onchange="loadAvailableFaculties(this, '09:15 AM - 10:10 AM')">
                                            <option value="">Select Faculty</option>
                                            <option value="1">Dr. Smith (Mathematics)</option>
                                            <option value="2">Ms. Parker (English)</option>
                                            <option value="3">Mr. Taylor (History)</option>
                                            <option value="4">Prof. Adams (Geography)</option>
                                            <option value="5">Dr. Scott (Computer Science)</option>
                                        </select>
                                    </td>
                                    <td><button class="transfer-button">Transfer</button></td>
                                </tr>
                                <tr>
                                    <td>Monday <br> 02:40 PM - 03:35 PM</td>
                                    <td>Physics</td>
                                    <td>
                                        <select onchange="loadAvailableFaculties(this, '02:40 PM - 03:35 PM')">
                                            <option value="">Select Faculty</option>
                                            <option value="1">Dr. Smith (Mathematics)</option>
                                            <option value="2">Ms. Parker (English)</option>
                                            <option value="3">Mr. Taylor (History)</option>
                                            <option value="4">Prof. Adams (Geography)</option>
                                            <option value="5">Dr. Scott (Computer Science)</option>
                                        </select>
                                    </td>
                                    <td><button class="transfer-button">Transfer</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <!-- JavaScript Libraries -->
    <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/owl.carousel.min.js"></script>
    <script src="../assets/js/metisMenu.min.js"></script>
    <script src="../assets/js/jquery.slimscroll.min.js"></script>
    <script src="../assets/js/jquery.slicknav.min.js"></script>
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/scripts.js"></script>

    <script>
        // Set the minimum date to today's date
        document.addEventListener("DOMContentLoaded", function () {
            const selectDate = document.getElementById("selectDate");
            const today = new Date().toISOString().split("T")[0];
            selectDate.min = today;
        });
    </script>
</body>
</html>

<?php } ?>
