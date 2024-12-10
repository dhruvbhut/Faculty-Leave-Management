<?php
    session_start();
    error_reporting(0);
    include('../includes/dbconn.php');
    if(strlen($_SESSION['alogin'])==0){   
        header('location:index.php');
    } else {
        $eid = intval($_GET['empid']);
        if(isset($_POST['update'])){

            $fname = $_POST['firstName'];
            $lname = $_POST['lastName'];   
            $gender = $_POST['gender']; 
            $dob = $_POST['dob']; 
            $department = $_POST['department']; 
            $address = $_POST['address']; 
            $city = $_POST['city']; 
            $country = $_POST['country']; 
            $mobileno = $_POST['mobileno'];

            $sql = "UPDATE tblemployees SET FirstName=:fname, LastName=:lname, Gender=:gender, Dob=:dob, Department=:department, Address=:address, City=:city, Country=:country, Phonenumber=:mobileno WHERE id=:eid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':fname', $fname, PDO::PARAM_STR);
            $query->bindParam(':lname', $lname, PDO::PARAM_STR);
            $query->bindParam(':gender', $gender, PDO::PARAM_STR);
            $query->bindParam(':dob', $dob, PDO::PARAM_STR);
            $query->bindParam(':department', $department, PDO::PARAM_STR);
            $query->bindParam(':address', $address, PDO::PARAM_STR);
            $query->bindParam(':city', $city, PDO::PARAM_STR);
            $query->bindParam(':country', $country, PDO::PARAM_STR);
            $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
            $query->bindParam(':eid', $eid, PDO::PARAM_STR);
            $query->execute();

            $msg = "Employee record updated Successfully";
        }
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>HOD Panel - Employee Leave</title>
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
    <div id="preloader">
        <div class="loader"></div>
    </div>
    
    <div class="page-container">
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="dashboard.php"><img src="logo.png" alt="logo"></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <?php
                        $page = 'employee';
                        include '../includes/admin-sidebar.php';
                    ?>
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
                            <?php include '../includes/admin-notification.php'?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Update Employee Section</h4>
                            <ul class="breadcrumbs pull-left"> 
                                <li><a href="employees.php">Employee</a></li>
                                <li><span>Update</span></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="../assets/images/admin.png" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown">HOD <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="logout.php">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-content-inner">
                <div class="row">
                    <div class="col-lg-6 col-ml-12">
                        <div class="row">
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
                                            <p class="text-muted font-14 mb-4">Please make changes on the form below in order to update your profile</p>
                                            <?php 
                                                $eid = intval($_GET['empid']);
                                                $sql = "SELECT * from tblemployees WHERE id=:eid";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                if($query->rowCount() > 0) {
                                                    foreach($results as $result) {
                                            ?>
                                            <div class="form-group">
                                                <label for="example-text-input" class="col-form-label">First Name</label>
                                                <input class="form-control" name="firstName" value="<?php echo htmlentities($result->FirstName);?>" type="text" required id="example-text-input">
                                            </div>

                                            <div class="form-group">
                                                <label for="example-text-input" class="col-form-label">Last Name</label>
                                                <input class="form-control" name="lastName" value="<?php echo htmlentities($result->LastName);?>" type="text" required id="example-text-input">
                                            </div>

                                            <div class="form-group">
                                                <label for="example-email-input" class="col-form-label">Email</label>
                                                <input class="form-control" name="email" type="email" value="<?php echo htmlentities($result->EmailId);?>" readonly required id="example-email-input">
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Gender</label>
                                                <select class="custom-select" name="gender">
                                                    <option value="<?php echo htmlentities($result->Gender);?>"><?php echo htmlentities($result->Gender);?></option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="example-date-input" class="col-form-label">D.O.B</label>
                                                <input class="form-control" type="date" name="dob" value="<?php echo htmlentities($result->Dob);?>" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="example-text-input" class="col-form-label">Contact Number</label>
                                                <input class="form-control" name="mobileno" type="tel" value="<?php echo htmlentities($result->Phonenumber);?>" maxlength="10" required>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Your Department</label>
                                                <select class="custom-select" name="department" autocomplete="off" required>
                                                    <!-- Fetch departments from the database -->
                                                    <?php 
                                                        $sql = "SELECT DepartmentName from tbldepartments";
                                                        $query = $dbh -> prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                                                        if($query->rowCount() > 0) {
                                                            foreach($results as $resultt) {   
                                                    ?>
                                                    <option value="<?php echo htmlentities($resultt->DepartmentName); ?>" 
                                                        <?php if($resultt->DepartmentName == $result->Department) { echo "selected"; } ?>>
                                                        <?php echo htmlentities($resultt->DepartmentName); ?>
                                                    </option>
                                                    <?php 
                                                            } 
                                                        } 
                                                    ?>
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label for="example-text-input" class="col-form-label">Address</label>
                                                <input class="form-control" name="address" type="text" value="<?php echo htmlentities($result->Address);?>" required id="example-text-input">
                                            </div>

                                            <div class="form-group">
                                                <label for="example-text-input" class="col-form-label">City</label>
                                                <input class="form-control" name="city" type="text" value="<?php echo htmlentities($result->City);?>" required id="example-text-input">
                                            </div>

                                            <div class="form-group">
                                                <label for="example-text-input" class="col-form-label">Country</label>
                                                <input class="form-control" name="country" type="text" value="<?php echo htmlentities($result->Country);?>" required id="example-text-input">
                                            </div>
                                            <?php }} ?>
                                            <button class="btn btn-primary" name="update" id="update" type="submit">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/metisMenu.min.js"></script>
    <script src="../assets/js/jquery.slimscroll.min.js"></script>
    <script src="../assets/js/jquery.slicknav.min.js"></script>
    <script src="../assets/js/scripts.js"></script>
</body>
</html>
<?php } ?>
