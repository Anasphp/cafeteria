<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cup - Reports</title>
    <link rel="icon" href="dist/images/cup.png" />

    <!--Plugin CSS-->
    <link href="dist/css/plugins.min.css" rel="stylesheet">

    <!--main Css-->
    <link href="dist/css/main.min.css" rel="stylesheet">
</head>
<body>
    @include('header', ['title' => "Reports"])

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
                                            <h6 class="header-title pl-3 redial-relative">Reports  
                                                @if(Session::get('openingBalance') == 0)
                                                - Add Opening balance before taking a reports
                                                @endif
                                                @if (count($report) > 0 && Session::get('openingBalance') != 0)
                                                <center><button id="report" class="report button2">Take Reports</button>
                                                    <button id="shift" type="button" class="report button2">Close My Shift</button>
                                                </center>
                                                @endif
                                            </h6>
                                            <table class="table table-dark table-hover mb-0 redial-font-weight-500 table-responsive d-md-table">
                                                @if (count($report) > 0)
                                                <thead>
                                                    <tr>
                                                        <th scope="col">S.No</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = $report->perPage() * ($report->currentPage() - 1) + 1; ?>
                                                    @foreach($report as $data)
                                                    <tr>
                                                        <th>{{$i++}}</th>
                                                        <td>{{ucwords($data->products_name)}}</td>
                                                        <td>
                                                            {{$data->product_price}}
                                                        </td>
                                                        <td>{{$data->product_quantity}}</td>
                                                        <td>{{$data->product_total}}</td></tr>
                                                        @endforeach
                                                    </tbody>
                                                    @else
                                                    <center>Reports Not Available</center>
                                                    @endif
                                                </table>
                                                <center>
                                                    {{ $report->links() }}
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
        <script type="text/javascript">
          $( "#report" ).click(function() {
              $.ajax({
                type     : "GET",
                url      : '/takeReports',
                cache    : false,
                success  : function(data) {
                    var totalBill = data['total_bills'];
                    var shifts = data['shift'];
                    var amount = data['amount'];
                    var date = data['today_date'];
                    var time = data['today_time'];
                    var openingBalance = data['openingBalance']['opening_balance_amount'];
                    var total = parseInt(amount) + parseInt(openingBalance);
                    var data = data['data'];
                    var html = "";
                    for (var i =0 ; i < data.length; i++) {
                        var no = i+1;
                        html += "<tr><td>"+no+"</td>  <td>"+data[i]['products_name'].charAt(0).toUpperCase()+data[i]['products_name'].slice(1)+"</td>  <td>"+data[i]['product_quantity']+"</td> <td>"+data[i]['product_total']+"</td></tr>";
                    }
                    const printContent = document.getElementById("componentID");
                    var markup = '<div class="row"><h3>President Cafe</h3>  </div><div class="row"> --------------------------------------</div><div class="row"> Shift : '+shifts+'</div><div class="row"> Date : '+date+' '+time+'</div><div class="row"> Total Items: '+data.length+'</div><div class="row"> Total Bills: '+totalBill+'</div><table> <tr>  <td colspan="4">   -------------------------------------- </td></tr><tr>  <td>S No</td>  <td>Item</td><td>Qty</td>  <td>Amt</td></tr><tr>  <td colspan="4">   --------------------------------------</td></tr>'+html+'  <td colspan="4">   -------------------------------------</td></tr><tr><td></td>  <td></td>  <td style="font-weight: bolder">Today Sale</td>  <td>'+amount+'</td></tr><tr>  <td></td>  <td></td>  <td style="font-weight: bolder">Remaining Balance </td>  <td>'+openingBalance+'</td></tr><tr>  <td></td>  <td></td>  <td style="font-weight: bolder">Grand Total</td>  <td>'+total+'</td></tr><tr>  <td colspan="4">   -------------------------------------- </td></tr></table><div class="row"> <h4 style="text-align: center;">Thank you</h4></div>';
                    $('#componentID').append(markup);
                    var html = printContent.innerHTML;
                    printContent.style.display = 'block';
                    const WindowPrt = window.open('', '', 'left=0,top=0,width=900,height=900,toolbar=0,scrollbars=0,status=0');
                    WindowPrt.document.write(printContent.innerHTML);
                    WindowPrt.document.close();
                    WindowPrt.focus();
                    WindowPrt.print();
                    WindowPrt.close();
                    location.reload(true);
                    printContent.style.display = 'none';
                }
            })
          });
          $( "#shift" ).click(function() {
            var txt;
            var alert = confirm("Are you sure?");
            if (alert == true) {
                $.ajax({
                    type     : "GET",
                    url      : '/shiftCloses',
                    cache    : false,
                    success  : function(data) {
                    location.reload(true);
                    } 
                });
            } else { 
              location.reload(true);
          }
      });
  </script>
  <div id="componentID" style="display: none">
  </div>
</body>
</html>