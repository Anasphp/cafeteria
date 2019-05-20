<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Cup - Create Bill</title>
  <link rel="icon" href="dist/images/cup.png" />

  <link href="dist/css/plugins.min.css" rel="stylesheet">
  <!--main Css-->
  <link href="dist/css/main.min.css" rel="stylesheet">
    <script src="{{asset('dist/jquery-1.12.4.min.js')}}"></script>
  <script type="text/javascript">
         //window.onbeforeunload = function() {
           // return "Dude, are you sure you want to leave?";
          //}
          function addCurrentProduct(){
            if($("#name").val() =="" ||  $("#size").val()=="" || $("#price").val() =="" || $("#quantity").val()=="") {
              alert("All Fields Required");
              return false;
            }
            var bills_id = $("#current_bill").attr('value');
            if(bills_id == undefined) {
              bills_id = 0;
            }
              // console.log(bills_id);
              $('#dataTable').css("display","inline-block");
              $('button').css("display","inline-block");
              var formData = {
                name     : $.trim($("#name").val().split('-')[0]),
                price    : $("#price").val(),
                quantity : $("#quantity").val(),
                bill     : bills_id
              }
              // console.log(formData);
              $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });
              $.ajax({
                type     : "POST",
                url      : '/addCurrentProduct',
                data     : formData,
                cache    : false,
                success  : function(data) {
                  var total = data['total'];
                  var data = data['data'];
                  if (data == null || data == "") {
                    return false;
                  } else {
                    toastr.success('Success  <br /> Item Added Successfully');
                    $('#name').typeahead('val', '');
                    $("#name").removeAttr('disabled');
                    $("#price").removeAttr('disabled');
                    $("#name").val('');
                    $("#price").val('');
                    $("#quantity").val('');
                    $('#name').focus();
                    var markup = "<tr id='current_bill' value='"+data['bills_id']+"' name='row'><td><input type='checkbox' name='record' id='"+data['orders_id']+"'></td><td>" + data['order_name'] + "</td><td>" + data['order_price'] + "</td><td>" + data['order_quantity'] + "</td><td>" + data['total_price'] + "</td></tr>";
                    var total = "<th colspan='4' style='text-align: right;'>Grand Total</th><td>"+ total +"</td>";
                    $("#table_body").append(markup);
                    $("#grand_total").html(total);
                  }
                }
              }) 
            }
            $(document).ready(function(){
              $('#quantity').keyup(function (e) {

               if(e.keyCode == 13)  // the enter key code
               {
               e.stopImmediatePropagation();
                addCurrentProduct();
                return false;
              } else if(e.keyCode == 27) {
               $("#refresh_values").trigger('click');
             }
           });   
              $(".add-product").click(function(){
                addCurrentProduct();
                return false;
              });

              // Find and remove selected table rows
              $(".delete-product").click(function(){
                var bills_id = $("#current_bill").attr('value');
                if(bills_id == undefined) {
                  bills_id = 0;
                }
                $("table tbody").find('input[name="record"]').each(function(){
                  if($(this).is(":checked")){
                   $("input:checkbox[name=record]:checked").each(function () {
                    $.ajax({
                      type     : "POST",
                      url      : '/deleteCurrentProduct',
                      data     : {
                        id: $(this).attr("id"),
                        bill: bills_id
                      },
                      cache    : false,
                      success  : function(data) {
                        toastr.success('Success  <br /> Item Removed Successfully');
                        var total = "<th colspan='4' style='text-align: right;'>Grand Total</th><td>"+ data['ordered_total'] +"</td>";
                        console.log(total);
                        $("#grand_total").html(total);
                      }
                    })
                    $(this).parents("tr").remove();

                  });
                 }
               });
              });
            });    

          </script>


          <style type="text/css">
          form{
           margin: 20px 0;
         }
         form input, button{
           padding: 5px;
         }
         table{
           width: 100%;
           margin-bottom: 20px;
           border-collapse: collapse;
         }
         table, th, td{
           border: 1px solid #cdcdcd;
         }
         table th, table td{
           padding: 10px;
           text-align: left;
         }
         .form-select input[type="checkbox"]{
           position:inherit !important;
           visibility: visible;
         }
       </style>
     </head>
     <body>
      @include('header', ['title' => "Create Bill"])
      <!-- main-content-->
      <div class="wrapper">
       @include('sidebar')
       <div id="content">
        <div class="row">
         <div class="col-12 col-sm-12">
          <div class="card redial-border-light redial-shadow mb-4 custom-tabs">
           <div class="card-body" style="height: 904px;">
            <h6 class="header-title pl-3 redial-relative">Create Bill - Note : Don't Reload the page after the item is added</h6>
            <h6> </h6>
  <!-- <h6 id="note" style="display: block;">Click a Undo Button to empty the text.</h6>
    <h6 id="note" style="display: block;">Press Enter Or Tab to proceed</h6> -->
    <div class="form-select">
     <form action="" method="post">
      <div class="form-group" data-book-index=0>
       <div class="col-xs-3">
        <input type="text" class="form-control" name="bill[name][]" placeholder="Name" id="name" autocomplete="off"  required   />
      </div>
      <div class="col-xs-2">
        <input type="text" class="form-control" name="bill[price][]" placeholder="Price" id="price" required />
      </div>
      <div class="col-xs-2">
        <input type="text" class="form-control" name="bill[price][]" placeholder="Quantity" id="quantity" required autocomplete="off"/>
      </div>
      <div class="col-xs-1">
        <button type="button" class="btn btn-primary" id="refresh_values"><i class="fa fa-undo"></i> </button>
        <button type="button" class="btn btn-primary addButton add-product"><i class="fa fa-plus"></i> </button>
      </div>
    </div>
  </form>
  <div id="dataTable" style="display: none; width: 982px;">
    <table>
     <thead>
      <tr>
       <th>Select</th>
       <th>Product Name</th>
       <!-- <th>Product Size</th> -->
       <th>Product Prize</th>
       <th>Quantity</th>
       <th>Total</th>
     </tr>
   </thead>
   <tbody id="table_body">

   </tbody>
   <tr id="grand_total">

   </tr>
 </table>
