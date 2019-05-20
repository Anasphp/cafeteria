<nav id="sidebar" class="card redial-border-light px-2 mb-4">
    <div class="sidebar-scrollarea">
        <ul class="metismenu list-unstyled mb-0" id="menu">
            <li><a href="{{ url('/admindashboard') }}"><i class="fa fa-dashboard pr-1"></i> Dashboard</a></li>
            @if(Session::has('shift'))
            <li><a href="{{ url('/revenue') }}"><i class="fa fa-inr pr-1"></i>  &nbsp;&nbsp;Daily Revenue</a></li>
            <li><a href="{{ url('/monthlyReports') }}"><i class="fa fa-calendar-check-o pr-1"></i> Monthly Reports</a></li>
            <li><a href="{{ url('/listTotalBills') }}"><i class="fa fa-credit-card pr-1"></i> View Total Bills</a></li>

            <!-- <li><a href="{{ url('/setGst') }}"><i class="fa fa-percent pr-1"></i> Set GST</a></li> -->
            @endif
        </ul>
    </div>
</nav>