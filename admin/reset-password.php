<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta content="BlackCode" name="author" />
    <title>Thesis Tracking System</title>
    <link rel="stylesheet" href="../layouts/vertical-dark-menu/css/custom.css" />
    <link rel="icon" type="image/x-icon" href="../src/assets/img/logo.png"/>
    <link href="../layouts/vertical-dark-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/vertical-dark-menu/css/dark/loader.css" rel="stylesheet" type="text/css" />
    <script src="../layouts/vertical-dark-menu/loader.js"></script>
    <script src="../dist/js/sweetalert.min.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <link href="../layouts/vertical-dark-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/light/authentication/auth-cover.css" rel="stylesheet" type="text/css" />
    
    <link href="../layouts/vertical-dark-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/dark/authentication/auth-cover.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" 
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    
</head>
</head>
<body class="form">

    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <div class="auth-container d-flex h-100">

        <div class="container mx-auto align-self-center">
    
            <div class="row">
    
                <div class="col-6 d-lg-flex d-none h-100 my-auto top-0 start-0 text-center justify-content-center flex-column">
                    <div class="auth-cover-bg-image"></div>
                    <div class="auth-overlay"></div>
                        
                    <div class="auth-cover">
    
                        <div class="position-relative">
    
                            <img src="../src/assets/img/Thesis_Page.png" class="fullLength" style="border-radius: 2rem" alt="auth-img">
    
                            <!-- <h2 class="mt-5 text-white font-weight-bolder px-2">Join the community of expert developers</h2>
                            <p class="text-white px-2">It is easy to setup with great customer experience. Start your 7-day free trial</p> -->
                        </div>
                        
                    </div>

                </div>

                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column ms-lg-auto  align-self-center me-lg-0 mx-auto">
                    <div class="card">
                        <div class="card-body">

                        <form action="POST">
    
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    
                                    <h2>Password Reset</h2>
                                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                                    
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" required placeholder="Enter new password">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="form-label">New Password</label>
                                        <input type="password" name="confirm_password" required placeholder="Confirm new password">
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="mb-4">
                                        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </form>
                            
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>

    </div>
    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="../src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->


</body>
</html>

<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_expires > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        $stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?");
        $stmt->execute([$password, $user['id']]);
        echo "Password reset successful. You can now login with your new password.";
    } else {
        echo "Invalid or expired token.";
    }
} else {
    $token = $_GET['token'] ?? '';
}
?>