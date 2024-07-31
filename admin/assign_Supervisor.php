<?php
session_start();

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: auth-signin.php");
    exit();
}
?>


 
<?php
require '../config.php';

// Get the list of departments
$query = "SELECT * FROM departments";
$stmt = $pdo->query($query);
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);



$query = "SELECT * FROM assignments_list";
$stmt = $pdo->query($query);
$assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Function to fetch all users from the database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Thesis Tracking System </title>
    <link rel="icon" type="image/x-icon" href="../src/assets/img/favicon.ico"/>
    <link href="../layouts/vertical-dark-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/vertical-dark-menu/css/dark/loader.css" rel="stylesheet" type="text/css" />
    <script src="../layouts/vertical-dark-menu/loader.js"></script>
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
                                    <p>Admin</p>
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
                            <a href="logout.php">
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
                            <img src="../src/assets/img/logo.svg" class="navbar-logo" alt="logo">
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
                            <p class="">Admin</p>
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
                                <a href="./index2.html"> Sales </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>SETTINGS</span></div>
                    </li>


                    <li class="menu">
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
                                <span>Add New Department</span>
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


                    <li class="menu active">
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
    
                            <div class="app-container">
                                
                                
                                <div class="app-note-container">
    
                                    <div class="app-note-overlay"></div>
    
                                    <div class="tab-title">
                                        <div class="row">
                                           
                                            <div class="col-md-12 col-sm-12 col-12 text-center">
                                                <a id="btn-add-notes" class="btn btn-secondary w-100" href="javascript:void(0);">Assign Student</a>
                                                
                                            </div>
                                        </div>
                                    </div>



                                    <form class="moveInline" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="excelFile">Upload Excel File</label>
                                            <input type="file" class="form-control-file" id="excelFile" name="excelFile" accept=".xlsx,.xls,.csv">
                                        </div>
                                        <button type="submit" name="import_assined_Student" class="btn btn-primary bb">Import Users</button>
                                        <style>
                                            .moveInline {
                                                display: flex;
                                                justify-content: center;
                                                align-items: center;
                                                margin-left: 20px;
                                                
                                            }
                                            .bb{
                                               
                                                margin-top: 30px;
                                            }
                                        </style>
                                    </form>
    
                                   
    
                                </div>


                                <!-- this is where all the display will be rendered -->
                                <div class="table-responsive mb-2 mt-4">
                                   
                                    
                                <div class="row layout-spacing">
                                    <div class="col-lg-12">
                                        <div class="statbox widget box box-shadow">
                                            <div class="widget-content widget-content-area">
                                                <div class="text-center mt-4"><h2>Assigned Supervisors</h2></div>
                                                <table id="style-3" class="table style-3 dt-table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-primary">Department</th>
                                                            <th class="text-primary">Student Name</th>
                                                            <th class="text-primary">Lecturer Name</th>
                                                            <th class="dt-no-sorting text-primary">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($assignments as $assignment): ?>
                                                            <tr>
                                                                <td><?php echo $assignment['department_name']; ?></td>
                                                                <td class="text-primary"><?php echo $assignment['student_name']; ?></td>
                                                                <td><?php echo $assignment['lecturer_name']; ?></td>
                                                                <td>
                                                                    <ul class="table-controls">
                                                                        <li>
                                                                            <a href="edit_assignment.php?id=<?php echo $assignment['id']; ?>" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" data-original-title="Edit">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-8 mb-1 text-success">
                                                                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                                </svg>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="assign_Supervisor.php?delete_id=<?php echo $assignment['id']; ?>" class="bs-tooltip delete-user" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-original-title="Delete">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1 text-danger">
                                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                                </svg>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>






                                                        <!-- Edit Chapter Modal -->
                            <div class="modal fade" id="editChapterModal" tabindex="-1" role="dialog" aria-labelledby="editChapterModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editChapterModalLabel">Edit Chapter</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editChapterForm" method="post">
                                                <input type="hidden" id="edit_chapter_id" name="edit_chapter_id">
                                                <div class="mb-3">
                                                    <label for="edit_chapter_name" class="form-label">Chapter Name</label>
                                                    <input type="text" class="form-control" id="edit_chapter_name" name="edit_chapter_name" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Update Chapter</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>







    
                            <!-- Modal -->
                            <div class="modal fade" id="notesMailModal" tabindex="-1" role="dialog" aria-labelledby="notesMailModalTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title add-title" id="notesMailModalTitleeLabel">Assign Student</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                              <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        
                                        <div class="modal-body">
                                            <div class="notes-box">
                                                <div class="notes-content">  


                                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="notesMailModalTitle">
                                                       <div class="row">
                                                        <div class="col-md-12 mb-2">
                                                    
                                                            <h2>TTS</h2>
                                                            
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="department">Select Department:</label>
                                                                <select class="form-control" name="department_id" id="department" required>
                                                                <option value="">Select Department</option>
                                                                <?php foreach ($departments as $department): ?>
                                                                    <option value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
                                                                <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <label class="form-label" for="student">Select Student:</label>
                                                        <select class="form-control" name="student_id" id="student" required>
                                                            <option value="">Select Student</option>
                                                        </select>

                                                        <label class="form-label" for="lecturer">Select Lecturer:</label>
                                                        <select class="form-control" name="lecturer_id" id="lecturer" required>
                                                            <option value="">Select Lecturer</option>
                                                        </select>
                                                
                                                        
                                                        <div class="modal-footer">
                                                            <button class="btn"  data-bs-dismiss="modal">Discard</button>
                                                            <button type="submit" id="" name="assign_Student" class="btn btn-primary">Assign Supervisor</button>
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

    <!-- <script>
        $(document).ready(function() {
            $('.edit-chapter').click(function() {
                var id = $(this).data('id');
                $.ajax({
                    url: 'get_chapter.php',
                    type: 'GET',
                    data: {id: id},
                    success: function(response) {
                        var chapter = JSON.parse(response);
                        $('#edit_chapter_id').val(chapter.id);
                        $('#edit_chapter_name').val(chapter.chapter_name);
                        $('#editChapterModal').modal('show');
                    }
                });
            });
        });
    </script> -->


