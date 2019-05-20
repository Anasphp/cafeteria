    <!-- header-->
    <style type="text/css">
    .navbar-header {
      display: none;
    }

  @media only screen and (max-width: 768px) {
          .navbar-header {
            display: block;
        }
    }

</style>
<div id="header-fix" class="header py-4 py-lg-2 fixed-top" style="margin-top: -63px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-3 col-xl-2 align-self-center">
                <div class="site-logo" style="margin-bottom: -16px;">
                    <a href="{{route('/')}}"><img src="{{asset('dist/images/cup.png')}}" style="height: 63px;
                    width: 78px;
                    margin-left: 93px;margin-top: 49px;"alt="" class="img-fluid" /></a>
                </div>
                <div class="navbar-header" >
                    <button type="button" id="sidebarCollapse" class="navbar-btn bg-transparent float-right">
                        <i class="glyphicon glyphicon-align-left"></i>
                        <span class="navbar-toggler-icon"></span>
                        <span class="navbar-toggler-icon"></span>
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
            <div class="col-12 col-lg-3 align-self-center d-none d-lg-inline-block">
                <form>

                </form>
            </div>
            <div class="col-12 col-lg-6 col-xl-7 d-none d-lg-inline-block">
                <nav class="navbar navbar-expand-lg p-0" style="    margin-top: 61px;">
                    <ul class="navbar-nav notification ml-auto d-inline-flex">
                        <li class="nav-item dropdown  align-self-center">
                               <!--  <a  class="nav-link p-3" data-toggle="dropdown" aria-expanded="false"><span class="lnr lnr-envelope h4 text-white"></span>
                                    <span class="ring-point">
                                        <span class="ring"></span>
                                    </span>
                                </a> -->
         <!--                        <ul class="dropdown-menu border-bottom-0 rounded-0 py-0">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="media py-2">
                                                <img src="asset('dist/images/author.jpg')" alt="" class="d-flex mr-3 img-fluid redial-rounded-circle-50" />
                                                <div class="media-body">
                                                    <h6 class="mb-0">john send a message</h6>
                                                    <small class="redial-light">12 min ago</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="media py-2">
                                                <img src="dist/images/author2.jpg" alt="" class="d-flex mr-3 img-fluid redial-rounded-circle-50" />
                                                <div class="media-body">
                                                    <h6 class="mb-0">Peter send a message</h6>
                                                    <small class="redial-light">15 min ago</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="media py-2">
                                                <img src="dist/images/author3.jpg" alt="" class="d-flex mr-3 img-fluid redial-rounded-circle-50" />
                                                <div class="media-body">
                                                    <h6 class="mb-0">Bill send a message</h6>
                                                    <small class="redial-light">5 min ago</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li><a class="dropdown-item text-center py-2" href="#"> <strong>Read All Message <i class="fa fa-angle-right pl-2"></i></strong></a></li>
                                </ul> -->
                            </li>
                            <li class="nav-item dropdown  align-self-center">
                               <!--  <a  class="nav-link p-3" data-toggle="dropdown" aria-expanded="false"><span class="lnr lnr-alarm h4 text-white"></span>
                                    <span class="ring-point">
                                        <span class="ring"></span>
                                    </span>
                                </a> -->
                                <ul class="dropdown-menu border-bottom-0 rounded-0 py-0">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="media py-2">
                                                <img src="dist/images/author.png" alt="" class="d-flex mr-3 img-fluid redial-rounded-circle-50" />
                                                <div class="media-body">
                                                    <h6 class="mb-0">john</h6>
                                                    <small class="redial-light"> New user registered. </small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="media py-2">
                                                <img src="dist/images/author2.jpg" alt="" class="d-flex mr-3 img-fluid redial-rounded-circle-50" />
                                                <div class="media-body">
                                                    <h6 class="mb-0">Peter</h6>
                                                    <small class="redial-light"> Server #12 overloaded. </small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="media py-2">
                                                <img src="dist/images/author3.jpg" alt="" class="d-flex mr-3 img-fluid redial-rounded-circle-50" />
                                                <div class="media-body">
                                                    <h6 class="mb-0">Bill</h6>
                                                    <small class="redial-light"> Application error. </small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li><a class="dropdown-item text-center py-3" href="#"> <strong>See All Tasks <i class="fa fa-angle-right pl-2"></i></strong></a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown user-profile align-self-center">
                                <a  class="nav-link" data-toggle="dropdown" aria-expanded="false"> 
                                    <span class="float-right pl-3 text-white"><i class="fa fa-angle-down"></i></span>
                                    <div class="media">
                                        <img src="{{asset('dist/images/author.png')}}" alt="" class="d-flex mr-3 img-fluid redial-rounded-circle-50" width="45" />
                                        <div class="media-body align-self-center">
                                            <p class="mb-2 text-white text-uppercase font-weight-bold">Sales Person</p>
                                            <small class="redial-primary-light font-weight-bold text-white"> @if(Session::has('username'))
                                            {{ Session::get('username')}} 
                                            @else 
                                            {{ Session::get('user')}}
                                            @endif
                                        </small>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu border-bottom-0 rounded-0 py-0">
                                    <li><a class="dropdown-item py-2" href="#"><i class="fa fa-user pr-2"></i> User Profile</a></li>
                                    @if(Session::get('openingBalance') == 0 && Session::get('user') != "Admin")
                                    <li><a class="dropdown-item py-2" href="{{route('addOpeningBalance')}}"><i class="fa fa-inr pr-2"></i> Add Opening Balance</a></li>
                                    @endif
                                    <li><a class="dropdown-item py-2" href="{{ route('logout') }}"><i class="fa fa-sign-out pr-2"></i> logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- End header-->

    <!-- Main-content Top bar-->
    <div class="redial-relative mt-80">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-2 align-self-center my-3 my-lg-0">
                    <h6 class="text-uppercase redial-font-weight-700 redial-light mb-0 pl-2">{{$title}}</h6>
                </div>
                <div class="col-12 col-md-4 align-self-center">
                    <div class="float-sm-left float-none mb-4 mb-sm-0">
                        <ol class="breadcrumb mb-0 bg-transparent redial-light">
                            <li class="breadcrumb-item"><a href="#" class="redial-light">Billing</a></li>
                            <li class="breadcrumb-item active">{{$title}}</li>
                        </ol>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="clearfix d-none d-md-inline">
                        <div class="float-sm-right float-none">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main-content Top bar-->