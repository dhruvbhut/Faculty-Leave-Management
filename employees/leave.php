<?php
    session_start();
    error_reporting(1);
    include('../includes/dbconn.php');
    if(strlen($_SESSION['emplogin'])==0)
        {   
    header('location:../index.php');
    }   else    {

// Get the employee's ID from the session
$empid = $_SESSION['eid']; 

// Get leave request details from the form
$fromdate = $_POST['fromdate'];  
$todate = $_POST['todate'];

// Prepare the query to check if the employee has transferred the load in the specified date range
$sqlLoadTransfer = "
    SELECT 
        subject, 
        faculty_to, 
        transfer_date,
        time_slot 
    FROM tblloadtransfer 
    WHERE 
        faculty_from = :faculty_from 
        AND status = 1
        AND transfer_date BETWEEN :from_date AND :to_date";

$queryLoadTransfer = $dbh->prepare($sqlLoadTransfer);
$queryLoadTransfer->bindParam(':faculty_from', $empid, PDO::PARAM_INT);
$queryLoadTransfer->bindParam(':from_date', $fromdate, PDO::PARAM_STR);
$queryLoadTransfer->bindParam(':to_date', $todate, PDO::PARAM_STR);
$queryLoadTransfer->execute();
$loadTransfers = $queryLoadTransfer->fetchAll(PDO::FETCH_OBJ);

// Check if the load has been transferred during the requested leave period
if (empty($loadTransfers)) {
    // If no transfer has occurred, show the message
    $msg = "Please transfer your load to another faculty member before making a leave request.";
} else {

    // Proceed with leave application if the load has been transferred
    if (isset($_POST['apply'])) {
        // Get leave details from the form
        $leavetype = $_POST['leavetype'];
        $description = $_POST['description'];  
        $status = 0;
        $isread = 0;

        // Check if the from date is greater than to date
        if ($fromdate > $todate) {
            $error = "Please enter correct details: End Date should be ahead of Start Date in order to be valid!";
        } else {
            // Insert the leave request into the database
            $sql = "INSERT INTO tblleaves(LeaveType, ToDate, FromDate, Description, Status, IsRead, empid) 
                    VALUES(:leavetype, :fromdate, :todate, :description, :status, :isread, :empid)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':leavetype', $leavetype, PDO::PARAM_STR);
            $query->bindParam(':todate', $todate, PDO::PARAM_STR);
            $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
            $query->bindParam(':description', $description, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_STR);
            $query->bindParam(':isread', $isread, PDO::PARAM_STR);
            $query->bindParam(':empid', $empid, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();

            if ($lastInsertId) {
                $msg = "Your leave application has been applied. Thank You.";
            } else {
                $error = "Sorry, could not process this time. Please try again later.";
            }
        }
    }
}


        /*if(isset($_POST['apply']))
        {

        $empid=$_SESSION['eid'];
        $leavetype=$_POST['leavetype'];
        $fromdate=$_POST['fromdate'];  
        $todate=$_POST['todate'];
        $description=$_POST['description'];  
        $status=0;
        $isread=0;

        if($fromdate > $todate){
            $error=" Please enter correct details: End Data should be ahead of Starting Date in order to be valid! ";
            }

        $sql="INSERT INTO tblleaves(LeaveType,ToDate,FromDate,Description,Status,IsRead,empid) VALUES(:leavetype,:fromdate,:todate,:description,:status,:isread,:empid)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':leavetype',$leavetype,PDO::PARAM_STR);
        $query->bindParam(':todate',$todate,PDO::PARAM_STR);
        $query->bindParam(':fromdate',$fromdate,PDO::PARAM_STR);
        $query->bindParam(':description',$description,PDO::PARAM_STR);
        $query->bindParam(':status',$status,PDO::PARAM_STR);
        $query->bindParam(':isread',$isread,PDO::PARAM_STR);
        $query->bindParam(':empid',$empid,PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        if($lastInsertId)
        {
             $msg="Your leave application has been applied, Thank You.";
        }   else    {
            $error="Sorry, couldnot process this time. Please try again later.";
        }
    }
*/
    // Process load transfer
    if(isset($_POST['transfer_submit'])) {
        $empid = $_SESSION['eid'];
        $transfer_faculty = $_POST['transfer_faculty'];
        $transfer_date = $_POST['transfer_date'];
        $time_slot = $_POST['time_slot'];
        $subject = $_POST['subject'];
        $remarks = $_POST['message'];
        $status = 0; // 0=pending

        $sql = "INSERT INTO tblloadtransfer(faculty_from, faculty_to, transfer_date, time_slot,subject,remarks, status) 
                VALUES(:faculty_from, :faculty_to, :transfer_date, :time_slot,:subject,:remarks, :status)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':faculty_from', $empid, PDO::PARAM_STR);
        $query->bindParam(':faculty_to', $transfer_faculty, PDO::PARAM_STR);
        $query->bindParam(':transfer_date', $transfer_date, PDO::PARAM_STR);
        $query->bindParam(':time_slot', $time_slot, PDO::PARAM_STR);
         $query->bindParam(':subject', $subject, PDO::PARAM_STR);
         $query->bindParam(':remarks', $remarks, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_INT);

        if($query->execute()) {
            $msg = "Load transfer request submitted successfully.";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
    ?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Faculty Leave Management System</title>
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
    <!-- others css -->
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <style type="text/css">
       

    </style>
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

                            <li class="active">
                                <a href="leave.php" aria-expanded="true"><i class="ti-user"></i><span>Apply Leave
                                    </span></a>
                            </li>
                            
                            <li class="#">
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
                            <h4 class="page-title pull-left">Apply For Leave Days</h4>
                            <ul class="breadcrumbs pull-left">
                                
                                <li><span>Leave Form</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                            
                            <?php include '../includes/employee-profile-section.php'?>

                    </div>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                <div class="row">
                    <div class="col-lg-6 col-ml-12">
                        <div class="row">
                            <!-- Textual inputs start -->
                            <div class="col-12 mt-5">
                            <?php if($error){?><div class="alert alert-danger alert-dismissible fade show"><strong>Info: </strong><?php echo htmlentities($error); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            
                             </div><?php } 
                                 else if($msg){?><div class="alert alert-success alert-dismissible fade show"><strong>Info: </strong><?php echo htmlentities($msg); ?> 
                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                 </div><?php }?>
                                <div class="card">
                                <form name="addemp" method="POST">

                                    <div class="card-body">
                                        <h4 class="header-title">Faculty Leave Form</h4>
                                        <p class="text-muted font-14 mb-4">Please fill up the form below.</p>

                                        <div class="form-group">
                                            <label for="example-date-input" class="col-form-label">Starting Date</label>
                                 <input class="form-control" type="date"  data-inputmask="'alias': 'date'" required id="datePicker" name="fromdate" >
                                        </div>

                                        <div class="form-group">
                                            <label for="example-date-input" class="col-form-label">End Date</label>
                                            <input class="form-control dates" type="date" data-inputmask="'alias': 'date'" required id="date" name="todate" >
                                        </div>

                                        <div class="form-group">
                                            <label class="col-form-label">Your Leave Type</label>
                                            <select class="custom-select" name="leavetype" autocomplete="off">
                                                <option value="">Click here to select any ...</option>

                                                <?php $sql = "SELECT LeaveType from tblleavetype";
                                                    $query = $dbh -> prepare($sql);
                                                    $query->execute();
                                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                    $cnt=1;
                                                    if($query->rowCount() > 0) {
                                                        foreach($results as $result)
                                                {   ?> 
                                                <option value="<?php echo htmlentities($result->LeaveType);?>"><?php echo htmlentities($result->LeaveType);?></option>
                                                <?php }
                                            } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Describe Your Conditions</label>
                                            <textarea class="form-control" name="description" type="text" name="description" length="400" id="example-text-input" rows="5"></textarea>
                                        </div>

                                        <button class="btn btn-primary" name="apply" id="apply" type="submit">SUBMIT</button>
                                        
                                    </div>
                                </form>
                                </div>
                            </div>
                            
                        </div>
                    </div>
 
                    <!-- Load Transfer Form -->
                    <div class="col-lg-6 col-ml-12">
                        <div class="row">
                            <div class="col-12 mt-5">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Load Transfer Form</h4>
                                        <p class="text-muted font-14 mb-4">Transfer your class load to another faculty.</p>

                                        <form method="POST">
                                            <div class="form-group">
                                                <label>Select Faculty</label>
                                                <select class="custom-select" name="transfer_faculty" required>
                                                    <option value="">Select faculty member...</option>
                                                   <?php 
$empid = $_SESSION['eid'];

try {
    // Step 1: Retrieve the department of the logged-in employee
    $sql = "SELECT Department FROM tblemployees WHERE id = :empid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':empid', $empid, PDO::PARAM_STR);
    $query->execute();
    $departmentResult = $query->fetch(PDO::FETCH_OBJ);

    if ($departmentResult) {
        $department = $departmentResult->Department;

        // Step 2: Fetch employees in the same department, excluding the logged-in employee
        $sql = "SELECT id,EmpId, FirstName, LastName 
                FROM tblemployees 
                WHERE Department = :department AND id != :empid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':department', $department, PDO::PARAM_STR);
        $query->bindParam(':empid', $empid, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        // Step 3: Populate the <option> elements
        foreach ($results as $result) { ?>
            <option value="<?php echo $result->id; ?>">
                <?php echo htmlentities($result->FirstName . ' ' . $result->LastName); ?>
            </option>
        <?php }
    } else {
        echo '<option value="">No department found for the logged-in employee</option>';
    }
} catch (PDOException $e) {
    echo '<option value="">Error: ' . htmlentities($e->getMessage()) . '</option>';
}
?>
                                                </select>
                                            </div>
  <div class="form-group">
                                                <label>Subject</label>
                                                <input class="form-control" type="text" name="subject" placeholder="Please Enter the subject" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Time Slot</label>
                                                <select class="custom-select" name="time_slot" required>
                                                    <option value="">Select time slot...</option>
                                                    <option value="8:30 AM - 9:30 AM">8:30 AM - 9:30 AM</option>
                                                    <option value="9:30 AM - 10:30 AM">9:30 AM - 10:30 AM</option>
                                                    <option value="10:30 AM - 11:30 AM">10:30 AM - 11:30 AM</option>
                                                    <option value="11:30 AM - 12:30 PM">11:30 AM - 12:30 PM</option>
                                                    <option value="1:30 PM - 2:30 PM">1:30 PM - 2:30 PM</option>
                                                    <option value="2:30 PM - 3:30 PM">2:30 PM - 3:30 PM</option>
                                                    <option value="3:30 PM - 4:30 PM">3:30 PM - 4:30 PM</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Transfer Date</label>
                                                <input class="form-control" type="date" name="transfer_date" id="dates" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Message: (optional)</label>
                                                <input class="form-control" type="message" name="message" >
                                            </div>

                                          

                                            <button class="btn btn-primary" name="transfer_submit" type="submit">
                                                Submit Transfer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

    <!-- others plugins -->
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/scripts.js"></script>
</body>

<script type="text/javascript">
    // Set minimum date to today for all date inputs
    let today = new Date().toISOString().split('T')[0];
    
    // Leave request date validation
    let fromDateInput = document.getElementById("datePicker");
    let toDateInput = document.getElementById("date");
    
    // Set minimum date for leave request dates
    fromDateInput.min = today;
    toDateInput.min = today;
    
    // Ensure "to date" is not before "from date"
    fromDateInput.addEventListener('change', function() {
        toDateInput.min = this.value;
    });
    
    // Load transfer date validation
    let transferDateInput = document.getElementById("dates");
    transferDateInput.min = today;
    
    // Add date picker trigger on focus
    fromDateInput.addEventListener('focus', function(event) {
        event.target.showPicker();
    });
    
    toDateInput.addEventListener('focus', function(event) {
        event.target.showPicker();
    });
    
    transferDateInput.addEventListener('focus', function(event) {
        event.target.showPicker();
    });
</script>

</html>

<?php } ?>