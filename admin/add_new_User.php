<?php
session_start();

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: auth-signin.php");
    exit();
}

require '../config.php';



// Function to fetch all users from the database
function getAllUsers($pdo)
{
    $sql = "SELECT id, username, fullname, role, department_id, email FROM users";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get the department name for a given department ID
function getDepartmentName($pdo, $departmentId)
{
    $sql = "SELECT name FROM Departments WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$departmentId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['name'] ?? 'Unknown';
}





// Fetch all users from the database
$users = getAllUsers($pdo);


function displayUsersTable($pdo)
{
    $users = getAllUsers($pdo);
    ?>

            <div class="row layout-spacing">
                <div class="col-lg-12">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                        <div class="text-center mt-4"><h2>List of Users in the System</h2></div>
                            <table id="style-3" class="table style-3 dt-table-hover">
                                <thead>
                                    <tr>
                                        <th class="checkbox-column text-primary">Username</th>
                                        <th class="text-primary">Full Name</th>
                                        <th class="text-primary">Role</th>
                                        <th class="text-primary">Department</th>
                                        <th class="text-primary">Email</th>
                                        <th class="dt-no-sorting text-primary">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            
                                            <td class=""><?php echo $user['username']; ?></td>
                                            <td class=""><?php echo $user['fullname']; ?></td>
                                            <td class="text-success"><span class="shadow-none badge badge-primary"><?php echo $user['role']; ?></span></td>
                                            <td class="text-info"><?php echo getDepartmentName($pdo, $user['department_id']); ?></td>
                                            <td class=""><?php echo $user['email']; ?></td>
                                            <td class="text-center">
                                            <ul class="table-controls">
                                                <li><a href="javascript:void(0);" class="bs-tooltip edit-user" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" data-original-title="Edit" data-id="<?php echo $user['id']; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-8 mb-1 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a></li>
                                                <li><a href="add_new_User.php?delete_id=<?php echo $user['id']; ?>" class="bs-tooltip delete-user" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-original-title="Delete" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a></li>
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
    <?php
}
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
    
    <script src="../dist/js/jquery.min.js"></script>
    <script src="../dist/js/sweetalert.min.js"></script>

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
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>APPLICATIONS</span></div>
                    </li>

                    

                    <li class="menu active">
                        <a href="./add_new_User.php" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                <span>Add New User</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu">
                        <a href="./add_new_Department.php" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                <span>Add New Department</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu">
                        <a href="./add_new_Chapter.php" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                <span>Thesis Chapter</span>
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
                                                <a id="btn-add-notes" class="btn btn-secondary w-100" href="javascript:void(0);">Add New User</a>
                                                
                                            </div>
                                        </div>
                                    </div>
                              
                                   

                                    <form class="moveInline" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="excelFile">Upload Excel File</label>
                                            <input type="file" class="form-control-file" id="excelFile" name="excelFile" accept=".xlsx,.xls,.csv">
                                        </div>
                                        <button type="submit" name="import_users" class="btn btn-primary bb">Import Users</button>
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
                                   <?php
                                    require '../config.php';
                                    displayUsersTable($pdo);
                                    ?>
                                </div>
                            </div>


                            <!-- Edit User Modal -->
                            <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                              <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        <form method="post" action="" id="editUserModalLabel">
                                            <div class="modal-body">
                                                <input type="hidden" name="edit_id" id="edit_id">
                                                <div class="form-group">
                                                    <label for="username">Username</label>
                                                    <input type="text" class="form-control" id="edit_username" name="username" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="fullname">Full Name</label>
                                                    <input type="text" class="form-control" id="edit_fullname" name="fullname" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" class="form-control" id="edit_password" name="password" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="role">Role</label>
                                                    <select id="role" name="role" class="form-control custom-select" required >
                                                                    <option >Select The Role</option>
                                                                    <option value="student">Student</option>
                                                                    <option value="lecturer">Lecturer</option>
                                                                    <option value="hod">HOD</option>
                                                                    <option value="dean">Dean</option>
                                                                    <option value="admin">Admin</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="department_id">Department</label>
                                                    <select class="form-control" id="edit_department_id" name="department_id" required>
                                                        <?php
                                                        $sql = "SELECT id, name FROM Departments";
                                                        $stmt = $pdo->query($sql);
                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                            echo "<option value=\"{$row['id']}\">{$row['name']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" name="edit_user" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
    
                            <!--Add User Modal -->
                            <div class="modal fade" id="notesMailModal" tabindex="-1" role="dialog" aria-labelledby="notesMailModalTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title add-title" id="notesMailModalTitleeLabel">Add New User</h5>
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
                                                                <label class="form-label" for="username">Username</label>
                                                                <input type="text" id="username" name="username" class="form-control" placeholder="Enter Username(Index No...)" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="fullname">Full Name</label>
                                                                <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Enter Your Full Name" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="mb-4">
                                                                <label class="form-label" for="password">Password</label>
                                                                <input type="password" id="password" name="password" class="form-control" required>
                                                                <style>
                                                                    form i {
                                                                
                                                                    cursor: pointer;
                                                                    color: black;
                                                                    font-size: 20px;
                                                                    position: relative;
                                                                    top: -40px;
                                                                    float: right;
                                                                    right: 20px;
                                                                    
                                                                }
                                                                </style>
                                                                <i class="bi bi-eye-slash" id="togglePassword"></i>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="role">Role</label>
                                                                <select id="role" name="role" class="form-control custom-select" required >
                                                                    <option >Select The Role</option>
                                                                    <option value="student">Student</option>
                                                                    <option value="lecturer">Lecturer</option>
                                                                    <option value="hod">HOD</option>
                                                                    <option value="dean">Dean</option>
                                                                    <option value="admin">Admin</option>
                                                                </select>
                                                                <i class="bi bi-chevron-down"></i>
                                                            </div>
                                                        </div>



                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="role">Departments</label>
                                                                 <select id="department_id" name="department_id" class="form-control custom-select" required >
                                                                    <?php
                                                                    // Fetch departments from database and populate dropdown
                                                                    require '../config.php';
                                                                    $sql = "SELECT id, name FROM Departments";
                                                                    $stmt = $pdo->query($sql);
                                                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                        echo "<option value=\"{$row['id']}\">{$row['name']}</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <i class="bi bi-chevron-down" ></i>
                                                            </div>
                                                        </div>
                                                      
               
                                                        <div class="modal-footer">
                                                            <button class="btn"  data-bs-dismiss="modal">Discard</button>
                                                            <button type="submit" name="add_user" id="" class="btn btn-primary">Add</button>
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
     <script>
        const togglePassword = document
            .querySelector('#togglePassword');
        const password = document.querySelector('#password');
        togglePassword.addEventListener('click', () => {
            // Toggle the type attribute using
            // getAttribure() method
            const type = password
                .getAttribute('type') === 'password' ?
                'text' : 'password';
            password.setAttribute('type', type);
            // Toggle the eye and bi-eye icon
            this.classList.toggle('bi-eye');
        });
    </script>




     <!-- Edit User JavaScript -->
    <script>
    $(document).ready(function() {
        $('.edit-user').click(function() {
            var userId = $(this).data('id');
            $.ajax({
                url: 'get_user.php',
                type: 'GET',
                data: {id: userId},
                dataType: 'json',
                success: function(data) {
                    $('#edit_id').val(data.id);
                    $('#edit_username').val(data.username);
                    $('#edit_fullname').val(data.fullname);
                    $('#edit_password').val(data.password);
                    $('#edit_role').val(data.role);
                    $('#edit_department_id').val(data.department_id);
                    $('#editUserModal').modal('show');
                },
                error: function() {
                    alert('Error fetching user data');
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
require '../config.php';


// Delete User
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Prepare the delete statement
    $stmt = $pdo->prepare("DELETE FROM Users WHERE id = ?");
    $stmt->execute([$delete_id]);

    if ($stmt->rowCount() > 0) {
        echo "<script>swal('Success', 'User deleted successfully', 'success');</script>";
    } else {
        echo "<script>swal('Error', 'Failed to delete user', 'error');</script>";
    }
}



//Edit User
if (isset($_POST['edit_user'])) {
    $edit_id = $_POST['edit_id'];
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $department_id = $_POST['department_id'];

    // Prepare the update statement
    $stmt = $pdo->prepare("UPDATE Users SET username = ?, fullname = ?, password = ?, role = ?, department_id = ? WHERE id = ?");
    $stmt->execute([$username, $fullname, $password, $role, $department_id, $edit_id]);

    if ($stmt->rowCount() > 0) {
        echo "<script>swal('Success', 'User updated successfully', 'success');</script>";
    } else {
        echo "<script>swal('Error', 'Failed to update user', 'error');</script>";
    }
}

if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];
    $department_id = $_POST['department_id'];

    $sql = 'INSERT INTO Users (username,fullname, password, role, department_id) VALUES (?, ?, ?, ?,?)';
    $stmt = $pdo->prepare($sql);

    try {
        if ($stmt->execute([$username,$fullname, $password, $role, $department_id])) {
            
            
            ?>
            <script>
                swal("Thesis Tracking System.", "Data Saved Successfully !!", "success");
                
            </script>
            <?php
            
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



require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST['import_users'])) {
    $inputFile = $_FILES['excelFile']['tmp_name'];
    $extension = pathinfo($_FILES['excelFile']['name'], PATHINFO_EXTENSION);
   if($extension == 'xlsx' || $extension == 'xls' || $extension == 'csv') {
      $objReader = PhpOffice\PhpSpreadsheet\IOFactory::load($inputFile);
      $data = $objReader->getActiveSheet()->toArray();

      foreach ($data as $row) {
        $username = $row['0'];
        $fullname = $row['1'];
        $password = password_hash($row['2'], PASSWORD_DEFAULT);
        $role = $row['3'];
        $department_id = $row['4'];

        $sql = 'INSERT INTO Users (username, fullname, password, role, department_id) VALUES (?, ?, ?, ?, ?)';
        $stmt = $pdo->prepare($sql);

        try {
            if ($stmt->execute([$username, $fullname, $password, $role, $department_id])) {
                // User added successfully
                ?>
                <script>
                    swal("Thesis Tracking System.", "User Imported Successfully!", "success");
                </script>
                <?php
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