<script>
    $(document).ready(function() {
        $('#department').on('change', function() {
            var departmentId = $(this).val();
            if (departmentId) {
                $.ajax({
                    url: 'get_students.php',
                    type: 'POST',
                    data: {department_id: departmentId},
                    success: function(response) {
                        $('#student').html(response);
                    }
                });
                $.ajax({
                    url: 'get_lecturers.php',
                    type: 'POST',
                    data: {department_id: departmentId},
                    success: function(response) {
                        $('#lecturer').html(response);
                    }
                });
            } else {
                $('#student').html('<option value="">Select Student</option>');
                $('#lecturer').html('<option value="">Select Lecturer</option>');
            }
        });
    });
    </script>


    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="../src/assets/js/apps/notes.js"></script>
    <!-- END PAGE LEVEL SCRIPTS -->

</body>


<?php
require '../config.php';

// Handle form submission
if (isset($_POST['assign_Student'])) {
    $studentId = $_POST['student_id'];
    $lecturerId = $_POST['lecturer_id'];
    $departmentId = $_POST['department_id'];

    // Check if the student is already assigned a supervisor
    $query = "SELECT * FROM assignments WHERE student_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$studentId]);
    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        // Student is already assigned a supervisor
           ?>
            <script>
                swal("Thesis Tracking System.", "This Student is already Assigned a Supervisor !!", "error");
            </script>
            <?php
    } else {
        // Assign the student to the selected lecturer
        $query = "INSERT INTO assignments (student_id, lecturer_id, department_id) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$studentId, $lecturerId, $departmentId]);

        if ($stmt->rowCount() > 0) {
            ?>
            <script>
                swal("Thesis Tracking System.", "Student Assigned Successfully !!", "success");
                            setTimeout(function() {
                window.location.href = "assign_supervisor.php";
            }, 1000);
            </script>
            <?php
        } else {
            ?>
            <script>
                swal("Thesis Tracking System.", "Failed to Assigned Student !!", "error");
            </script>
            <?php
        }
    }




}



