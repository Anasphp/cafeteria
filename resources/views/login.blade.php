<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cup - Login</title>
    <link rel="icon" href="dist/images/cup.png" />

    <!--Plugin CSS-->
    <link href="dist/css/plugins.min.css" rel="stylesheet">

    <!--main Css-->
    <link href="dist/css/main.min.css" rel="stylesheet">
</head>
<body style="
height: 100%; margin-bottom: 217px;
background-position: center;
background-repeat: no-repeat;
background-size: cover;
background-image: url(dist/images/beverage-book-break-533403.jpg);">

<!-- main-content-->
<div class="wrapper">
    <div class="w-100">
        <div class="row d-flex justify-content-center  pt-5 mt-5">
            <div class="col-12 col-xl-4">
                <div class="card" style="background-color: #696969">
                    <div class="card-body text-center">
                        <h4 class="mb-0 redial-font-weight-400" >Cup - Admin</h4>
                    </div> 
                    <div class="redial-divider"></div>
                    <div class="card-body py-4 text-center">
                        <!-- <img src="dist/images/logo-v2.png" alt="" class="img-fluid mb-4"> -->
                        <form action="/login" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Username" name="username" />
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="password" name="password" />
                            </div>
<!--                                     <div class="form-group text-left">
                                        <input type="checkbox" id="checkbox11">
                                        <label for="checkbox11">Remember Me</label>
                                    </div> -->
                                    <button class="btn btn-primary btn-md redial-rounded-circle-50 btn-block">Login</button>
                                </form>
                            </div> 
                        </div>
                    </div>
                </div>   
            </div>
        </div>
        <!-- <br> -->

        <!-- main-content-->
       <!--  <div class="wrapper">
            <div class="w-100">
                <div class="row d-flex justify-content-center  pt-5 mt-5">
                    <div class="col-12 col-xl-4">
                        <div class="card" style="background-color: #e5d1b8;height: 116px;">
                            <center><h5>POWERED BY</h5></center>
                            <img src="dist/images/chrono.png" style="height: 228px;margin-top: -80px;">
                         </div>   
                    </div>
                </div>   
            </div>
        </div> -->
        <!-- End main-content-->
        
        <!-- jQuery -->
        <script src="dist/js/plugins.min.js"></script>        
        <script src="dist/js/common.js"></script>
    </body>
    </html>