<?php
session_start();

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "dean") {
    header("Location: ../admin/auth-signin.php");
    exit();
}

require_once '../config.php';



// Fetch all department data initially
$stmt = $pdo->prepare("SELECT u.department_id, d.name as department_name, tp.status as proposal_status, 
    c1.status as chapter_one_status, 
    c2.status as chapter_two_status, 
    c3.status as chapter_three_status, 
    c4.status as chapter_four_status, 
    c5.status as chapter_five_status 
    FROM users u 
    JOIN departments d ON u.department_id = d.id
    LEFT JOIN thesis_proposals tp ON u.id = tp.student_id 
    LEFT JOIN chapter_one c1 ON u.id = c1.student_id 
    LEFT JOIN chapter_two c2 ON u.id = c2.student_id 
    LEFT JOIN chapter_three c3 ON u.id = c3.student_id 
    LEFT JOIN chapter_four c4 ON u.id = c4.student_id 
    LEFT JOIN chapter_five c5 ON u.id = c5.student_id 
    WHERE u.role = 'student'");
$stmt->execute();
$allStudents = $stmt->fetchAll(PDO::FETCH_ASSOC);

$departmentData = [];
foreach ($allStudents as $student) {
    $dept_id = $student['department_id'];
    if (!isset($departmentData[$dept_id])) {
        $departmentData[$dept_id] = [
            'name' => $student['department_name'],
            'proposal' => 0,
            'chapter_one' => 0,
            'chapter_two' => 0,
            'chapter_three' => 0,
            'chapter_four' => 0,
            'chapter_five' => 0,
            'total' => 0
        ];
    }
    $departmentData[$dept_id]['total']++;
    foreach (['proposal', 'chapter_one', 'chapter_two', 'chapter_three', 'chapter_four', 'chapter_five'] as $stage) {
        if ($student[$stage . '_status'] == 'approved') {
            $departmentData[$dept_id][$stage]++;
        }
    }
}

$initialData = [];
foreach ($departmentData as $dept_id => $data) {
    $initialData[$dept_id] = [
        'name' => $data['name'],
        'percentages' => []
    ];
    foreach (['proposal', 'chapter_one', 'chapter_two', 'chapter_three', 'chapter_four', 'chapter_five'] as $stage) {
        $initialData[$dept_id]['percentages'][$stage] = $data['total'] > 0 ? round(($data[$stage] / $data['total']) * 100, 2) : 0;
    }
}

$lecturers = $pdo->query("SELECT id, fullname FROM users WHERE role = 'lecturer'")->fetchAll(PDO::FETCH_ASSOC);



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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { background-color: #f8f9fa; }
        .dashboard-header {
            background-color: #007bff;
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
        }
        .department-card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: all 0.3s;
            margin-bottom: 30px;
        }
        .department-card:hover { box-shadow: 0 8px 16px rgba(0,0,0,0.2); }
        .chart-container {
            position: relative;
            margin: auto;
            height: 300px;
            width: 100%;
        }
    </style>
    

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

                    

                    <li class="menu">
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
                    <li class="menu active">
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

                   


                    <!-- <li class="menu">
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
                    </li> -->
 
                    
                    
                    
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
    
                            <div class="app-container">
                                
                                
                                <div class="app-note-container">
    
                                    <div class="app-note-overlay"></div>
    
                                    
                              
                                   

                                    
    
                                </div>


                                <!-- this is where all the display will be rendered -->
                                <div class="table-responsive mb-2 mt-4">



                                <div class="container mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <form id="filterForm">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <select id="departmentFilter" name="department" class="form-select">
                                                        <option value="">All Departments</option>
                                                        <?php foreach ($departmentData as $dept_id => $dept): ?>
                                                            <option value="<?php echo $dept_id; ?>"><?php echo htmlspecialchars($dept['name']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-5">
                                                <select id="lecturerFilter" name="lecturer" class="form-select" disabled>
                                                    <option value="">All Lecturers</option>
                                                </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="container" id="chartsContainer">
                                <?php foreach ($initialData as $dept_id => $dept): ?>
                                    <div class="card department-card">
                                        <div class="card-header bg-primary text-white">
                                            <h4 class="text-white"><i class="fas fa-building"></i> <?php echo htmlspecialchars($dept['name']); ?></h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="chart-container">
                                                        <canvas id="bar-chart-<?php echo $dept_id; ?>"></canvas>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="chart-container">
                                                        <canvas id="pie-chart-<?php echo $dept_id; ?>"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

    


                                </div>
                            </div>


                           
                            
                        </div>
                    </div>

                </div>
                
            </div>
            
            
        </div>
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


    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/custom.js"></script> -->
    <script>
    var initialChartData = <?php echo json_encode($initialData); ?>;

    $(document).ready(function() {


        $('#departmentFilter').on('change', function() {
        var departmentId = $(this).val();
        if (departmentId) {
            $.ajax({
                url: 'get_lecturer1.php',
                type: 'POST',
                data: { department_id: departmentId },
                dataType: 'json',
                success: function(lecturers) {
                    var options = '<option value="">All Lecturers</option>';
                    $.each(lecturers, function(id, name) {
                        options += '<option value="' + id + '">' + name + '</option>';
                    });
                    $('#lecturerFilter').html(options).prop('disabled', false);
                },
                error: function() {
                    console.error("Error fetching lecturers");
                }
            });
        } else {
            $('#lecturerFilter').html('<option value="">All Lecturers</option>').prop('disabled', true);
        }
    });



        function initializeCharts(data) {
            Object.keys(data).forEach(function(departmentId) {
                var departmentName = data[departmentId].name;
                var percentages = data[departmentId].percentages;
                var labels = ['Proposal', 'Chapter 1', 'Chapter 2', 'Chapter 3', 'Chapter 4', 'Chapter 5'];
                var values = Object.values(percentages);
                
                var barCtx = document.getElementById('bar-chart-' + departmentId).getContext('2d');
                new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Completion Percentage',
                            data: values,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(153, 102, 255, 0.7)',
                                'rgba(255, 159, 64, 0.7)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Student Progress (Bar Chart) - ' + departmentName
                            },
                            legend: {
                                display: false
                            }
                        }
                    }
                });

                var pieCtx = document.getElementById('pie-chart-' + departmentId).getContext('2d');
                new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(153, 102, 255, 0.7)',
                                'rgba(255, 159, 64, 0.7)'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Student Progress (Pie Chart) - ' + departmentName
                            }
                        }
                    }
                });
            });
        }

        function updateCharts(data) {
    // Hide all department cards initially
    $('.department-card').hide();

    Object.keys(data).forEach(function(departmentId) {
        var barChart = Chart.getChart('bar-chart-' + departmentId);
        var pieChart = Chart.getChart('pie-chart-' + departmentId);
        
        if (barChart && pieChart) {
            var newData = Object.values(data[departmentId].percentages);
            
            barChart.data.datasets[0].data = newData;
            pieChart.data.datasets[0].data = newData;

            barChart.options.animation = false;
            pieChart.options.animation = false;
            barChart.update('none');
            pieChart.update('none');

            // Show the relevant department card
            $('#bar-chart-' + departmentId).closest('.department-card').show();

            console.log("Charts updated for department:", departmentId);
        }
    });
}


        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            console.log("tsfsfssfs");
            
            
            $.ajax({
                url: 'fetch_filtered_data.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log("Received data:", response);
                    updateCharts(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        });

        // Initialize charts with the initial data
        initializeCharts(initialChartData);
    });
    </script>

    

</body>

</html>

