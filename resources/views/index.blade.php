<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cup - Dashboard</title>
    <link rel="icon" href="dist/images/cup.png" />       
    <!--Plugin CSS-->
    <link href="dist/css/plugins.min.css" rel="stylesheet">
    <!--main Css-->
    <link href="dist/css/main.min.css" rel="stylesheet">
    <script src="{{asset('dist/jquery-1.12.4.min.js')}}"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
           // swal("Good job!", "You clicked the button!", "success"); 
        });
       //  function popup() {
       //     swal("Good job!", "You clicked the button!", "success");   
       // }
   </script>
</head>
<body>
    @include('header', ['title' => "Dashboard"])
    <!-- main-content-->
    <div class="wrapper">
        @include('sidebar')
        <div id="content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row mb-xl-4 mb-0">
                        <div class="col-12 col-sm-6 col-xl-3 mb-4 mb-xl-0">
                            <div class="card redial-border-primary redial-shadow redial-bg-primary text-white">
                                <div class="card-body">
                                    <div class="media d-block d-sm-flex text-center text-sm-left">
                                        <div class="media-body">
                                            <div class="text-center text-sm-right">
                                                <center>
                                                    <h2 class="mb-1 redial-font-weight-400 text-white">{{$count['todayBillCount']}} </h2>
                                                    <p class="mb-2">Today Bills</p>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3 mb-4 mb-xl-0">
                            <div class="card redial-bg-success redial-border-success redial-shadow text-white">
                                <div class="card-body">
                                    <div class="media d-block d-sm-flex text-center text-sm-left">
                                        <div class="media-body">
                                            <div class="text-center text-sm-right">
                                                <center>
                                                    <h2 class="mb-1 redial-font-weight-400 text-white">{{$count['todayRevenue']}}</h2>
                                                    <p class="mb-2">Today Revenue(&#x20b9;)</p>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3 mb-4 mb-xl-0">
                            <div class="card redial-bg-pink redial-border-pink redial-shadow text-white">
                                <div class="card-body">
                                    <div class="media d-block d-sm-flex text-center text-sm-left">
                                        <div class="media-body">
                                            <div class="text-center text-sm-right">
                                                <center>
                                                    <h2 class="mb-1 redial-font-weight-400 text-white"> 
                                                        @if($count['expense']['expenses_amount'] != 0)
                                                        {{$count['expense']['expenses_amount']}}
                                                        @else
                                                        0
                                                        @endif
                                                    </h2>
                                                    <p class="mb-2">Expenses(&#x20b9;)</p>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="card redial-bg-info redial-border-info redial-shadow text-white">
                                <div class="card-body">
                                    <div class="media d-block d-sm-flex text-center text-sm-left">
                                        <div class="media-body">
                                            <div class="text-center text-sm-right">
                                                <center>
                                                    <h2 class="mb-1 redial-font-weight-400 text-white">
                                                        @if($count['openingBalance']['opening_balance_amount'] != 0)
                                                        {{$count['openingBalance']['opening_balance_amount']}}
                                                        @else
                                                        0
                                                        @endif
                                                    </h2>
                                                    <p class="mb-2">Opening Balance(&#x20b9;)</p>
                                                </center>
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
    <!-- End main-content-->

    <!-- Top To Bottom--> <a href="#" class="scrollup text-center redial-bg-primary redial-rounded-circle-50 " > 
        <h4 class="text-white mb-0"><i class="icofont icofont-long-arrow-up"></i></h4>
    </a>
    <!-- End Top To Bottom-->
    <!-- jQuery -->
    <script src="dist/js/plugins.min.js"></script>

    <script src="dist/js/common.js"></script>
</body>
</html>