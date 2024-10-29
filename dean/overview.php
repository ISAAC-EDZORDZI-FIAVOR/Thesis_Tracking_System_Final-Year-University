<?php
session_start();

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "dean") {
    header("Location: ../admin/auth-signin.php");
    exit();
}

require_once '../config.php';
$stmt = $pdo->prepare("SELECT * FROM departments WHERE faculty_id = ?");
$stmt->execute([$_SESSION['faculty_id']]);
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);



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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

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
                        <input type="text" id="thesis-search" class="form-control search-form-control ml-lg-auto" placeholder="Search theses...">

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
                                    <p><?php  echo $_SESSION["fullname"]; ?> !</p>
                                    <p>Faculty Dean</p>
                                    <p><?php 
                                    $faculty_query = "SELECT name FROM faculties WHERE id = ?";
                                    $stmt = $pdo->prepare($faculty_query);
                                    $stmt->execute([$_SESSION['faculty_id']]);
                                    $faculty = $stmt->fetch(PDO::FETCH_ASSOC);
                                    echo $faculty['name']; 
                                    ?></p>
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
                        <p><?php  echo $_SESSION["fullname"]; ?> !</p>
                                    <p>Faculty Dean</p>
                                    <p><?php 
                                    $faculty_query = "SELECT name FROM faculties WHERE id = ?";
                                    $stmt = $pdo->prepare($faculty_query);
                                    $stmt->execute([$_SESSION['faculty_id']]);
                                    $faculty = $stmt->fetch(PDO::FETCH_ASSOC);
                                    echo $faculty['name']; 
                                    ?></p>
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
                        <a href="./overview.php" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            <line x1="12" y1="6" x2="18" y2="6"></line>
                            <line x1="12" y1="10" x2="18" y2="10"></line>
                            <line x1="12" y1="14" x2="18" y2="14"></line>
                            </svg>
                               <span>Thesis Overview</span>
                            </div>
                        </a>
                    </li>

                   


                    <li class="menu ">
                        <a href="./Progress_Analysis.php" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            <line x1="12" y1="6" x2="18" y2="6"></line>
                            <line x1="12" y1="10" x2="18" y2="10"></line>
                            <line x1="12" y1="14" x2="18" y2="14"></line>
                            </svg>
                               <span>Progress Analysis</span>
                            </div>
                        </a>
                    </li>


                    <li class="menu">
                        <a href="./generate_dean_report.php" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>

                                <span>Generate Report</span>
                            </div>
                        </a>
                    </li>

                    
                    
                    
                </ul>
                
            </nav>

        </div>
        <!--  END SIDEBAR  -->
  <style>
                                            form i {
                                        
                                            cursor: pointer;
                                            color: black;
                                            font-size: 15px;
                                            position: relative;
                                            top: -40px;
                                            float: right;
                                            right: 10px;
                                            
                                        }
                                    </style>
        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="row app-notes layout-top-spacing" id="cancel-row">
                <div class="col-lg-12">
                    <div class="app-hamburger-container">
                        <div class="hamburger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu chat-menu d-xl-none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></div>
                    </div>
                    <div class="app-container">
                        <div class="app-note-container">
                            <div class="app-note-overlay"></div>
                        </div>
                        <div class="table-responsive mb-2 mt-4">
                            <div class="card full-width-card mb-2">
                                <div class="card-body">
                                    <form id="filterForm" class="">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <select id="departmentFilter" name="department" class="form-control">
                                                    <option value="">All Departments</option>
                                                    <?php foreach ($departments as $dept): ?>
                                                        <option value="<?php echo $dept['id']; ?>"><?php echo $dept['name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <i class="bi bi-chevron-down"></i>
                                            </div>
                                            <div class="col-md-4">
                                                <select id="lecturerFilter" name="lecturer" class="form-control custom-select">
                                                    <option value="">All Lecturers</option>
                                                </select>
                                                <i class="bi bi-chevron-down"></i>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="submit" class="btn btn-primary">Apply Filters</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div id="dashboardContent">
                                <div class="accordion custom-accordion text-white" id="departmentAccordion">
                                    <?php
                                    $stmt = $pdo->prepare("SELECT * FROM departments WHERE faculty_id = ?");
                                    $stmt->execute([$_SESSION['faculty_id']]);
                                    $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($departments as $index => $department) {
                                        echo "<div class='accordion-item mb-2 text-white'>";
                                        echo "<h2 class='accordion-header' id='heading{$department['id']}'>";
                                        echo "<button class='accordion-button collapsed btn-primary text-white' type='button' data-bs-toggle='collapse' data-bs-target='#collapse{$department['id']}' aria-expanded='false' aria-controls='collapse{$department['id']}'>";
                                        echo "{$department['name']} <span class='icon-wrapper'><i class='fas fa-plus'></i><i class='fas fa-minus'></i></span>";
                                        echo "</button>";
                                        echo "</h2>";
                                        echo "<div id='collapse{$department['id']}' class='accordion-collapse collapse' aria-labelledby='heading{$department['id']}' data-bs-parent='#departmentAccordion'>";
                                        echo "<div class='accordion-body'>";

                                        $stmt = $pdo->prepare("SELECT * FROM users WHERE role = 'lecturer' AND department_id = ?");
                                        $stmt->execute([$department['id']]);
                                        $lecturers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        echo "<div class='accordion custom-accordion' id='lecturerAccordion{$department['id']}'>";
                                        foreach ($lecturers as $lecturer) {
                                            echo "<div class='accordion-item'>";
                                            echo "<h2 class='accordion-header' id='headingLecturer{$lecturer['id']}'>";
                                            echo "<button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapseLecturer{$lecturer['id']}' aria-expanded='false' aria-controls='collapseLecturer{$lecturer['id']}'>";
                                            echo "{$lecturer['fullname']} <span class='icon-wrapper'><i class='fas fa-plus'></i><i class='fas fa-minus'></i></span>";
                                            echo "</button>";
                                            echo "</h2>";
                                            echo "<div id='collapseLecturer{$lecturer['id']}' class='accordion-collapse collapse' aria-labelledby='headingLecturer{$lecturer['id']}' data-bs-parent='#lecturerAccordion{$department['id']}'>";
                                            echo "<div class='accordion-body'>";
                                            
                                            echo "<div class='table-responsive'>";
                                            echo "<table class='table table-striped'>";
                                            echo "<thead><tr><th>ID</th><th>Student Name</th><th>Proposal</th><th>Chapter 1</th><th>Chapter 2</th><th>Chapter 3</th><th>Chapter 4</th><th>Chapter 5</th><th>Last Interaction</th></tr></thead>";
                                            echo "<tbody>";
                                       
                                            $stmt = $pdo->prepare("
                                                SELECT
                                                    u.id AS student_id,
                                                    u.username as student_username,
                                                    u.fullname AS student_name,
                                                    tp.status as proposal_status,
                                                    tp.submission_date as proposal_submission_date,
                                                    c1.status as chapter_one_status,
                                                    c2.status as chapter_two_status,
                                                    c3.status as chapter_three_status,
                                                    c4.status as chapter_four_status,
                                                    c5.status as chapter_five_status,
                                                    GREATEST(
                                                        COALESCE(tp.submission_date, '1970-01-01'),
                                                        COALESCE(tp.lecturer_comment_time, '1970-01-01'),
                                                        COALESCE(c1.submission_date, '1970-01-01'),
                                                        COALESCE(c1.lecturer_comment_time, '1970-01-01'),
                                                        COALESCE(c2.submission_date, '1970-01-01'),
                                                        COALESCE(c2.lecturer_comment_time, '1970-01-01'),
                                                        COALESCE(c3.submission_date, '1970-01-01'),
                                                        COALESCE(c3.lecturer_comment_time, '1970-01-01'),
                                                        COALESCE(c4.submission_date, '1970-01-01'),
                                                        COALESCE(c4.lecturer_comment_time, '1970-01-01'),
                                                        COALESCE(c5.submission_date, '1970-01-01'),
                                                        COALESCE(c5.lecturer_comment_time, '1970-01-01')
                                                    ) AS last_interaction_date,
                                                    DATEDIFF(CURDATE(),
                                                        GREATEST(
                                                            COALESCE(tp.submission_date, '1970-01-01'),
                                                            COALESCE(tp.lecturer_comment_time, '1970-01-01'),
                                                            COALESCE(c1.submission_date, '1970-01-01'),
                                                            COALESCE(c1.lecturer_comment_time, '1970-01-01'),
                                                            COALESCE(c2.submission_date, '1970-01-01'),
                                                            COALESCE(c2.lecturer_comment_time, '1970-01-01'),
                                                            COALESCE(c3.submission_date, '1970-01-01'),
                                                            COALESCE(c3.lecturer_comment_time, '1970-01-01'),
                                                            COALESCE(c4.submission_date, '1970-01-01'),
                                                            COALESCE(c4.lecturer_comment_time, '1970-01-01'),
                                                            COALESCE(c5.submission_date, '1970-01-01'),
                                                            COALESCE(c5.lecturer_comment_time, '1970-01-01')
                                                        )
                                                    ) AS days_since_last_interaction
                                                FROM
                                                    users u
                                                LEFT JOIN thesis_proposals tp ON u.id = tp.student_id
                                                LEFT JOIN chapter_one c1 ON u.id = c1.student_id
                                                LEFT JOIN chapter_two c2 ON u.id = c2.student_id
                                                LEFT JOIN chapter_three c3 ON u.id = c3.student_id
                                                LEFT JOIN chapter_four c4 ON u.id = c4.student_id
                                                LEFT JOIN chapter_five c5 ON u.id = c5.student_id
                                                JOIN assignments a ON u.id = a.student_id
                                                WHERE
                                                    a.primary_supervisor_id = ? OR a.secondary_supervisor_id1 = ? OR a.secondary_supervisor_id2 = ?
                                            ");
                                            $stmt->execute([$lecturer['id'], $lecturer['id'], $lecturer['id']]);
                                            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                       
                                            foreach ($students as $student) {
                                                echo "<tr>";
                                                echo "<td>{$student['student_username']}</td>";
                                                echo "<td>{$student['student_name']}</td>";
                                                echo "<td>" . getStatusBadge($student['proposal_status']) . "</td>";
                                                echo "<td>" . getStatusBadge($student['chapter_one_status']) . "</td>";
                                                echo "<td>" . getStatusBadge($student['chapter_two_status']) . "</td>";
                                                echo "<td>" . getStatusBadge($student['chapter_three_status']) . "</td>";
                                                echo "<td>" . getStatusBadge($student['chapter_four_status']) . "</td>";
                                                echo "<td>" . getStatusBadge($student['chapter_five_status']) . "</td>";
                                               
                                                if ($student['proposal_submission_date']) {
                                                    $interactionClass = $student['days_since_last_interaction'] > 30 ? 'text-danger' : '';
                                                    echo "<td class='{$interactionClass}'>{$student['days_since_last_interaction']} days ago</td>";
                                                } else {
                                                    echo "<td class='text-danger'>Proposal not submitted</td>";
                                                }
                                               
                                                echo "</tr>";
                                            }
                                           
                                            echo "</tbody></table>";
                                            echo "</div>";

                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";
                                        }
                                        echo "</div>";

                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-accordion .accordion-button {
        position: relative;
        padding-right: 40px;
    }
    .custom-accordion .accordion-button .icon-wrapper {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
    }
    .custom-accordion .accordion-button .fa-plus {
        display: inline-block;
    }
    .custom-accordion .accordion-button .fa-minus {
        display: none;
    }
    .custom-accordion .accordion-button:not(.collapsed) .fa-plus {
        display: none;
    }
    .custom-accordion .accordion-button:not(.collapsed) .fa-minus {
        display: inline-block;
    }
</style>

<?php
function getStatusBadge($status) {
    switch ($status) {
        case 'approved':
            return '<span class="badge bg-success">Approved</span>';
        case 'pending':
            return '<span class="badge bg-warning">Pending</span>';
        case 'revise':
            return '<span class="badge bg-warning">Revise</span>';
        case 'rejected':
            return '<span class="badge bg-danger">Rejected</span>';
        default:
            return '<span class="badge bg-secondary">Not Started</span>';
    }
}
?>

        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->
    


    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="../src/plugins/src/global/vendors.min.js"></script>
    <script src="../src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="../src/plugins/src/waves/waves.min.js"></script>
    <script src="../layouts/vertical-dark-menu/app.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->


    <script src="../src/assets/js/custom.js"></script>
    <script src="../src/assets/js/form-validation.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
   
    <!-- END PAGE LEVEL SCRIPTS --> 

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="../src/assets/js/apps/notes.js"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script>
        $(document).ready(function() 
        {
            // Load initial dashboard content
            // loadDashboardContent();

            $('#departmentFilter').change(function() {
                var departmentId = $(this).val();
                $.ajax({
                    url: 'get_lecturers.php',
                    method: 'POST',
                    data: { department_id: departmentId },
                    success: function(response) {
                        $('#lecturerFilter').html(response);
                    }
                });
            });

            $('#filterForm').submit(function(e) {
                e.preventDefault();
                loadDashboardContent();
            });

            function loadDashboardContent() {
                $.ajax({
                    url: 'filter_dashboard.php',
                    method: 'POST',
                    data: $('#filterForm').serialize(),
                    success: function(response) {
                        $('#dashboardContent').html(response);
                    }
                });
            }
        });

    </script>

</body>

</html>

