<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Orbiter is a bootstrap minimal & clean admin template">
    <meta name="keywords" content="admin, admin panel, admin template, admin dashboard, responsive, bootstrap 4, ui kits, ecommerce, web app, crm, cms, html, sass support, scss">
    <meta name="author" content="Themesbox">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Login Dinkop</title>

    <link rel="icon" href="<?= BASEURL ?>/assets/images/favicon-logo.ico">

    <link href="<?= BASEURL ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= BASEURL ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?= BASEURL ?>/assets/css/style.css" rel="stylesheet" type="text/css">
    <!-- End css -->
    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Start Containerbar -->
    <div id="containerbar" class="containerbar authenticate-bg">
        <!-- Start Container -->
        <div class="container mt-5">
            <div class="card">
                <section class="vh-25 mt-2">
                    <div class="container-fluid h-custom">
                        <div class="row d-flex justify-content-center align-items-center h-100">
                            <div class="col-md-9 col-lg-6 col-xl-5">
                                <img src="<?= BASEURL ?>/assets/images/draw2.webp" class="img-fluid" alt="Sample image">
                            </div>
                            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                                <form action="login/login_process" method="POST">
                                    
                                    <div class="divider d-flex align-items-center my-4">
                                        <p class="text-center fw-bold mx-3 mb-0"> <img src="<?= BASEURL ?>/assets/images/bappeda-logo.png" height="100" alt="logo"></p>
                                    </div>

                                    <!-- Email input -->
                                    <div class="form-outline mb-4">
                                        <input type="text" id="user_name" class="form-control form-control-lg" placeholder="Masukan User Name" name="user_name" />
                                    </div>

                                    <!-- Password input -->
                                    <div class="form-outline mb-3">
                                        <input type="password" id="password" class="form-control form-control-lg" placeholder="Masukan password" name="password" />
                                    </div>

                                    <div class="text-center text-lg-start mt-4 pt-2">
                                        <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
                <br>
            </div>
        </div>
        <!-- End Container -->
    </div>

    <!-- End Containerbar -->
    <!-- Start js -->
    <!-- jQuery  -->
    <script src="<?= BASEURL ?>/assets/js/jquery.min.js"></script>
    <script src="<?= BASEURL ?>/assets/js/popper.min.js"></script>
    <script src="<?= BASEURL ?>/assets/js/bootstrap.min.js"></script>
    <script src="<?= BASEURL ?>/assets/js/modernizr.min.js"></script>
    <script src="<?= BASEURL ?>/assets/js/detect.js"></script>
    <script src="<?= BASEURL ?>/assets/js/fastclick.js"></script>
    <script src="<?= BASEURL ?>/assets/js/jquery.blockUI.js"></script>
    <script src="<?= BASEURL ?>/assets/js/waves.js"></script>
    <script src="<?= BASEURL ?>/assets/js/jquery.nicescroll.js"></script>

    <!-- App js -->
    <script src="<?= BASEURL ?>/assets/js/app.js"></script>
    <!-- End js -->
</body>

</html>