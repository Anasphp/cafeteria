<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cup - Revenue</title>
    <link rel="icon" href="dist/images/cup.png" />

    <!--Plugin CSS-->
    <link href="dist/css/plugins.min.css" rel="stylesheet">

    <!--main Css-->
    <link href="dist/css/main.min.css" rel="stylesheet">
</head>
<body>
    @include('header', ['title' => "List Revenue"])

    <!-- main-content-->
    <div class="wrapper">
        @include('adminsidebar')
        <div id="content">
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="row mb-4">
                        <div class="col-12 col-md-12">
                            <div class="card redial-border-light redial-shadow mb-4">
                                <div class="card-body">
                                    <div class="card redial-border-light redial-shadow mb-4">
                                        <div class="card-body">
                                            <h6 class="header-title pl-3 redial-relative">Revenue - {{Session::get('shift')}}</h6>
                                            <table class="table table-dark table-hover mb-0 redial-font-weight-500 table-responsive d-md-table">
                                                @if (count($revenue) > 0)
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Shift</th>
                                                        <th scope="col">Started Date</th>
                                                        <th scope="col">Closed Date</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Closed At</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($revenue as $data)
                                                    <tr>
                                                        <td>
                                                        @if($data->revenue_shift == 1)
                                                        Morning Shift
                                                        @else
                                                        Evening Shift
                                                        @endif  
                                                        </td>
                                                        <td>{{$data->revenue_date}}</td>
                                                        <td>{{$data->revenue_closed_date}}</td>
                                                        <td>{{$data->revenue_amount}}</td>
                                                        
                                                        <td>{{$data->revenue_closed_time}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                @else
                                                <center>No Revenue Available</center>
                                                @endif
                                            </table>
                                            <br>
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

    <!-- Top To Bottom-->
    <a href="#" class="scrollup text-center redial-bg-primary redial-rounded-circle-50" style="background-color: #af674b;"> 
        <h4 class="text-white mb-0"><i class="icofont icofont-long-arrow-up"></i></h4>
    </a>
    <!-- End Top To Bottom-->

    <!-- jQuery -->
    <script src="dist/js/plugins.min.js"></script>
    <script src="dist/js/common.js"></script>
</body>
</html>