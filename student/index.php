<?php
session_start();
require_once '../config.php';
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "student") {
    header("Location: ../admin/auth-signin.php");
    exit();
}


// Fetch student information
$student_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT u.*, d.name  FROM Users u JOIN departments d ON u.department_id = d.id WHERE u.id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);



// Check if supervisor is assigned
$stmt = $pdo->prepare("SELECT primary_supervisor_id AND secondary_supervisor_id1 AND secondary_supervisor_id2   FROM assignments WHERE student_id = ?");
$stmt->execute([$student_id]);
$supervisor = $stmt->fetch(PDO::FETCH_ASSOC);


$stmt = $pdo->prepare("SELECT * FROM thesis_proposals WHERE student_id = ?");
$stmt->execute([$student_id]);
$thesis_proposal = $stmt->fetch(PDO::FETCH_ASSOC);



// $stmt = $pdo->prepare("SELECT u.fullname AS lecturer_name, u.email AS lecturer_email FROM Users u JOIN assignments sla ON u.id = sla.primary_supervisor_id  WHERE sla.student_id = ?
// ");
// $stmt->execute([$student_id]);
// $assigned_lecturer = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT u.fullname AS lecturer_name, u.email AS lecturer_email, 
    CASE 
        WHEN a.primary_supervisor_id = u.id THEN 'Primary'
        WHEN a.secondary_supervisor_id1 = u.id THEN 'Secondary 1'
        WHEN a.secondary_supervisor_id2 = u.id THEN 'Secondary 2'
    END AS supervisor_type
    FROM Users u 
    JOIN assignments a ON (u.id = a.primary_supervisor_id OR u.id = a.secondary_supervisor_id1 OR u.id = a.secondary_supervisor_id2)
    WHERE a.student_id = ?
    ORDER BY CASE 
        WHEN a.primary_supervisor_id = u.id THEN 1
        WHEN a.secondary_supervisor_id1 = u.id THEN 2
        WHEN a.secondary_supervisor_id2 = u.id THEN 3
    END");

$stmt->execute([$student_id]);
$assigned_supervisors = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Thesis Tracking System </title>
    <link rel="icon" type="image/x-icon" href="../src/assets/img/logo.png"/>
    <link href="../layouts/vertical-dark-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/vertical-dark-menu/css/dark/loader.css" rel="stylesheet" type="text/css" />
    <script src="../layouts/vertical-dark-menu/loader.js"></script>
    
    <script src="../dist/js/jquery.min.js"></script>
    <!-- <script src="../dist/js/sweetalert.min.js"></script> -->
    <script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/vertical-dark-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/vertical-dark-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    

    <link href="../src/assets/css/light/components/modal.css" rel="stylesheet" type="text/css">
    <link href="../src/assets/css/light/apps/notes.css" rel="stylesheet" type="text/css" />
    
    <link href="../src/assets/css/dark/components/modal.css" rel="stylesheet" type="text/css">
    <link href="../src/assets/css/dark/apps/notes.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
     <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    

     <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="../src/plugins/src/table/datatable/datatables.css">

    <link rel="stylesheet" type="text/css" href="../src/plugins/css/light/table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="../src/plugins/css/light/table/datatable/custom_dt_custom.css">

    <link rel="stylesheet" type="text/css" href="../src/plugins/css/dark/table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="../src/plugins/css/dark/table/datatable/custom_dt_custom.css">

