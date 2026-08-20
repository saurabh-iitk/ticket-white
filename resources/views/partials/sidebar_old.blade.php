<?php $current_uri=request()->segment(1); ?>
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image">
        <div>
            <p class="app-sidebar__user-name">{{ Auth::user()->name }}</p>
            <p class="app-sidebar__user-designation">{{ Auth::user()->role->name }}</p>
        </div>
    </div>
    <ul class="app-menu">
        <li><a class="app-menu__item {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ URL::to('dashboard') }}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>

        @if(in_array('module_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ request()->is('module*') ? 'active' : '' }}" href="{{ route('module.index') }}"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Modules</span></a></li>
        @endif

        @if(in_array('user_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ request()->is('user*') ? 'active' : '' }}" href="{{ route('user.index') }}"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Users</span></a></li>
        @endif
        @if(in_array('role_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ request()->is('role*') ? 'active' : '' }}" href="{{ route('role.index') }}"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Roles</span></a></li>
        @endif

        <!-- @if(in_array('booking_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ request()->is('booking*') ? 'active' : '' }}" href="{{ route('booking.index') }}"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">Bookings</span></a></li>
        @endif -->

        @if(in_array('state_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ request()->is('state*') ? 'active' : '' }}" href="{{ route('state.index') }}"><i class="app-menu__icon fa fa-star"></i><span class="app-menu__label">States</span></a></li>
        @endif

        @if(in_array('city_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ request()->is('city*') ? 'active' : '' }}" href="{{ route('city.index') }}"><i class="app-menu__icon fa fa-star-o"></i><span class="app-menu__label">Cities</span></a></li>
        @endif

        @if(in_array('pincode_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ request()->is('pincode*') ? 'active' : '' }}" href="{{ route('pincode.index') }}"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">Pincodes</span></a></li>
        @endif

        @if(in_array('organizer_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ request()->is('organizer*') ? 'active' : '' }}" href="{{ route('organizer.index') }}"><i class="app-menu__icon fa fa-star"></i><span class="app-menu__label">Organizers</span></a></li>
        @endif

        @if(in_array('venue_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ request()->is('venue*') ? 'active' : '' }}" href="{{ route('venue.index') }}"><i class="app-menu__icon fa fa-star-o"></i><span class="app-menu__label">Venues</span></a></li>
        @endif

        @if(in_array('sub_venue_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ request()->is('sub_venue*') ? 'active' : '' }}" href="{{ route('sub_venue.index') }}"><i class="app-menu__icon fa fa-star-o"></i><span class="app-menu__label">Sub Venues</span></a></li>
        @endif

        @if(in_array('layout_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ request()->is('layout*') ? 'active' : '' }}" href="{{ route('layout.create') }}"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">Seat Layouts</span></a></li>
        @endif

        @if(in_array('event_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ (request()->is('event*') && $current_uri=='event') ? 'active' : '' }}" href="{{ route('event.index') }}"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">Events</span></a></li>
        @endif

        @if(in_array('event_schedule_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ request()->is('event_schedule*') ? 'active' : '' }}" href="{{ route('event_schedule.index') }}"><i class="app-menu__icon fa fa-star"></i><span class="app-menu__label">Event Schedules</span></a></li>
        @endif

        @if(in_array('event_show_time_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ request()->is('event_show_time*') ? 'active' : '' }}" href="{{ route('event_show_time.index') }}"><i class="app-menu__icon fa fa-star"></i><span class="app-menu__label">Event Show Time</span></a></li>
        @endif

        @if(in_array('ticket_type_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ request()->is('ticket_type*') ? 'active' : '' }}" href="{{ route('ticket_type.index') }}"><i class="app-menu__icon fa fa-star-o"></i><span class="app-menu__label">Ticket Types</span></a></li>
        @endif
        
        @if(in_array('event_ticket_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ request()->is('event_ticket*') ? 'active' : '' }}" href="{{ route('event_ticket.index') }}"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">Event Tickets</span></a></li>
        @endif

        @if(in_array('coupon_category_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ request()->is('coupon_category*') ? 'active' : '' }}" href="{{ route('coupon_category.index') }}"><i class="app-menu__icon fa fa-star"></i><span class="app-menu__label">Coupon Category</span></a></li>
        @endif

        @if(in_array('coupon_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ (request()->is('coupon*') && $current_uri=='coupon') ? 'active' : '' }}" href="{{ route('coupon.index') }}"><i class="app-menu__icon fa fa-star-o"></i><span class="app-menu__label">Coupons</span></a></li>
        @endif

        @if(in_array('company_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ request()->is('company*') ? 'active' : '' }}" href="{{ route('company.index') }}"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">Companies</span></a></li>
        @endif

        @if(in_array('configuration_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ request()->is('configuration*') ? 'active' : '' }}" href="{{ route('configuration.index') }}"><i class="app-menu__icon fa fa-star"></i><span class="app-menu__label">Configurations</span></a></li>
        @endif

        @if(in_array('payment_method_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ request()->is('payment_method*') ? 'active' : '' }}" href="{{ route('payment_method.index') }}"><i class="app-menu__icon fa fa-star"></i><span class="app-menu__label">Payment Methods</span></a></li>
        @endif

        <!-- @if(in_array('booking_platform_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ request()->is('booking_platform*') ? 'active' : '' }}" href="{{ route('booking_platform.index') }}"><i class="app-menu__icon fa fa-star"></i><span class="app-menu__label">Booking Platforms</span></a></li>
        @endif -->

        @if(in_array('setting_index', Session::get('permissions')->toArray()))
        <li><a class="app-menu__item {{ request()->is('setting*') ? 'active' : '' }}" href="{{ route('setting.index') }}"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Settings</span></a></li>
        @endif

        <li>
            <a class="app-menu__item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="app-menu__icon fa fa-sign-out"></i> <span class="app-menu__label">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>

        <!--
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Tables</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Basic Tables</a></li>
                <li><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Data Tables</a></li>
            </ul>
        </li>
        -->
    </ul>
</aside>