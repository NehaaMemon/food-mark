<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>

        </ul>

    </form>
    <ul class="navbar-nav navbar-right">
        @php
            $notifications = App\Models\OrderPlacedNotification::where('seen',0)->latest()->take(10)->get();
        @endphp

        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link notification-toggle nav-link-lg notification_beep {{ count($notifications) > 0 ? 'beep' : '' }}"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Notifications
                    <div class="float-right">
                        <a href="{{ route('admin.clear-notification') }}">Mark All As Read</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons rt_notification">
                        @foreach($notifications as $notification)

                        <a href="{{ route('admin.orders.show',$notification->order_id) }}" class="dropdown-item">
                            <div class="dropdown-item-icon bg-info text-white">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="dropdown-item-desc">
                               {{ $notification->message }}
                                <div class="time">{{ date('h:i A | d-F-Y',strtotime($notification->created_at)) }}</div>
                            </div>
                        </a>
                        @endforeach
                </div>
                <div class="dropdown-footer text-center">
                    <a href="{{ route('admin.orders.index') }}">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li>

        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ auth()->user()->avatar }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi,{{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">

                <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>

                <a href="{{ route('admin.setting.index') }}" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf


                    <a href="#"
                        onclick="event.preventDefault();
                    this.closest('form').submit();"
                        class="dropdown-item has-icon text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </form>

            </div>
        </li>
    </ul>
</nav>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">{{ config('settings.site_name') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">{{ config('settings.site_name') }}</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>

            <li class="{{ setSidebar(['admin.dashboard']) }}"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-fire"></i> General
                    Dashboard</a>
            </li>



            <li class="menu-header">Starter</li>

            <li class="{{ setSidebar(['admin.slider.*']) }}" ><a class="nav-link" href="{{ route('admin.slider.index') }}"><i class="far fa-images"></i>
                    <span>Slider</span></a>
            </li>

              <li  class="{{ setSidebar(['admin.daily-offer.*']) }}"><a class="nav-link" href="{{ route('admin.daily-offer.index') }}"><i class="far fa-clock"></i>
                    <span>Daily Offer</span></a>
            </li>


            <li  class="{{ setSidebar(['admin.why-choose-us.*']) }}"><a class="nav-link" href="{{ route('admin.why-choose-us.index') }}"><i class="fas fa-stream"></i>
                    <span>Why Choose Us</span></a>
            </li>

            <li class="dropdown {{ setSidebar(['admin.orders.index',
                'admin.pending-orders',
                'admin.inprocess-orders',
                'admin.delivered-orders',
                'admin.declined-orders'
                ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-box"></i> <span>Orders</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setSidebar(['admin.orders.index']) }}"><a class="nav-link" href="{{ route('admin.orders.index') }}">All Orders</a></li>
                    <li class="{{ setSidebar(['admin.pending-orders']) }}" ><a class="nav-link" href="{{ route('admin.pending-orders') }}">Pending Orders</a></li>
                    <li class="{{ setSidebar(['admin.inprocess-orders']) }}"><a class="nav-link" href="{{ route('admin.inprocess-orders') }}">In Process Orders</a></li>
                    <li class="{{ setSidebar(['admin.delivered-orders']) }}"><a class="nav-link" href="{{ route('admin.delivered-orders') }}">Delivered Orders</a></li>
                    <li class="{{ setSidebar(['admin.declined-orders']) }}"><a class="nav-link" href="{{ route('admin.declined-orders') }}">Declined Orders</a></li>
                </ul>
            </li>

            <li class="dropdown {{ setSidebar(['admin.category.index',
                'admin.category.*',
                'admin.product.*',
                'admin.product-review.index',
                ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-shopping-cart"></i> <span>Manage Product</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setSidebar(['admin.category.*']) }}" ><a class="nav-link" href="{{ route('admin.category.index') }}">Product Categories</a></li>
                    <li class="{{ setSidebar(['admin.product.*']) }}" ><a class="nav-link" href="{{ route('admin.product.index') }}">Products</a></li>
                     <li class="{{ setSidebar(['admin.product-review.index']) }}"><a class="nav-link" href="{{ route('admin.product-review.index') }}">Product Reviews</a></li>
                </ul>
            </li>

            <li class="dropdown {{ setSidebar(
               ['admin.coupon.index',
                'admin.coupon.*',
                'admin.delivery-area.index',
                'admin.payment-setting.index',
                ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-store"></i> <span>Manage Ecommerce</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setSidebar(['admin.coupon.index']) }}" ><a class="nav-link" href="{{ route('admin.coupon.index') }}">Coupon</a></li>
                    <li class="{{ setSidebar(['admin.delivery-area.index']) }}" ><a class="nav-link" href="{{ route('admin.delivery-area.index') }}">Delivery Area</a></li>
                    <li class="{{ setSidebar(['admin.payment-setting.index']) }}" ><a class="nav-link" href="{{ route('admin.payment-setting.index') }}">Payment Setting</a>
                    </li>
                </ul>
            </li>

               <li class="dropdown {{ setSidebar(
               ['admin.reservation-time.index',
                'admin.reservation-time.*',
                'admin.reservation.index'
                ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-chair"></i> <span>Manage Reservation</span></a>
                <ul class="dropdown-menu">
                    <li  class="{{ setSidebar(['admin.reservation-time.index']) }}" ><a class="nav-link" href="{{ route('admin.reservation-time.index') }}">Reservation Time</a></li>
                     <li  class="{{ setSidebar(['admin.reservation.index']) }}"><a class="nav-link" href="{{ route('admin.reservation.index') }}">Reservation</a></li>
                </ul>
            </li>


      <li  class="{{ setSidebar(['admin.setting.index']) }}" ><a class="nav-link" href="{{ route('admin.setting.index') }}"><i class="fas fa-cogs">
      </i><span>Settings</span></a></li>


        </ul>


    </aside>
</div>
