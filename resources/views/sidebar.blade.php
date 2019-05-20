<nav id="sidebar" class="card redial-border-light px-2 mb-4">
    <div class="sidebar-scrollarea">
        <ul class="metismenu list-unstyled mb-0" id="menu">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard pr-1"></i> Dashboard</a></li>
            @if(Session::has('openingBalance'))
            <li><a href="{{ url('/createBill') }}"><i class="fa fa-book pr-1"></i> Create Bill</a></li>
            <li><a href="{{ url('/listTodayBill') }}"><i class="fa fa-clipboard pr-1"></i> Today Bills</a></li>
            <!-- <li><a href="{{ url('/listBill') }}"><i class="fa fa-files-o pr-1"></i> Overall Bills</a></li> -->
            <li><a href="{{ url('/reports') }}"><i class="fa fa-file pr-1"></i> Reports</a></li>
            <li><a href="{{ url('/addProducts') }}"><i class="fa fa-cart-plus pr-1"></i> Add Products</a></li>
            <li><a href="{{ url('/listProducts') }}"><i class="icofont icofont-shopping-cart pr-1"></i> List Products</a></li>
            <li><a href="{{ url('/addExpenses') }}"><i class="fa fa-money pr-1"></i> Add Expenses</a></li>
            <li><a href="{{ url('/listExpenses') }}"><i class="fa fa-list-alt pr-1"></i> List Expenses</a></li>
 <!--            <li><a href="{{ url('/monthlyReports') }}"><i class="fa fa-calendar-check-o pr-1"></i> Monthly Reports</a></li>
            <li><a href="{{ url('/listTotalBills') }}"><i class="fa fa-credit-card pr-1"></i> View Total Bills</a></li> -->
            <!-- <li><a href="{{ url('/setGst') }}"><i class="fa fa-percent pr-1"></i> Set GST</a></li> -->
            @endif
        </ul>
    </div>
</nav>