</head>
<body class="layout-boxed">
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    <div class="header-container container-xxl">
        <header class="header navbar navbar-expand-sm expand-header">

            <a href="javascript:void(0);" class="sidebarCollapse">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </a>

            <div class="search-animated toggle-search">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <form class="form-inline search-full form-inline search" role="search">
                    <div class="search-bar">
                        <input type="text" class="form-control search-form-control  ml-lg-auto" placeholder="Search...">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x search-close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </div>
                </form>
                <span class="badge badge-secondary">Ctrl + /</span>
            </div>

            <ul class="navbar-item flex-row ms-lg-auto ms-0">
                
                <li class="nav-item theme-toggle-item">
                    <a href="javascript:void(0);" class="nav-link theme-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-moon dark-mode"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun light-mode"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                    </a>
                </li>

                
                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar-container">
                            <div class="avatar avatar-sm avatar-indicators avatar-online">
                                <img alt="avatar" src="../src/assets/img/profile-30.png" class="rounded-circle">
                            </div>
                        </div>
                    </a>

                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="user-profile-section">
                            <div class="media mx-auto">
                                <div class="emoji me-2">
                                    &#x1F44B;
                                </div>
                                <div class="media-body">
                                    <h5><?php echo $_SESSION["fullname"]; ?> !</h5>
                                    <p>Student</p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <a href="user-profile.html">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> <span>Profile</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <a href="app-mailbox.html">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg> <span>Inbox</span>
                            </a>
                        </div>
                        
                        <div class="dropdown-item">
                            <a href="../admin/logout.php">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> <span>Log Out</span>
                            </a>
                        </div>
                    </div>
                    
                </li>
            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">

            <nav id="sidebar">

                <div class="navbar-nav theme-brand flex-row  text-center">
                    <div class="nav-logo">
                        <div class="nav-item theme-logo">
                            <a href="./index.php">
                                <img src="../src/assets/img/logo.png"  alt="logo">
                            </a>
                        </div>
                        <div class="nav-item theme-text">
                            <a href="./index.php" class="nav-link">TTS</a>
                        </div>
                    </div>
                    <div class="nav-item sidebar-toggle">
                        <div class="btn-toggle sidebarCollapse">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                        </div>
                    </div>
                </div>
                <div class="profile-info">
                    <div class="user-info">
                        <div class="profile-img">
                            <img src="../src/assets/img/profile-30.png" alt="avatar">
                        </div>
                        <div class="profile-content">
                            <p class=""><?php echo $_SESSION["fullname"]; ?>!</p>
                            <p class="">Student</p>
                        </div>
                    </div>
                </div>
                                
                <div class="shadow-bottom"></div>
                <ul class="list-unstyled menu-categories" id="accordionExample">
                    <li class="menu">
                        <a href="#dashboard" data-bs-toggle="collapse" aria-expanded="true" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span>Dashboard</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled show" id="dashboard" data-bs-parent="#accordionExample">
                            <li class="">
                                <a href="./index.php"> Analytics </a>
                            </li>
                            <li>
                                <!-- <a href="./index2.html"> Sales </a> -->
                            </li>
                        </ul>
                    </li>

                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>APPLICATIONS</span></div>
                    </li>

                    

                    <li class="menu active">
                        <a href="./add_new_User.php" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                               <span>Add New User</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu">
                        <a href="./add_new_Department.php" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                <span>Add  Department</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu">
                        <a href="./add_new_Chapter.php" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                </svg>

                                <span>Thesis Chapter</span>
                            </div>
                        </a>
                    </li>


                    <li class="menu">
                        <a href="./assign_supervisor.php" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <polyline points="17 11 19 13 23 9"></polyline>
                                </svg>

                                <span>Assign Student</span>
                            </div>
                        </a>
                    </li>

                    
                    
                </ul>
                
            </nav>

        </div>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">

           <div class="layout-px-spacing">

                <div class="middle-content container-xxl p-0">
                    
                    <div class="row app-notes layout-top-spacing" id="cancel-row">
                        <div class="col-lg-12">
                            <div class="app-hamburger-container">
                                <div class="hamburger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu chat-menu d-xl-none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></div>
                            </div>
    
                            



                                <div class="middle-content container-xxl p-0">
                                
                                <div class="row layout-top-spacing">
                                    <div class="col-xl-12 col-lg-12 col-md-12">

                                                <style>
                                                    .list-group-item-primary {
                                                        background-color: #2731B4;
                                                        color: white;
                                                    }
                                                    .list-group-item-primary strong {
                                                        color: #f8f9fa;
                                                    }
                                                </style>


                                        <div class="row">

                                                <div class="col-xl-12 col-md-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h2 class="card-title mb-4 text-center">Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?></h2>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <ul class="list-group list-group-flush rounded  btn-primary">
                                                                        <li class="list-group-item btn-primary"><strong>Department:</strong> <?php echo htmlspecialchars($student['name']); ?></li>
                                                                        <li class="list-group-item list-group-item-primary"><strong>Username:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></li>
                                                                        <li class="list-group-item btn-primary"><strong>Role:</strong> <?php echo htmlspecialchars($_SESSION['role']); ?></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <ul class="list-group list-group-flush rounded btn-primary">
                                                                        <li class="list-group-item btn-primary"><strong>Level:</strong> <?php echo htmlspecialchars($_SESSION['StudentLevel']); ?></li>
                                                                        <li class="list-group-item list-group-item-primary"><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></li>
                                                                        <li class="list-group-item btn-primary"><strong>Date Registered:</strong> <?php echo htmlspecialchars($_SESSION['dateRegistered']); ?></li>
                                                                    </ul>
                                                                </div>
                                                            </div>

                                                            <?php if (!$supervisor): ?>
                                                                <div class="alert alert-warning mt-4" role="alert">
                                                                    You have not been Assigned a supervisor yet. Contact the Administrator or Your HOD.
                                                                </div>
                                                            <?php else: ?>
                                                                <?php if (!$thesis_proposal): ?>
                                                                    
                                                                    <div class="mt-4">
                                                                        <h3 class="mb-3 text-center">Assigned Supervisors</h3>
                                                                        <div class="row">
                                                                            <?php foreach ($assigned_supervisors as $supervisor): ?>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="card h-100 btn-primary text-white">
                                                                                        <div class="card-body text-white">
                                                                                            <h5 class="card-title text-white"><?php echo htmlspecialchars($supervisor['supervisor_type']); ?> Supervisor</h5>
                                                                                            <p class="card-text text-white"><strong>Name:</strong> <?php echo htmlspecialchars($supervisor['lecturer_name']); ?></p>
                                                                                            <p class="card-text text-white"><strong>Email:</strong> <?php echo htmlspecialchars($supervisor['lecturer_email']); ?></p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            <?php endforeach; ?>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mt-4">
                                                                    <div class="col-md-12 col-sm-12 col-12 text-center">
                                                                        <a id="btn-add-notes" class="btn btn-primary" href="javascript:void(0);">Submit Thesis Proposal</a>
                                                                        
                                                                    </div>

                                                                    </div>

                                                                    <?php elseif ($thesis_proposal['status'] == 'pending'): ?>
                                                                        <div class="card mt-4">
                                                                            <div class="card-header bg-info text-white">
                                                                                <h2 class="mb-0">Thesis Proposal Status</h2>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <div class="alert alert-info" role="alert">
                                                                                    Your thesis proposal is pending approval.
                                                                                </div>
                                                                                <ul class="list-group">
                                                                                    <li class="list-group-item list-group-item-primary"><strong>Title:</strong> <?php echo htmlspecialchars($thesis_proposal['title']); ?></li>
                                                                                    <li class="list-group-item list-group-item-primary"><strong>Description:</strong> <?php echo htmlspecialchars($thesis_proposal['description']); ?></li>
                                                                                    <li class="list-group-item list-group-item-primary"><strong>Status:</strong> <span class="badge bg-warning text-dark"><?php echo htmlspecialchars($thesis_proposal['status']); ?></span></li>
                                                                                    <li class="list-group-item list-group-item-primary"><strong>Submitted Date:</strong> <?php echo htmlspecialchars($thesis_proposal['submission_date']); ?></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>

                                                                    <?php elseif ($thesis_proposal['status'] == 'rejected'): ?>
                                                                            <div class="card mt-4">
                                                                                <div class="card-header bg-danger text-white">
                                                                                    <h2 class="mb-0">Thesis Proposal Status</h2>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <div class="alert alert-danger" role="alert">
                                                                                        Your thesis proposal has been rejected. Please review the feedback and resubmit.
                                                                                    </div>
                                                                                    <ul class="list-group">
                                                                                        <li class="list-group-item list-group-item-danger"><strong>Title:</strong> <?php echo htmlspecialchars($thesis_proposal['title']); ?></li>
                                                                                        <li class="list-group-item list-group-item-danger"><strong>Description:</strong> <?php echo htmlspecialchars($thesis_proposal['description']); ?></li>
                                                                                        <li class="list-group-item list-group-item-danger"><strong>Feedback:</strong> <?php echo htmlspecialchars($thesis_proposal['comment']); ?></li>
                                                                                        <li class="list-group-item list-group-item-danger"><strong>Submitted Date:</strong> <?php echo htmlspecialchars($thesis_proposal['submission_date']); ?></li>
                                                                                    </ul>
                                                                                    
                                                                                    <div class="mt-4">
                                                                                    <div class="col-md-12 col-sm-12 col-12 text-center">
                                                                                        <a id="btn-add-notes" class="btn btn-primary" href="javascript:void(0);">Resubmit Thesis Proposal</a>
                                                                                        
                                                                                    </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                    <?php elseif ($thesis_proposal['status'] == 'approved'): ?>
                                                                        <div class="card mt-4">
                                                                            <div class="card-header bg-success text-white">
                                                                                <h2 class="mb-0">Thesis Progress</h2>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <!-- Add chapter submission options here -->
                                                                            </div>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                    <?php endif; ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                       
                                                        

                                                    
                                                <!-- Modal -->
                                                <div class="modal fade" id="notesMailModal" tabindex="-1" role="dialog" aria-labelledby="notesMailModalTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title add-title" id="notesMailModalTitleeLabel">Submit Thesis Proposal</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                </button>
                                                            </div>
                                                            
                                                            <div class="modal-body">
                                                                <div class="notes-box">
                                                                    <div class="notes-content">  

                                                                        
                                                                    <form method="post" action="" id="notesMailModalTitle" >
                                                                            <div class="row">
                                                                            <div class="col-md-12 mb-2">
                                                                        
                                                                                <h2>TTS</h2>
                                                                            
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="mb-3">
                                                                                <div class="form-group">
                                                                                            <label for="title">Thesis Title:</label>
                                                                                            <input type="text" class="form-control" id="title" name="title" required>
                                                                                            </div>

                                                                                            <div class="form-group">
                                                                                                <label for="description">Brief Description/Comment:</label>
                                                                                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                                                                            </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button class="btn"  data-bs-dismiss="modal">Discard</button>
                                                                                <button type="submit" id="" name="submit_Proposal" class="btn btn-primary">Submit Proposal</button>
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
                                </div>

                            </div>


                            <!-- Edit User Modal -->
                            
    
                            <!--Add User Modal -->
                            
                            
                        </div>
                    </div>

                </div>
                
            </div>
            
            
        </div>
        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->
    

     <!-- Edit User JavaScript -->
    

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="../src/plugins/src/global/vendors.min.js"></script>
    <script src="../src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="../src/plugins/src/waves/waves.min.js"></script>
    <script src="../layouts/vertical-dark-menu/app.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->


    <script src="../src/assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="../src/plugins/src/table/datatable/datatables.js"></script>
    <script>
        // var e;
        c1 = $('#style-1').DataTable({
            headerCallback:function(e, a, t, n, s) {
                e.getElementsByTagName("th")[0].innerHTML=`
                <div class="form-check form-check-primary d-block">
                    <input class="form-check-input chk-parent" type="checkbox" id="form-check-default">
                </div>`
            },
            columnDefs:[ {
                targets:0, width:"30px", className:"", orderable:!1, render:function(e, a, t, n) {
                    return `
                    <div class="form-check form-check-primary d-block">
                        <input class="form-check-input child-chk" type="checkbox" id="form-check-default">
                    </div>`
                }
            }],
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "lengthMenu": [5, 10, 20, 50],
            "pageLength": 10
        });

        multiCheck(c1);

        c2 = $('#style-2').DataTable({
            headerCallback:function(e, a, t, n, s) {
                e.getElementsByTagName("th")[0].innerHTML=`
                <div class="form-check form-check-primary d-block new-control">
                    <input class="form-check-input chk-parent" type="checkbox" id="form-check-default">
                </div>`
            },
            columnDefs:[ {
                targets:0, width:"30px", className:"", orderable:!1, render:function(e, a, t, n) {
                    return `
                    <div class="form-check form-check-primary d-block new-control">
                        <input class="form-check-input child-chk" type="checkbox" id="form-check-default">
                    </div>`
                }
            }],
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "lengthMenu": [5, 10, 20, 50],
            "pageLength": 10 
        });

        multiCheck(c2);

        c3 = $('#style-3').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [5, 10, 20, 50],
            "pageLength": 10
        });

        multiCheck(c3);
    </script>
    <!-- END PAGE LEVEL SCRIPTS --> 

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="../src/assets/js/apps/notes.js"></script>
    
    <!-- END PAGE LEVEL SCRIPTS -->

