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
                                    <p>Enter Your Email to Reset Your Password</p>
                                    
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="username" placeholder="Enter Username or Index No" class="form-control">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" placeholder="Enter Your Email" class="form-control">
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
    $email = $_POST['email'];
    $username = $_POST['username'];
    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

    $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE username = ?");
    $stmt->execute([$token, $expires, $username]);

    if ($stmt->rowCount() > 0) {
        $reset_link = "http://localhost/tts/admin/reset-password.php?token=$token";
        $to = $email;
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: $reset_link";
        $headers = "From: noreply@tts.uew.edu.gh";

        mail($to, $subject, $message, $headers);
        // echo "Password reset link sent to your email.";
        ?>
        <script>
            swal("Thesis Tracking System.", "Password reset link sent to your email.", "success");
        </script>
        <?php
    } else {
        echo "Email not found.";
    }
}
?>