<?php 
$bill = $data['bill'];
$order = $data['order'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Billing - Bill View </title>
  <link rel="icon" href="dist/images/cup.png" />
  <!--   <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> -->
  <!--Plugin CSS-->
  <link href="dist/css/plugins.min.css" rel="stylesheet">
  <!--main Css-->
  <link href="dist/css/main.min.css" rel="stylesheet">
    <script src="{{asset('dist/jquery-1.12.4.min.js')}}"></script>
  <style>
  .invoice-box {
    max-width: 800px;
    margin: auto;
    padding: 30px;
    border: 1px solid #eee;
    box-shadow: 0 0 10px rgba(0, 0, 0, .15);
    font-size: 16px;
    line-height: 24px;
    font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    color: #555;
  }

  .invoice-box table {
    width: 100%;
    line-height: inherit;
    text-align: left;
  }

  .invoice-box table td {
    padding: 5px;
    vertical-align: top;
  }

  .invoice-box table tr td:nth-child(2) {
    text-align: right;
  }

  .invoice-box table tr.top table td {
    padding-bottom: 20px;
  }

  .invoice-box table tr.top table td.title {
    font-size: 45px;
    line-height: 45px;
    color: #333;
  }

  .invoice-box table tr.information table td {
    padding-bottom: 40px;
  }

  .invoice-box table tr.heading td {
    background: #eee;
    border-bottom: 1px solid #ddd;
    font-weight: bold;
  }

  .invoice-box table tr.details td {
    padding-bottom: 20px;
  }

  .invoice-box table tr.item td{
    border-bottom: 1px solid #eee;
  }

  .invoice-box table tr.item.last td {
    border-bottom: none;
  }

  .invoice-box table tr.total td:nth-child(2) {
    border-top: 2px solid #eee;
    font-weight: bold;
  }

  @media only screen and (max-width: 600px) {
    .invoice-box table tr.top table td {
      width: 100%;
      display: block;
      text-align: center;
    }

    .invoice-box table tr.information table td {
      width: 100%;
      display: block;
      text-align: center;
    }
  }

  /** RTL **/
  .rtl {
    direction: rtl;
    font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
  }

  .rtl table {
    text-align: right;
  }

  .rtl table tr td:nth-child(2) {
    text-align: left;
  }

  @media all{
   printed-div{
       display:none;
   }
}

@media print{
   printed-div{
       display:block;
   }
   .logo-print{
       width:291px;
       height:109px;
       display: list-item;
       list-style-image: url(../images/logo_print.png);
       list-style-position: inside;
   }
}
</style>

</head>
<body>
  @include('header', ['title' => "View Bill"])

  <!-- main-content-->
  <div class="wrapper">
    @include('sidebar')
    <div id="content">
      <div class="row">
        <div class="col-12 col-sm-12">
          <div class="card redial-border-light redial-shadow mb-4 custom-tabs">
            <div class="card-body" style="height: 904px;">
              <h6 class="header-title pl-3 redial-relative">View Bill</h6>
              <div style="margin-left: 331px;">
                <button type="button" class="apply-gst btn btn-primary btn-xs" id="gst">Apply Gst</button>
                <button type="button" class="remove-gst btn btn-primary btn-xs" style="width: 103px;" id="igst">Apply Igst</button>
              </div>
              <br>
              <div class="invoice-box">
                <input type="hidden" name="Igst" value="{{$data['gst']['igst_percentage']}}">
                <table cellpadding="0" cellspacing="0" id="bill_print">
                  <tr class="top">
                    <td colspan="2">
                      <table>
                        <tr>
                          <td class="title">
                            <div class="printed-div"></div>
                            <div class="logo-print"> </div>
                          </td>
                          <td>
                            Invoice #: {{$bill->invoice_number}}<br>
                            Date: {{$bill->ordered_date}}<br>
                            Time: {{$bill->ordered_time}}
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>

                  <tr class="information">
                    <td colspan="2">
                      <table>
                        <tr>
                          <td>
                            Chrono Pvt. Ltd. , Madipakkam<br>
                            Chennai
                          </td>

                          <td>
                            Mobile:987456321<br>
                            solutions@chrono.com<br>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>

                  <tr class="heading">
                    <td>
                      Total Count
                    </td>

                    <td>
                      {{$bill->ordered_count}} Products
                    </td>
                  </tr>
                  @foreach ($order as $orders)
                  <tr class="heading">
                    <td>
                      {{$orders->order_name}}({{$orders->order_size}}) * 5
                    </td>

                    <td>
                      &#x20b9; {{$orders->total_price}}
                    </td>
                  </tr>
                  @endforeach

                  <tr class="total">
                    <td></td>
                    <td id="total_amount">
                      Total: &#x20b9; {{$data['sum']}}<br>
                    </td>
                    <td id="gst_value" style="display:none;">
                     Total: &#x20b9; {{$data['sum']}}<br>
                     cgst ({{$data['gst']['cgst_percentage']}}&#37;) : &#x20b9; {{$data['gst']['cgst_percentage']/100*$data['sum']}}<br>
                     sgst ({{$data['gst']['sgst_percentage']}}&#37;) : &#x20b9; {{$data['gst']['sgst_percentage']/100*$data['sum']}}<br>
                     gst ({{$data['gst']['total_gst_percentage']}}&#37;) : &#x20b9; {{$data['gst']['total_gst_percentage']/100*$data['sum']}}<br>
                     Grand Total : {{$data['grandTotal']}}
                   </td>
                   <td id="igst_value" style="display:none;">
                     Total: &#x20b9; {{$data['sum']}}<br>
                     Igst ({{$data['gst']['igst_percentage']}}&#37;) : &#x20b9; {{$data['gst']['igst_percentage']/100*$data['sum']}}<br>
                     Grand Total : {{$data['grandTotal']}}
                   </td>
                 </tr>
               </table>
               <button style="width: 400px; margin-left: 173px" class="btn btn-primary btn-md redial-rounded-circle-50 btn-block" onclick="printDiv()">Print Bill</button>
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>  
<script>
  function printDiv() {
    var divToPrint = document.getElementById('bill_print');
    newWin = window.open("");
    newWin.document.write(divToPrint.outerHTML);
    newWin.print();
    newWin.close();
  }
</script>
<script type="text/javascript">
  $("#igst").click(function () {
   $('#total_amount').html($('#igst_value').html());
 });
  $("#gst").click(function () {
   $('#total_amount').html($('#gst_value').html());
 });
</script>

</body>
</html>