if (isset($_GET['delete_id'])) {
    $assignmentId = $_GET['delete_id'];

    // Delete the assignment from the database
    $query = "DELETE FROM assignments WHERE id = ?";
    $stmt = $pdo->prepare($query);
   ;

    if ($stmt->execute([$assignmentId])) {
       
        ?>
        <script>
            swal({
            title: "Are you sure?",
            text: "You will not be able to recover this Chapter Data!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete it!",
            closeOnConfirm: false
            },
            function(){
            swal("Thesis Tracking System.", "Assignment deleted successfully !!", "success");
            });
            
            setTimeout(function() {
            window.location.href = "assign_Supervisor.php";
            }, 3000);
        </script>
    <?php
    } else {
        echo "<script>swal('Thesis Tracking System', 'Error deleting chapter!', 'error');</script>";
    }
}





if (isset($_POST['edit_chapter_id'])) {
    // Handle edit chapter
    $chapter_id = $_POST['edit_chapter_id'];
    $chapter_name = $_POST['edit_chapter_name'];

    $sql = 'UPDATE chapter_type SET chapter_name = ? WHERE id = ?';
    $stmt = $pdo->prepare($sql);

    try {
        $result = $stmt->execute([$chapter_name, $chapter_id]);
        if ($result) {
           
            ?>
            <script>

                swal({
                title: "Are you sure?",
                text: "You will not be able to recover this Chapter Data!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4912E1",
                confirmButtonText: "Yes, Update it!",
                closeOnConfirm: false
                },
                function(){
                    swal("Thesis Tracking System.", "Chapter Updated Successfully !!", "success");
                    setTimeout(function() {
                window.location.href = "add_new_Chapter.php";
                }, 3000);
                });

            </script>
        <?php

        } else {
            $error = $stmt->errorInfo()[2];
            echo "<script>swal('Thesis Tracking System', '$error', 'error');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>swal('Thesis Tracking System', '{$e->getMessage()}', 'error');</script>";
    }
} 







require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST['import_assined_Student'])) {
    $inputFile = $_FILES['excelFile']['tmp_name'];
    $extension = pathinfo($_FILES['excelFile']['name'], PATHINFO_EXTENSION);
   if($extension == 'xlsx' || $extension == 'xls' || $extension == 'csv') {
      $objReader = PhpOffice\PhpSpreadsheet\IOFactory::load($inputFile);
      $data = $objReader->getActiveSheet()->toArray();

      foreach ($data as $row) {
        $studentId = $row['0'];
        $lecturerId = $row['1'];
        $departmentId = $row['3'];
        

        $sql = 'INSERT INTO assignments (student_id, lecturer_id, department_id) VALUES (?, ?, ?)';
        $stmt = $pdo->prepare($sql);

        try {
            if ($stmt->execute([$studentId, $lecturerId,$departmentId])) {
                // User added successfully
                ?>
                <script>
                    swal("Thesis Tracking System.", "Student Assigned Successfully !!", "success");
                            setTimeout(function() {
                        window.location.href = "assign_Supervisor.php";
                    }, 1000);
                </script>
                <?php
                

                header("Location: add_new_User.php");
            } else {
                $error = $stmt->errorInfo()[2];
                ?>
                <script>
                    swal("Thesis Tracking System.", "<?php echo $error; ?>", "error");
                </script>
                <?php
            }
        } catch (PDOException $e) {
            ?>
            <script>
                swal("Thesis Tracking System.", "<?php echo $e->getMessage(); ?>", "error");
            </script>
            <?php
        }
      }
    }
        
}


?>

</html>