<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cup - Monthly Reports</title>
    <link rel="icon" href="{{asset('dist/images/cup.png')}}" />

    <!--Plugin CSS-->
    <link href="{{asset('dist/css/plugins.min.css')}}" rel="stylesheet">

    <!--main Css-->
    <link href="{{asset('dist/css/main.min.css')}}" rel="stylesheet">
    <script src="{{asset('dist/jquery-1.12.4.min.js')}}"></script>
    <style type="text/css">
    .text-white {
        #fcde2e!important
    }</style>
    <script type="text/javascript">
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 30000);

        $('#single_day').on('change', function() {
           alert('changes');
       });
   </script>
   <script type="text/javascript">
    function dayValue(val) {
        if(val.value == "single") {
            const tableContent = document.getElementById("reportstable");
            if($( "#reportstable" ).html().length != 0 ) {
                $( "#reportstable" ).html("");
            }
            var style = $("#multiple_day").attr("style");
            if(style == 'display:block'){
                document.getElementById("multiple_day").setAttribute("style", "display:none");
            }
            document.getElementById("single_day").setAttribute("style", "display:block");
        } else {
            $('#to_date').attr('disabled','disabled');
            const tableContent = document.getElementById("reportstable");
            if($( "#reportstable" ).html().length != 0 ) {
                $( "#reportstable" ).html("");
            }
            var style = $("#single_day").attr("style");
            if(style == 'display:block'){
                document.getElementById("single_day").setAttribute("style", "display:none");
            }
            document.getElementById("multiple_day").setAttribute("style", "display:block");
        }
    }

    function singleDay(val) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
          type     : "POST",
          url      : '/takeSingleDayMonthlyReports',
          data     : {
            date   : val.value
        },
        cache    : false,
        success  : function(data) {
            revenue = data.amount;
            data = data.data;
            var html = "";
            for (var i =0 ; i < data.length; i++) {
              var no = i+1;
              html += "<tr><td>"+no+"</td>  <td>"+data[i]['products_name']+"</td> <td>"+data[i]['product_price']+"rs</td> <td>"+data[i]['product_quantity']+"</td> <td>"+data[i]['product_total']+"</td></tr>"
          }
          const tableContent = document.getElementById("reportstable");
          if($( "#reportstable" ).html().length != 0 ) {
            $( "#reportstable" ).html("");
        }
        var markup = '<div class="card redial-border-light redial-shadow mb-4">   <div class="card-body"><center><button type="button" id="print_single" class="report button2" onclick="printSingle()">Print Reports</button><button type="button" id="csv" onclick="csvSingle()" class="report button2">Download Csv</button></center><table class="table table-dark table-hover mb-0 redial-font-weight-500 table-responsive d-md-table"><thead><tr><th scope="col">S.No</th><th scope="col">Name</th><th scope="col">Price</th><th scope="col">Quantity</th><th scope="col">Amount</th></tr></thead><tbody>'+html+'</tbody></table></div></div><center><h3>Total Revenue : '+revenue+'</h3></center>';
        $('#reportstable').append(markup);
        tableContent.style.display = 'block';
    }
})
    }
    function printSingle() {
       $.ajax({
        type     : "POST",
        url      : '/takeSingleDayMonthlyReports',
        data     : {
            date   : $('#single_date').find(":selected").text()
        },
        cache    : false,
        success  : function(data) {
            var shifts = data.shift;
            var amount = data.amount;
            var data = data.data;
            var date = $('#single_date').find(":selected").text();
            var html = "";
            for (var i =0 ; i < data.length; i++) {
                var no = i+1;
                html += "<tr><td>"+no+"</td>  <td>"+data[i]['products_name'].charAt(0).toUpperCase()+data[i]['products_name'].slice(1)+"</td>  <td>"+data[i]['product_quantity']+"</td> <td>"+data[i]['product_total']+"</td></tr>";
            }
            const printContent = document.getElementById("printReport");
            var markup = '<div class="row"><h3>President Cafe</h3>  </div><div class="row"> --------------------------------------</div><div class="row"> Shift : '+shifts+'</div><div class="row"> Date : '+date+'</div><div class="row"> Total Items: '+data.length+'</div><table> <tr>  <td colspan="4">   -------------------------------------- </td></tr><tr>  <td>S No</td>  <td>Item</td><td>Qty</td>  <td>Amt</td></tr><tr>  <td colspan="4">   --------------------------------------</td></tr>'+html+'  <td colspan="4">   -------------------------------------</td></tr><tr><td></td>  <td></td>  <td style="font-weight: bolder">Grand Total : </td>  <td>'+amount+'</td></tr> <td colspan="4">   -------------------------------------- </td></tr></table><div class="row"> <h4 style="text-align: center;">Thank you</h4></div>';
            $('#printReport').append(markup);
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
   }


   function csvSingle() {
       var date = $('#single_date').find(":selected").text(); 
       $.ajax({
        type     : "GET",
        url      : '/takeSingleDayCsv/'+date+'',
        cache    : false,
        success  : function(data) {
            var date = $('#single_date').find(":selected").text(); 
            url ='/takeSingleDayCsv/'+date+'';
            var win = window.open(url, '_blank');
            win.focus();
        }
    })
   }

   function multipleDays(val) {
    var fromDate = $('#from_date').find(":selected").text();
    var toDate = $('#to_date').find(":selected").text();
    if(fromDate == 'Select Date' || toDate == 'Select Date') {
        console.log('here');
        return false;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    formdata = {
        from : fromDate,
        to : toDate
    }
    $.ajax({
      type     : "POST",
      url      : '/takeMultipleDayMonthlyReports',
      data     : {
        date   : formdata
    },
    cache    : false,
    success  : function(data) {
        var data = data.data;
        if(data.length != 0) {
            var revenue = 0;
            var html = "";
            for (var i =0 ; i < data.length; i++) {
              var no = i+1;
              html += "<tr><td>"+no+"</td>  <td>"+data[i]['name']+"</td> <td>"+data[i]['price']+"rs</td> <td>"+data[i]['quantity']+"</td> <td>"+data[i]['amount']+"</td></tr>";
              revenue = data[i]['revenue'];
          }
          const tableContent = document.getElementById("reportstable");
          if($( "#reportstable" ).html().length != 0 ) {
            $( "#reportstable" ).html("");
        }
        var markup = '<div class="card redial-border-light redial-shadow mb-4">   <div class="card-body"><center><button class="report button2" onclick="printMultiple()">Print Reports</button><button type="button" onclick="csvMultiple()" class="report button2">Download Csv</button></center><table class="table table-dark table-hover mb-0 redial-font-weight-500 table-responsive d-md-table"><thead><tr><th scope="col">S.No</th><th scope="col">Name</th><th scope="col">Price</th><th scope="col">Quantity</th><th scope="col">Amount</th></tr></thead><tbody>'+html+'</tbody></table></div></div><center><h3>Total Revenue : '+revenue+'</h3></center>';
        $('#reportstable').append(markup);
        tableContent.style.display = 'block';
    } else {
        const tableContent = document.getElementById("reportstable");
        if($( "#reportstable" ).html().length != 0 ) {
            $( "#reportstable" ).html("");
        }
        var markup = '<center><h4>No Data Availables For this selecetd Dates</h4></center>';
        $('#reportstable').append(markup);
        tableContent.style.display = 'block';
    }
}
})
}

function printMultiple() {
    var fromDate = $('#from_date').find(":selected").text();
    var toDate = $('#to_date').find(":selected").text();
    if(fromDate == 'Select Date' || toDate == 'Select Date') {
        console.log('here');
        return false;
    }
    formdata = {
        from : fromDate,
        to : toDate
    }
    $.ajax({
        type     : "POST",
        url      : '/takeMultipleDayMonthlyReports',
        data     : {
            date   : formdata
        },
        cache    : false,
        success  : function(data) {
            var shifts = data.shift;
            var data = data.data;
            // var amount = data.revenue;
            var html = "";
            for (var i =0 ; i < data.length; i++) {
                var no = i+1;
                html += "<tr><td>"+no+"</td>  <td>"+data[i]['name'].charAt(0).toUpperCase()+data[i]['name'].slice(1)+"</td>  <td>"+data[i]['quantity']+"</td> <td>"+data[i]['amount']+"</td></tr>";
                revenue = data[i]['revenue'];
            }
            const printContent = document.getElementById("printReport");
            var markup = '<div class="row"><h3>CUP</h3>  </div><div class="row"> --------------------------------------</div><div class="row"> Shift : '+shifts+'</div><div class="row"> Date : '+fromDate+' to '+toDate+'</div><div class="row"> Total Items: '+data.length+'</div><table> <tr>  <td colspan="4">   -------------------------------------- </td></tr><tr>  <td>S No</td>  <td>Item</td><td>Qty</td>  <td>Amt</td></tr><tr>  <td colspan="4">   --------------------------------------</td></tr>'+html+'  <td colspan="4">   -------------------------------------</td></tr><tr><td></td>  <td></td>  <td style="font-weight: bolder">Grand Total : </td>  <td>'+revenue+'</td></tr> <td colspan="4">   -------------------------------------- </td></tr></table><div class="row"> <h4 style="text-align: center;">Thank you</h4></div>';
            $('#printReport').append(markup);
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
}

    function csvMultiple() {
       var date = $('#single_date').find(":selected").text(); 
       var fromdate = $('#from_date').find(":selected").text(); 
       var todate = $('#to_date').find(":selected").text(); 
       $.ajax({
        type     : "GET",
        url      : '/takeMultipleDayCsv/'+fromdate+'/'+todate+'',
        cache    : false,
        success  : function(data) {
            url ='/takeMultipleDayCsv/'+fromdate+'/'+todate+'';
            var win = window.open(url, '_blank');
            win.focus();
        }
    })
}
</script>
<script type="text/javascript">

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
<style type="text/css">
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
</style>
</head>
<body>
    @include('header', ['title' => "Monthly Reports"])
    <div class="wrapper">
        @include('adminsidebar')
        <div id="content">
            <div class="row mb-4">
                <div class="col-12 col-sm-12">
                    <div class="row">
                        <div class="col-12 col-md-12 mb-4">
                            <div class="card redial-border-light redial-shadow">
                                <div class="card-body" style="overflow: visible;">
                                    <h6 class="header-title pl-3 redial-relative">Monthly Reports - {{Session::get('shift')}}</h6> 
                                    <form>
                                        <div class="row">
                                            <div class="col-12 col-sm-2 text-sm-right align-self-center">
                                                <label class="redial-font-weight-600 mb-3">Days</label>
                                            </div>
                                            <div class="col-12 col-sm-10">
                                                <div class="row">
                                                    <div class="col-12 col-sm-6">
                                                        <div class="form-group">
                                                            <select class="fancy-select form-control" id="days" name="days" onchange="dayValue(this);">
                                                                <option value="">Select Days</option>
                                                                <option value="single">Take Reports for Single Day</option>
                                                                <option value="multiple">Take Reports for Multiple Days</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="single_day" style="display:none">
                                            <div class="col-12 col-sm-2 text-sm-right align-self-center">
                                                <label class="redial-font-weight-600 mb-3">Choose Date</label>
                                            </div>
                                            <div class="col-12 col-sm-10">
                                                <div class="row">
                                                    <div class="col-12 col-sm-6">
                                                        <div class="form-group">
                                                            <select class="fancy-select form-control" id="single_date" onchange="singleDay(this);">
                                                                <option value="">Select Date</option>
                                                                @foreach($fetchDate->reverse() as $date)
                                                                <option value="{{$date['date']}}">{{$date['date']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="multiple_day" style="display:none">
                                            <div class="col-12 col-sm-2 text-sm-right align-self-center">
                                                <label class="redial-font-weight-600 mb-3">From</label>
                                            </div>
                                            <div class="col-12 col-sm-10">
                                                <div class="row">
                                                    <div class="col-12 col-sm-3">
                                                        <div class="form-group">
                                                            <select class="fancy-select form-control" id="from_date" onchange="multipleDays(this);" >
                                                                <option value="">Select Date</option>
                                                                @foreach($fetchDate as $date)
                                                                <option value="{{$date['date']}}">{{$date['date']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <label class="redial-font-weight-600 mb-3">To </label>
                                                    <div class="col-12 col-sm-3">
                                                        <div class="form-group">
                                                            <select class="fancy-select form-control" id="to_date" onchange="multipleDays(this);">
                                                                <option value="">Select Date</option>
                                                                @foreach($fetchDate->reverse() as $date)
                                                                <option value="{{$date['date']}}">{{$date['date']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="reportstable" style="display:none"></div>
                                    </form>
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

<div id="printReport" style="display: none">
</div>
<!-- End main-content-->


<!-- Top To Bottom-->
<a href="#" class="scrollup text-center redial-bg-primary redial-rounded-circle-50" >
 <h4 class="text-white mb-0"><i class="icofont icofont-long-arrow-up"></i></h4>
</a>
<!-- End Top To Bottom-->    <!-- jQuery -->

<script src="{{asset('dist/js/plugins.min.js')}}"></script>        
<script src="{{asset('dist/js/common.js')}}"></script>
</body>
</html>