</body>

</html>

<?php

require_once '../config.php';

if (isset($_POST['submit_Proposal'])) {
    $student_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
   
    // Fetch the assigned supervisors for this student
    $stmt = $pdo->prepare("SELECT primary_supervisor_id, secondary_supervisor_id1, secondary_supervisor_id2 FROM assignments WHERE student_id = ?");
    $stmt->execute([$student_id]);
    $assignment = $stmt->fetch(PDO::FETCH_ASSOC);
   
    if ($assignment) {
        $primary_supervisor_id = $assignment['primary_supervisor_id'];
        $secondary_supervisor_id1 = $assignment['secondary_supervisor_id1'];
        $secondary_supervisor_id2 = $assignment['secondary_supervisor_id2'];
       
        $stmt = $pdo->prepare("INSERT INTO thesis_proposals 
    (student_id, primary_supervisor_id, secondary_supervisor_id1, secondary_supervisor_id2, title, description, status, submission_date) 
    VALUES (?, ?, ?, ?, ?, ?, 'pending', CURRENT_TIMESTAMP)
    ON DUPLICATE KEY UPDATE 
    primary_supervisor_id = VALUES(primary_supervisor_id),
    secondary_supervisor_id1 = VALUES(secondary_supervisor_id1),
    secondary_supervisor_id2 = VALUES(secondary_supervisor_id2),
    title = VALUES(title),
    description = VALUES(description),
    status = 'pending',
    submission_date = CURRENT_TIMESTAMP");
        $stmt->execute([$student_id, $primary_supervisor_id, $secondary_supervisor_id1, $secondary_supervisor_id2, $title, $description]);

        
        ?>
            <script>
                swal("Thesis Tracking System.", "Thesis Proposal Submitted Successfully !!", "success");
                            setTimeout(function() {
                window.location.href = "index.php";
            }, 2000);
            </script>
        <?php
    
    } else {
        echo "<script>
            swal('Thesis Tracking System', 'No supervisors assigned. Please contact your administrator.', 'error');
        </script>";
    }
}
?>



