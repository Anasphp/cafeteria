<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cup - View Bill</title>
    <link rel="icon" href="{{asset('dist/images/cup.png')}}" />

    <!--Plugin CSS-->
    <link href="{{asset('dist/css/plugins.min.css')}}" rel="stylesheet">

    <!--main Css-->
    <link href="{{asset('dist/css/main.min.css')}}" rel="stylesheet">
    <script src="{{asset('dist/jquery-1.12.4.min.js')}}"></script>
    <script type="text/javascript">
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 30000);
    </script>
    <style type="text/css">
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
  }
</style>
</head>
<body>
    @include('header', ['title' => "View Bill"])
    <div class="wrapper">
        @include('adminsidebar')
        <div id="content">
            <div class="row">
               <div class="col-12 col-sm-12  mb-4">
                <div class="card redial-border-light redial-shadow">
                    <div class="card-body">
                        <h6 class="header-title pl-3 redial-relative">Bill Details - {{Session::get('shift')}}</h6>
                        <dl class="row mb-0 redial-line-height-2_5">

                            <dt class="col-sm-5">Bill Id:</dt>
                            <dd class="col-sm-7">{{$viewBillDetails['invoice_number']}}</dd>

                            <dt class="col-sm-5">Date:</dt>
                            <dd class="col-sm-7">{{$viewBillDetails['ordered_date']}}</dd>

                            <dt class="col-sm-5">Time:</dt>
                            <dd class="col-sm-7">{{$viewBillDetails['ordered_time']}}</dd>

                            <dt class="col-sm-5">Items:</dt>
                            <dd class="col-sm-7">{{count($viewBillDetails['orders'])}}</dd>

                            <dt class="col-sm-5">Amount:</dt>
                            <dd class="col-sm-7">&#x20B9;{{$viewBillDetails['ordered_total']}}</dd>

                            <dt class="col-sm-5">Status</dt>
                            <dd class="col-sm-7"><span class="badge badge-primary text-white">Confirmed</span></dd>

                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12">
                <div class="row mb-4">
                   <div class="col-12 col-md-12 mb-4">
                    <div class="card redial-border-light redial-shadow">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <?php $no = 1; ?>
                                        <td><b>S.No</b></td>
                                        <td class="text-center"><b>Item Name</b></td>
                                        <td class="text-right"><b>Price</b></td>
                                        <td class="text-right"><b>Quantity</b></td>
                                        <td class="text-right"><b>Total Price</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($viewBillDetails['orders'] as $orders)
                                    <tr> 
                                        <td>{{$no++}}</td>
                                        <td class="text-center">{{$orders->order_name}}</td>
                                        <td class="text-right">{{$orders->order_price}}</td>
                                        <td class="text-right">{{$orders->order_quantity}}</td>
                                        <td class="text-right">{{$orders->total_price}}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td class="text-right" colspan="4"><b>Sub-Total</b></td>
                                        <td class="text-right">&#x20B9;{{$viewBillDetails['ordered_total']}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <dt class="col-sm-5"></dt>
                            <dd class="col-sm-7" ><button style="width: 210px;" id="print_bill" class="report button2">Print Bill</button>
                            </span></dd>
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
<a href="#" class="scrollup text-center redial-bg-primary redial-rounded-circle-50" >
 <h4 class="text-white mb-0"><i class="icofont icofont-long-arrow-up"></i></h4>
</a>
<!-- End Top To Bottom-->
<script type="text/javascript">
  $("#print_bill").on('click', function() {
      const printContent = document.getElementById("componentID");
      printContent.style.display = 'block';
      const WindowPrt = window.open('', '', 'left=0,top=0,width=900,height=900,toolbar=0,scrollbars=0,status=0');
      WindowPrt.document.write(printContent.innerHTML);
      WindowPrt.document.close();
      WindowPrt.focus();
      WindowPrt.print();
      WindowPrt.close();
      printContent.style.display = 'none';  
  });
</script>

<div id="componentID" style="display: none;">
    <div class="row">President Cafe</div><div class="row"> Bill No.: {{$viewBillDetails['invoice_number']}}</div><div class="row"> {{$viewBillDetails['ordered_date']}}  {{$viewBillDetails['ordered_time']}}</div><div class="row"> Total Items: {{$viewBillDetails['ordered_count']}}</div><table> <tr>  <td colspan="4">   -----------------------------------------------------------</td></tr><tr>  <td>S No</td>  <td>Item</td> <td>Price</td> <td>Qty</td>  <td>Amt</td></tr><tr>  <td colspan="4">   ----------------------------------------------------------- </td></tr>
        @for($i=0; $i < count($viewBillDetails['orders']); $i++)
        <tr><td>{{$i+1}}</td>  <td>{{$viewBillDetails['orders'][$i]['order_name']}}</td> <td>{{$viewBillDetails['orders'][$i]['order_price']}}rs</td> <td>{{$viewBillDetails['orders'][$i]['order_quantity']}}</td> <td>{{$viewBillDetails['orders'][$i]['total_price']}}</td></tr>  
        @endfor
        <td colspan="4">   ---------------------------------------------------------- </td></tr><tr>  <td></td>  <td></td>  <td style="font-weight: bolder">Grand Total = </td>  <td>{{$viewBillDetails['ordered_total']}}</td></tr><tr>  <td colspan="4">   ----------------------------------------------------------- </td></tr></table>
    </div>

    <!-- jQuery -->
    <script src="{{asset('dist/js/plugins.min.js')}}"></script>        
    <script src="{{asset('dist/js/common.js')}}"></script>
</body>
</html>