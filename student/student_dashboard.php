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
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/vertical-dark-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/vertical-dark-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    
    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="../src/plugins/src/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
    <!-- <link href="../src/plugins/src/sweetalerts2/sweetalerts2.css" rel="stylesheet" type="text/css" /> -->
    <script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">

    <link href="../src/assets/css/light/components/modal.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../src/plugins/css/light/editors/quill/quill.snow.css">
    <link href="../src/assets/css/light/apps/mailbox.css" rel="stylesheet" type="text/css" />
    <link href="../src/plugins/css/light/sweetalerts2/custom-sweetalert.css" rel="stylesheet" type="text/css" />

    <link href="../src/assets/css/dark/components/modal.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../src/plugins/css/dark/editors/quill/quill.snow.css">
    <link href="../src/assets/css/dark/apps/mailbox.css" rel="stylesheet" type="text/css" />
    <link href="../src/plugins/css/dark/sweetalerts2/custom-sweetalert.css" rel="stylesheet" type="text/css" />
    
    <!--  END CUSTOM STYLE FILE  -->
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

                <li class="nav-item dropdown notification-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg><span class="badge badge-success"></span>
                    </a>

                    <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
                        <div class="drodpown-title message">
                            <h6 class="d-flex justify-content-between"><span class="align-self-center">Messages</span> <span class="badge badge-primary">9 Unread</span></h6>
                        </div>
                        <div class="notification-scroll">
                            <div class="dropdown-item">
                                <div class="media server-log">
                                    <img src="../src/assets/img/profile-16.jpeg" class="img-fluid me-2" alt="avatar">
                                    <div class="media-body">
                                        <div class="data-info">
                                            <h6 class="">Kara Young</h6>
                                            <p class="">1 hr ago</p>
                                        </div>
                                        
                                        <div class="icon-status">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="dropdown-item">
                                <div class="media ">
                                    <img src="../src/assets/img/profile-15.jpeg" class="img-fluid me-2" alt="avatar">
                                    <div class="media-body">
                                        <div class="data-info">
                                            <h6 class="">Daisy Anderson</h6>
                                            <p class="">8 hrs ago</p>
                                        </div>

                                        <div class="icon-status">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown-item">
                                <div class="media file-upload">
                                    <img src="../src/assets/img/profile-21.jpeg" class="img-fluid me-2" alt="avatar">
                                    <div class="media-body">
                                        <div class="data-info">
                                            <h6 class="">Oscar Garner</h6>
                                            <p class="">14 hrs ago</p>
                                        </div>

                                        <div class="icon-status">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="drodpown-title notification mt-2">
                                <h6 class="d-flex justify-content-between"><span class="align-self-center">Notifications</span> <span class="badge badge-secondary">16 New</span></h6>
                            </div>

                            <div class="dropdown-item">
                                <div class="media server-log">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6" y2="6"></line><line x1="6" y1="18" x2="6" y2="18"></line></svg>
                                    <div class="media-body">
                                        <div class="data-info">
                                            <h6 class="">Server Rebooted</h6>
                                            <p class="">45 min ago</p>
                                        </div>

                                        <div class="icon-status">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown-item">
                                <div class="media file-upload">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                    <div class="media-body">
                                        <div class="data-info">
                                            <h6 class="">Kelly Portfolio.pdf</h6>
                                            <p class="">670 kb</p>
                                        </div>

                                        <div class="icon-status">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown-item">
                                <div class="media ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                    <div class="media-body">
                                        <div class="data-info">
                                            <h6 class="">Licence Expiring Soon</h6>
                                            <p class="">8 hrs ago</p>
                                        </div>

                                        <div class="icon-status">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
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
                                <p class=""><?php echo $_SESSION["fullname"]; ?>!</p>
                                <p class="">Student</p>
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
                            <a href="auth-boxed-lockscreen.html">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg> <span>Lock Screen</span>
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
/**
     * This code represents the main content area of the student dashboard page. It includes the following functionality:
     * - Displays the student's profile information, including their name, role, department, level, email, and registration date.
     * - Checks if the student has been assigned a supervisor, and if not, displays a warning message.
     * - If the student has not submitted a thesis proposal, displays a button to open a modal for submitting the proposal.
     * - If the student has submitted a thesis proposal, displays the status of the proposal (pending, approved).
     * - Includes JavaScript code to handle the submission of the thesis proposal form.
     * - Loads various JavaScript libraries and plugins used in the application.
     */
        <div class="main-container " id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">

            <nav id="sidebar">

                <div class="navbar-nav theme-brand flex-row  text-center">
                    <div class="nav-logo">
                        <div class="nav-item theme-logo">
                            <a href="./index.php">
                                <img src="../src/assets/img/logo.png" class="navbar-logo" alt="logo">
                            </a>
                        </div>
                        <div class="nav-item theme-text">
                            <a href="./index.php" class="nav-link"> TTS </a>
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
                                
                
                
            </nav>

        </div>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

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
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#thesisProposalModal">
                                                            Submit Thesis Proposal
                                                        </button>

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
                                         <div class="modal fade" id="thesisProposalModal" tabindex="-1" role="dialog" aria-labelledby="thesisProposalModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="thesisProposalModalLabel">Submit Thesis Proposal</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="thesisProposalForm" method="POST">
                                                            <div class="form-group">
                                                                <label for="title">Thesis Title:</label>
                                                                <input type="text" class="form-control" id="title" name="title" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="description">Brief Description:</label>
                                                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Submit Proposal</button>
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

            <!--  BEGIN FOOTER  -->
            <div class="footer-wrapper mt-0">
                <div class="footer-section f-section-1">
                    <p class="">Copyright © <span class="dynamic-year">2024</span> <a target="_blank" href="https://designreset.com/equation/">DesignReset</a>, All rights reserved.</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
                </div>
            </div>
            <!--  END FOOTER  -->
        </div>
        <!--  END CONTENT AREA  -->
    </div>
    <!-- END MAIN CONTAINER -->

    <script>
            $(document).ready(function() {
        $('#thesisProposalForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: 'submit_proposal.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#thesisProposalModal').modal('hide');
                    swal("Success", "Thesis Proposal Submitted Successfully!", "success");
                    // Optionally, refresh the page or update the UI
                },
                error: function() {
                    swal("Error", "Failed to submit thesis proposal", "error");
                }
            });
        });
    });

    </script>
    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="../src/plugins/src/global/vendors.min.js"></script>
    <script src="../src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="../src/plugins/src/waves/waves.min.js"></script>
    <script src="../layouts/vertical-dark-menu/app.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="../src/plugins/src/editors/quill/quill.js"></script>
    <script src="../src/plugins/src/sweetalerts2/sweetalerts2.min.js"></script>
    <script src="../src/plugins/src/notification/snackbar/snackbar.min.js"></script>
    <script src="../src/assets/js/apps/mailbox.js"></script>

</body>
</html>


<?php

require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
       
        $stmt = $pdo->prepare("INSERT INTO thesis_proposals (student_id, primary_supervisor_id, secondary_supervisor_id1, secondary_supervisor_id2, title, description, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
        $stmt->execute([$student_id, $primary_supervisor_id, $secondary_supervisor_id1, $secondary_supervisor_id2, $title, $description]);

        
        ?>
            <script>
                swal("Thesis Tracking System.", "Thesis Proposal Submitted Successfully !!", "success");
                            setTimeout(function() {
                window.location.href = "student_dashboard.php";
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