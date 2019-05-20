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
    @include('header', ['title' => "Today's Bills"])

    <!-- main-content-->
    <div class="wrapper">
        @include('sidebar')
        <div id="content">
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="row mb-4">
                        <div class="col-12 col-md-12">
                            <div class="card redial-border-light redial-shadow mb-4">
                                <div class="card-body">
                                    <div class="card redial-border-light redial-shadow mb-4">
                                        <div class="card-body">
                                            <h6 class="header-title pl-3 redial-relative">Bill List - (Latest bill views on First)</h6>
                                            <table class="table table-dark table-hover mb-0 redial-font-weight-500 table-responsive d-md-table">
                                                @if (count($listTodayBill) > 0)
                                                <thead>
                                                    <tr>
                                                        <th scope="col"></th>
                                                        <th scope="col">Bill Id</th>
                                                        <th scope="col">Products</th>
                                                        <th scope="col">Product Count</th>
                                                        <th scope="col">Bill Amount</th>
                                                        <th scope="col">Date - Time</th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = $listTodayBill->perPage() * ($listTodayBill->currentPage() - 1) + 1; ?>
                                                    @foreach($listTodayBill as $bills)
                                                    <tr>
                                                        <th></th>
                                                        <td>{{$bills->invoice_number}}</td>
                                                        <td>
                                                            @foreach($bills['orders'] as $orders)
                                                            {{$orders->order_name}} - ({{$orders->order_quantity}})
                                                  <!--       @if(count($bills['orders']) > 1)   ,
                                                    @endif -->
                                                    @endforeach
                                                </td>
                                                <td>{{$bills->ordered_count}}</td>
                                                <td>{{$bills->ordered_total}}</td>
                                                <td>{{$bills->ordered_date}} - {{$bills->ordered_time}}</td>
                                                <td> <a href="{{route('viewTodayBill',['id'=> "$bills->invoice_number"])}}"><button class="report button2">View</button> </a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        @else
                                        <center>No Bills Available</center>
                                        @endif
                                    </table>
                                    <center>
                                        {{ $listTodayBill->links() }}
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