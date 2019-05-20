<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cup - List Bills</title>
    <link rel="icon" href="dist/images/cup.png" />

    <!--Plugin CSS-->
    <link href="dist/css/plugins.min.css" rel="stylesheet">

    <!--main Css-->
    <link href="dist/css/main.min.css" rel="stylesheet">
    <script src="{{asset('dist/jquery-1.12.4.min.js')}}"></script>
</head>
<body>
    @include('header', ['title' => "Total Bills"])

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
                                            <h6 class="header-title pl-3 redial-relative">Bill List - (Latest bill views on First) - {{Session::get('shift')}}</h6>
                                            <table class="table table-dark table-hover mb-0 redial-font-weight-500 table-responsive d-md-table">
                                                @if (count($listTotalBills) > 0)
                                                <thead>
                                                    <tr>
                                                        <th scope="col"></th>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Revenue</th>
                                                        <th scope="col">View</th>
                                                        <th scope="col">Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php //$i = $listTodayBill->perPage() * ($listTodayBill->currentPage() - 1) + 1; ?>
                                                    @foreach($listTotalBills as $date => $revenue)
                                                    <tr>
                                                        <td></td>
                                                        <td>{{$date}}</td>
                                                        <td>{{$revenue}}</td>
                                                        <td>
                                                            <a href="{{route('viewTotalBill',['date'=> "$date"])}}"><button class="report button2">View Bills</button> </a>
                                                        </td>
                                                        <td>
                                                            <a href="{{route('viewDeleteBill',['date'=> "$date"])}}"><button class="report button2">Delete Bills</button> </a></td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    @else
                                                    <center>No Bills Available</center>
                                                    @endif
                                                </table>
                                                <center>
                                                  
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
        <!-- End main-content-->

        <!-- Top To Bottom-->
        <a href="#" class="scrollup text-center redial-bg-primary redial-rounded-circle-50"> 
            <h4 class="text-white mb-0"><i class="icofont icofont-long-arrow-up"></i></h4>
        </a>
        <!-- End Top To Bottom-->

        <!-- jQuery -->

        <script src="dist/js/plugins.min.js"></script>
        <script src="dist/js/common.js"></script>
        <div id="componentID" style="display: none">
        </div>
    </body>
    </html>