</div>
<div>                
  <button type="button" class="delete-product btn btn-primary btn-xs" style="display: none;">Remove Product</button>
  <button id="submit" type="button" class="submit-order btn btn-primary btn-xs" style="display: none;">Submit Order</button>
  <button id="cancel" type="button" class="cancel-order btn btn-primary btn-xs" style="display: none;">Cancel Order</button>        
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
<!-- jQuery -->
<script src="dist/js/plugins.min.js"></script>
<script src="dist/js/common.js"></script>
<script src="{{asset('dist/jquery-3.2.1.js')}}"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->


<!-- Import typeahead.js -->
<script src="{{asset('dist/typeahead.bundle.js')}}"></script>

<!-- Initialize typeahead.js on the input -->
<script src="dist/js/jquery.double-keypress.js"></script>  

<script>

  var keyCode = 13;
  // $('#quantity').dbKeypress(keyCode, function(e){
  //   printBill(0);
  // });

  $('#quantity').on('keyup', function(e){
   if(e.keyCode == 32){
    e.stopImmediatePropagation();
    if($("#name").val() =="" || $("#price").val() =="" || $.trim($('#quantity').val())=="") {
      alert("All Fields Required");
      return false;
    } else {
      addCurrentProduct();
     printBill($("#current_bill").attr('value'));
    }
    return false;
  } 
});

  $("#submit").on('click', function() {
    printBill($("#current_bill").attr('value'));
  });

  function printBill(id) {
    var id = id;
    $.ajax({
      type     : "POST",
      url      : '/submitOrder',
      data     : {
        id     : id,
      },
      cache    : false,
      success  : function(data) {
        var formData = {
          id     : data.bills_id,
        }
        $.ajax({
          type     : "POST",
          url      : '/updateReports',
          data     : formData,
          cache    : false,
          success  : function(data) {
            console.log("success");
          }
        })
        var html = "";
        for (var i =0 ; i < data.orders.length; i++) {
          var no = i+1;
          html += "<tr><td>"+no+"</td><td>"+data.orders[i]['order_name']+"</td> <td>"+data.orders[i]['order_price']+"rs</td> <td>"+data.orders[i]['order_quantity']+"</td> <td>"+data.orders[i]['total_price']+"</td></tr>"
        }
        const printContent = document.getElementById("componentID");
        var markup = '<div class="row">President Cafe</div><div class="row"> Bill No.: '+data['invoice_number']+'</div><div class="row"> '+data['ordered_date']+'  '+data['ordered_time']+'</div><div class="row"> Total Items: '+data['ordered_count']+'</div><table> <tr>  <td colspan="4">   -----------------------------------------------------------</td></tr><tr>  <td>S No</td>  <td>Item</td> <td>Price</td> <td>Qty</td>  <td>Amt</td></tr><tr>  <td colspan="4">   ----------------------------------------------------------- </td></tr>'+html+'  <td colspan="4">   ---------------------------------------------------------- </td></tr><tr>  <td></td>  <td></td>  <td style="font-weight: bolder">Grand Total = </td>  <td>'+data['ordered_total']+'</td></tr><tr>  <td colspan="4">   ----------------------------------------------------------- </td></tr></table>';
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
  }

  $(".form-group").on('click', function() {
    if($("#name").val() != ''){
      autocomplete();
    }
  });


  $("#cancel").on('click', function() {
    $.ajax({
      type     : "POST",
      url      : '/cancelOrder',
      data     : {
        id     : $("#current_bill").attr('value'),
      },
      cache    : false,
      success  : function(data) {
       location.reload(true);
     }
   })
  });

  $("#refresh_values").on('click', function() {
    $('#name').typeahead('val', '');
    $("#name").removeAttr('disabled');
    $("#price").removeAttr('disabled');
    $("#name").val('');
    $("#price").val('');
    $("#quantity").val('');
    $('#name').focus();

    // $("#name").val('');
  });

  $("#name").on('keyup', function(e) {
    var value = $("#name").val();
    if (value === '') {
     $("#price").val('');
   }
   var keyCode = e.keyCode || e.which; 
   if ((keyCode == 9 && $("#name").val() != '') || (keyCode == 13 && $("#name").val() != '')) {
     e.preventDefault();
     autocomplete();
   }
 });

  function autocomplete(){
    var value = $("#name").val();
    var formData = {
      value     : value,
    }
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type     : "POST",
      url      : '/getSizePrice',
      data     : formData,
      cache    : false,
      success  : function(data) {
        if(data != ''){
          $("#price").val(data.products_price);
          $("#name").attr('disabled','disabled');
          $("#price").attr('disabled','disabled');
          $('#quantity').focus();
        }
      }
    })
  } 

  $(document).ready(function() {
    var bloodhound = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.whitespace,
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      remote: {
        url: '/product/find?q=%QUERY%',
        wildcard: '%QUERY%'
      },
    });
    $('#name').typeahead({
      hint: false,
      highlight: true,
      minLength: 1
    }, {
      name: 'users',
      source: bloodhound,
      display: function(data) {
        // console.log(data);
        var data = data.products_name
        return data;
      },
      templates: {
        empty: [
        // '<div class="list-group search-results-dropdown"><div class="list-group-item">Not  found.</div></div>'
        ],
        header: [
        '<div class="list-group search-results-dropdown">'
        ],
        suggestion: function(data) {
          return '<div style="font-weight:normal; margin-top:-10px ! important;" class="list-group-item" id="search" product-id="'+ data.products_id +'">' + data.products_name +'</div></div>'
        }
      }
    }); 
  });
</script>

<div id="componentID" style="display: none">
</div>
</body>
</html>