<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cup - Add Expenses</title>
    <link rel="icon" href="dist/images/cup.png" />

    <!--Plugin CSS-->
    <link href="dist/css/plugins.min.css" rel="stylesheet">

    <!--main Css-->
    <link href="dist/css/main.min.css" rel="stylesheet">
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
    @include('header', ['title' => "Add Expenses"])
    <!-- main-content-->
    <div class="wrapper">
        @include('sidebar')
        <div id="content">
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="row mb-4">
                        <div class="col-12 col-sm-12">
                            <div class="card redial-border-light redial-shadow">
                                <div class="card-body">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-6 col-sm-6">
                                            <div class="row">
                                                <div class="col-12 col-sm-12">
                                                     @if(Session::get('openingBalance') == 0)
                                                    <h6 class="header-title pl-3 redial-relative">
                                                    Expense - Add opening balance to add a expense
                                                    </h6>
                                                    @else
                                                    <form  data-toggle="validator" method="POST" action="/addExpenses" >
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <div class="form-group">
                                                            <label class="redial-font-weight-600">Purpose</label> 
                                                            <input type="text" name="purpose" placeholder="Enter Product Name" class="form-control" data-error="Purpose is required" required>
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="redial-font-weight-600">Price (INR)</label> 
                                                            <input type="number" name="expense_price" placeholder="Enter Price" class="form-control" data-error="Price is required" required>
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                        <button class="btn btn-primary btn-md redial-rounded-circle-50 btn-block">Add Expense</button>
                                                    </form>
                                                    @endif
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