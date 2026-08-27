<?php $current_uri = request()->segment(1);
$current_uri2 = request()->segment(2); ?>
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar" id="sidebar_hide">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar"
            src="{{ !empty(Auth::user()->avatar) ? asset('uploads/avatar/' . Auth::user()->avatar) : asset('images/user.png') }}"
            alt="User Image" style="width:40px;height:40px;">
        <div>
            <p class="app-sidebar__user-name">{{ Auth::user()->name }}</p>
            <p class="app-sidebar__user-designation">{{ Auth::user()->role->name }}</p>
        </div>
    </div>


    <ul class="app-menu">
        <li><a class="app-menu__item {{ request()->is('dashboard') ? 'active' : '' }}"
                href="{{ URL::to('dashboard') }}"><i class="app-menu__icon fa fa-dashboard"></i><span
                    class="app-menu__label">Dashboard</span></a></li>

        @if (in_array('state_index', Session::get('permissions')->toArray()) ||
            in_array('city_index', Session::get('permissions')->toArray()) ||
            in_array('pincode_index', Session::get('permissions')->toArray()) ||
            in_array('organizer_index', Session::get('permissions')->toArray()) ||
            in_array('venue_index', Session::get('permissions')->toArray()) ||
            in_array('sub_venue_index', Session::get('permissions')->toArray()) ||
            in_array('layout_index', Session::get('permissions')->toArray()))
            <li
                class="treeview {{ request()->is('state*') || request()->is('city*') || request()->is('pincode*') || request()->is('organizer*') || request()->is('venue*') || request()->is('sub_venue*') || request()->is('layout*') ? 'is-expanded' : '' }}">
                <a class="app-menu__item" href="javascript:void(0)" data-toggle="treeview"><i
                        class="app-menu__icon fa fa-star"></i><span class="app-menu__label">Master</span><i
                        class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    @if (in_array('state_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('state*') ? 'active' : '' }}"
                                href="{{ route('state.index') }}"><i class="icon fa fa-circle-o"></i>States</a></li>
                    @endif

                    @if (in_array('city_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('city*') ? 'active' : '' }}"
                                href="{{ route('city.index') }}"><i class="icon fa fa-circle-o"></i>Cities</a></li>
                    @endif

                    @if (in_array('pincode_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('pincode*') ? 'active' : '' }}"
                                href="{{ route('pincode.index') }}"><i class="icon fa fa-circle-o"></i>Pincodes</a>
                        </li>
                    @endif

                    @if (in_array('organizer_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('organizer*') ? 'active' : '' }}"
                                href="{{ route('organizer.index') }}"><i class="icon fa fa-circle-o"></i>Organizers</a>
                        </li>
                    @endif

                    @if (in_array('venue_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('venue*') ? 'active' : '' }}"
                                href="{{ route('venue.index') }}"><i class="icon fa fa-circle-o"></i>Venues</a></li>
                    @endif

                    @if (in_array('sub_venue_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('sub_venue*') ? 'active' : '' }}"
                                href="{{ route('sub_venue.index') }}"><i class="icon fa fa-circle-o"></i>Sub Venues</a>
                        </li>
                    @endif

                    @if (in_array('layout_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('layout*') && !request()->is('layout/create*') && !request()->is('layout/designer*') ? 'active' : '' }}"
                                href="{{ route('layout.index') }}"><i class="icon fa fa-circle-o"></i>Seat Layouts</a>
                        </li>
                        <li><a class="treeview-item {{ request()->is('layout/create*') ? 'active' : '' }}"
                                href="{{ route('layout.create') }}"><i class="icon fa fa-circle-o"></i>Create Layout (Old)</a>
                        </li>
                        <li><a class="treeview-item {{ request()->is('layout/designer*') ? 'active' : '' }}"
                                href="{{ url('layout/designer/5') }}"><i class="icon fa fa-circle-o"></i>Venue Designer (New)</a>
                        </li>
                    @endif



                </ul>
            </li>
        @endif

        @if (in_array('event_index', Session::get('permissions')->toArray()) ||
            in_array('event_schedule_index', Session::get('permissions')->toArray()) ||
            in_array('event_show_time_index', Session::get('permissions')->toArray()) ||
            in_array('ticket_type_index', Session::get('permissions')->toArray()) ||
            in_array('show_time_schedule_index', Session::get('permissions')->toArray()) ||
            in_array('event_ticket_index', Session::get('permissions')->toArray()))
            <li
                class="treeview {{ request()->is('event*') || request()->is('event_schedule*') || request()->is('event_show_time*') || request()->is('ticket_type*') || request()->is('show_time_schedule*') || request()->is('event_ticket*') ? 'is-expanded' : '' }}">
                <a class="app-menu__item" href="javascript:void(0)" data-toggle="treeview"><i
                        class="app-menu__icon fa fa-star-o"></i><span class="app-menu__label">Manage Event</span><i
                        class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    @if (in_array('event_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('event*') && $current_uri == 'event' ? 'active' : '' }}"
                                href="{{ route('event.index') }}"><i class="icon fa fa-circle-o"></i>Events</a></li>
                    @endif

                    @if (in_array('event_schedule_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('event_schedule*') ? 'active' : '' }}"
                                href="{{ route('event_schedule.index') }}"><i class="icon fa fa-circle-o"></i>Event
                                Schedules</a></li>
                    @endif

                    @if (in_array('event_show_time_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('event_show_time*') ? 'active' : '' }}"
                                href="{{ route('event_show_time.index') }}"><i class="icon fa fa-circle-o"></i>Event
                                Show Time</a></li>
                    @endif

                    @if (in_array('ticket_type_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('ticket_type*') ? 'active' : '' }}"
                                href="{{ route('ticket_type.index') }}"><i class="icon fa fa-circle-o"></i>Ticket
                                Types</a></li>
                    @endif

                    @if (in_array('event_ticket_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('event_ticket*') ? 'active' : '' }}"
                                href="{{ route('event_ticket.index') }}"><i class="icon fa fa-circle-o"></i>Event
                                Tickets</a></li>
                    @endif

                    @if (in_array('show_time_schedule', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('show_time_schedule*') ? 'active' : '' }}"
                                href="{{ route('show_time_schedule.index') }}"><i class="icon fa fa-circle-o"></i>Show
                                Schedule</a></li>
                    @endif

                </ul>
            </li>
        @endif




        @if (in_array('booking_create', Session::get('permissions')->toArray()) ||
            in_array('sale_status', Session::get('permissions')->toArray()))
            <li class="treeview {{ request()->is('sale_status*') || request()->is('booking*') ? 'is-expanded' : '' }}">
                <a class="app-menu__item" href="javascript:void(0)" data-toggle="treeview"><i
                        class="app-menu__icon fa fa-star-o"></i><span class="app-menu__label">Manage Booking</span><i
                        class="treeview-indicator fa fa-angle-right"></i></a>


                <ul class="treeview-menu">

                    @if (in_array('booking_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('bookings_index*') ? 'active' : '' }}"
                                href="{{ route('booking.index') }}"><i class="icon fa fa-circle-o"></i>Booking List</a>
                        </li>
                    @endif


                    @if (in_array('booking_create', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('booking_create*') ? 'active' : '' }}"
                                href="{{ route('booking.create') }}"><i class="icon fa fa-circle-o"></i>Add Booking</a>
                        </li>
                    @endif


                    @if (in_array('sale_status', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('sale_status*') ? 'active' : '' }}"
                                href="{{ route('bookings.saleStatus') }}"><i class="icon fa fa-circle-o"></i>Sale
                                Status</a></li>
                    @endif


                </ul>
            </li>
        @endif



           @if (in_array('booking_create', Session::get('permissions')->toArray()) ||
            in_array('sale_status', Session::get('permissions')->toArray()))
            <li class="treeview {{ request()->is('photo_gallery*') || request()->is('photo_content*') || request()->is('video_gallery*') ? 'is-expanded' : '' }}">
                <a class="app-menu__item" href="javascript:void(0)" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-star-o"></i>
                    <span class="app-menu__label">Manage Gallery</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>

                <ul class="treeview-menu">
                    @if (in_array('booking_index', Session::get('permissions')->toArray()))
                        <li>
                            <a class="treeview-item {{ request()->is('photo_gallery*') ? 'active' : '' }}"
                            href="{{ route('photo_gallery.index') }}">
                            <i class="icon fa fa-circle-o"></i>Photos Gallery
                            </a>
                        </li>
                    @endif
                
                    @if (in_array('booking_create', Session::get('permissions')->toArray()))
                        <li>
                            <a class="treeview-item {{ request()->is('photo_content*') ? 'active' : '' }}"
                            href="{{ route('photo_content.index') }}">
                            <i class="icon fa fa-circle-o"></i>Photo Content
                            </a>
                        </li>
                    @endif
                
                    @if (in_array('booking_create', Session::get('permissions')->toArray()))
                        {{-- <li>
                            <a class="treeview-item {{ request()->is('video_gallery*') ? 'active' : '' }}" 
                            href="{{ route('video_gallery.index') }}">
                            <i class="icon fa fa-circle-o"></i>Video Gallery
                            </a>
                        </li> --}}
                    @endif
                </ul>
            </li>
        @endif
        
        


        @if (in_array('report_index', Session::get('permissions')->toArray()) ||
            in_array('payment_mode_index', Session::get('permissions')->toArray()) ||
            in_array('ticket_sale_index', Session::get('permissions')->toArray()) ||
            in_array('booking_type_index', Session::get('permissions')->toArray()) ||
            in_array('cashier_shift_summary_index', Session::get('permissions')->toArray()) ||
            in_array('cashier_shift_summary_multiple_day_index', Session::get('permissions')->toArray()) ||
            in_array('cashier_shift_summary_vs_payment_index', Session::get('permissions')->toArray()) ||
            in_array('individual_cashier_shift_summary_index', Session::get('permissions')->toArray()) ||
            in_array('cashier_shift_summary_show_wise_index', Session::get('permissions')->toArray()) ||
            in_array('scan_summary_show_wise_index', Session::get('permissions')->toArray()) ||
            in_array('cashier_shift_summary_day_wise_index', Session::get('permissions')->toArray()) ||
            in_array('pg_transaction_report', Session::get('permissions')->toArray()) ||
            in_array('cancelled_booking_report_index', Session::get('permissions')->toArray()) ||
            in_array('complementry_report', Session::get('permissions')->toArray()) ||
            in_array('general_feedback_report', Session::get('permissions')->toArray()) ||
            in_array('booking_index', Session::get('permissions')->toArray()) ||
            in_array('gst_report_r1_index', Session::get('permissions')->toArray()) ||
            in_array('sale_summary_index', Session::get('permissions')->toArray()))
            <li
                class="treeview {{ request()->is('reports*') || request()->is('payment_mode*') || request()->is('ticket_sale*') || request()->is('booking_type*') || request()->is('cashier_shift_summary_show_wise*') || request()->is('cashier_shift_summary*') || request()->is('sale_summary*') ? 'is-expanded' : '' }}">
                <a class="app-menu__item" href="javascript:void(0)" data-toggle="treeview"><i
                        class="app-menu__icon fa fa-star-o"></i><span class="app-menu__label">Reports</span><i
                        class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">

                    @if (in_array('booking_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('reports*') && $current_uri2 == 'booking' ? 'active' : '' }}"
                                href="{{ route('reports.booking') }}"><i class="icon fa fa-circle-o"></i>Booking
                                Report</a></li>
                    @endif
                    
                    
                     @if (in_array('feedback_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('reports*') && $current_uri2 == 'feedback_report' ? 'active' : '' }}"
                                href="{{ route('reports.feedback_report') }}"><i class="icon fa fa-circle-o"></i>Feedback
                                Report</a></li>
                    @endif
                    
                     @if (in_array('general_feedback_report_index', Session::get('permissions')->toArray()))
                     <li><a class="treeview-item {{ request()->is('reports*') && $current_uri2 == 'general_feedback_report' ? 'active' : '' }}"
                                href="{{ route('reports.general_feedback_report') }}"><i class="icon fa fa-circle-o"></i>General Feedback
                                Report</a></li>
                                
                    <li><a class="treeview-item {{ request()->is('reports*') && $current_uri2 == 'source_report' ? 'active' : '' }}"
                                href="{{ route('reports.source_report') }}"><i class="icon fa fa-circle-o"></i>Source Report</a></li>
                    
                    @endif
                    
                     
                    
                    

                    @if (in_array('payment_mode_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('reports*') && $current_uri2 == 'payment_mode' ? 'active' : '' }}"
                                href="{{ route('reports.payment_mode') }}"><i class="icon fa fa-circle-o"></i>Payment
                                Mode Report</a></li>
                    @endif

                    @if (in_array('ticket_sale_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('reports*') && $current_uri2 == 'ticket_sale' ? 'active' : '' }}"
                                href="{{ route('reports.ticket_sale') }}"><i class="icon fa fa-circle-o"></i>Ticket
                                Sale Report</a></li>
                    @endif

                    @if (in_array('booking_type_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('reports*') && $current_uri2 == 'booking_type' ? 'active' : '' }}"
                                href="{{ route('reports.booking_type') }}"><i class="icon fa fa-circle-o"></i>Booking
                                Type Report</a></li>
                    @endif

                    @if (in_array('cashier_shift_summary_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('reports*') && $current_uri2 == 'cashier_shift_summary' ? 'active' : '' }}"
                                href="{{ route('reports.cashier_shift_summary') }}"><i
                                    class="icon fa fa-circle-o"></i> Cashier Shift Summary</a></li>
                    @endif
                    
                    @if (in_array('cashier_shift_summary_multiple_day_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('reports*') && $current_uri2 == 'cashier_shift_summary_multiple_day' ? 'active' : '' }}"
                                href="{{ route('reports.cashier_shift_summary_multiple_day') }}"><i
                                    class="icon fa fa-circle-o"></i> Cashier Shift Summary Multiple</a></li>
                    @endif


                    @if (in_array('cashier_shift_summary_vs_payment_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('reports*') && $current_uri2 == 'cashier_shift_summary_vs_payment' ? 'active' : '' }}"
                                href="{{ route('reports.cashier_shift_summary_vs_payment') }}"><i
                                    class="icon fa fa-circle-o"></i> Cashier Shift Vs Payment Summary</a></li>
                    @endif



                    @if (in_array('individual_cashier_shift_summary_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('reports*') && $current_uri2 == 'individual_cashier_shift_summary' ? 'active' : '' }}"
                                href="{{ route('reports.individual_cashier_shift_summary') }}"><i
                                    class="icon fa fa-circle-o"></i>Individual Cashier Shift Summary</a></li>
                    @endif

                    @if (in_array('cashier_shift_summary_show_wise_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('reports*') && $current_uri2 == 'cashier_shift_summary_show_wise' ? 'active' : '' }}"
                                href="{{ route('reports.cashier_shift_summary_show_wise') }}"><i
                                    class="icon fa fa-circle-o"></i> Event Summary Show Wise</a></li>
                    @endif
                    

                    @if (in_array('scan_summary_show_wise_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('reports*') && $current_uri2 == 'scan_summary_show_wise' ? 'active' : '' }}"
                                href="{{ route('reports.scan_summary_show_wise') }}"><i
                                    class="icon fa fa-circle-o"></i> Scan Summary Show Wise</a></li>
                    @endif


                    @if (in_array('cashier_shift_summary_day_wise_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('reports*') && $current_uri2 == 'cashier_shift_summary_day_wise' ? 'active' : '' }}"
                                href="{{ route('reports.cashier_shift_summary_day_wise') }}"><i
                                    class="icon fa fa-circle-o"></i> Event Summary Day Wise</a></li>
                    @endif



                    @if (in_array('sale_summary_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('reports*') && $current_uri2 == 'sale_summary' ? 'active' : '' }}"
                                href="{{ route('reports.sale_summary') }}"><i class="icon fa fa-circle-o"></i>Sale
                                Summary</a></li>
                    @endif

                    @if (in_array('cancelled_booking_report', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('reports*') && $current_uri2 == 'cancelled_booking_report' ? 'active' : '' }}"
                                href="{{ route('reports.cancelled_booking_report') }}"><i
                                    class="icon fa fa-circle-o"></i>Cancelled Booking</a></li>
                    @endif


                    @if (in_array('pg_transaction_report', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('reports*') && $current_uri2 == 'pg_transaction_report' ? 'active' : '' }}"
                                href="{{ route('reports.pg_transaction_report') }}"><i
                                    class="icon fa fa-circle-o"></i>Payment Gateway Transaction</a></li>
                    @endif


                    @if (in_array('pg_logs', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('reports*') && $current_uri2 == 'pg_logs' ? 'active' : '' }}"
                                href="{{ route('reports.pg_logs') }}"><i
                                    class="icon fa fa-circle-o"></i>Customer Payment Report</a></li>
                    @endif
                    
                    @if (in_array('complementry_report', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('reports*') && $current_uri2 == 'complementry_report' ? 'active' : '' }}"
                                href="{{ route('reports.complementry_report') }}"><i
                                    class="icon fa fa-circle-o"></i>Complementry Report</a></li>
                    @endif
                    
                    
                     @if (in_array('complementry_report', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('reports*') && $current_uri2 == 'analytics_summary' ? 'active' : '' }}"
                                href="{{ route('reports.analytics_summary') }}"><i
                                    class="icon fa fa-circle-o"></i>Analytics Summary</a></li>
                    @endif


                     @if (in_array('gst_report_r1_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('reports*') && $current_uri2 == 'gst_report_r1' ? 'active' : '' }}"
                                href="{{ route('reports.gst_report_r1') }}"><i class="icon fa fa-circle-o"></i>GST R1 Report</a></li>
                    @endif


                </ul>
            </li>
        @endif
    
    
        @if (in_array('scan_ticket_index', Session::get('permissions')->toArray()) ||
            in_array('scan_ticket_report_index', Session::get('permissions')->toArray()))
            <li class="treeview {{ request()->is('scan-ticket*') || request()->is('scan-ticket-report*') ? 'is-expanded' : '' }}">
                <a class="app-menu__item" href="javascript:void(0)" data-toggle="treeview"><i
                        class="app-menu__icon fa fa-camera"></i><span class="app-menu__label">Ticket Scanning</span><i
                        class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    @if (in_array('scan_ticket_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('scan-ticket') ? 'active' : '' }}"
                                href="{{ route('scan-ticket') }}"><i class="icon fa fa-circle-o"></i>Scan Ticket</a>
                        </li>
                    @endif
                    @if (in_array('scan_ticket_report_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('scan-ticket-report') ? 'active' : '' }}"
                                href="{{ route('scan-ticket-report') }}"><i class="icon fa fa-circle-o"></i>Scan Report</a>
                        </li>
                    @endif
                    
                </ul>
            </li>
        @endif
        
        

        @if (in_array('role_index', Session::get('permissions')->toArray()))
            <li><a class="app-menu__item {{ request()->is('role*') ? 'active' : '' }}"
                    href="{{ route('role.index') }}"><i class="app-menu__icon fa fa-cogs"></i><span
                        class="app-menu__label">Roles</span></a></li>
        @endif

        @if (in_array('user_index', Session::get('permissions')->toArray()))
            <li><a class="app-menu__item {{ request()->is('user*') ? 'active' : '' }}"
                    href="{{ route('user.index') }}"><i class="app-menu__icon fa fa-users"></i><span
                        class="app-menu__label">Users</span></a></li>
        @endif

    

        @if (in_array('module_index', Session::get('permissions')->toArray()))
            <li><a class="app-menu__item {{ request()->is('module*') ? 'active' : '' }}"
                    href="{{ route('module.index') }}"><i class="app-menu__icon fa fa-tasks"></i><span
                        class="app-menu__label">Modules</span></a></li>
        @endif

        @if (in_array('coupon_category_index', Session::get('permissions')->toArray()) ||
            in_array('coupon_index', Session::get('permissions')->toArray()))
            <li
                class="treeview {{ request()->is('coupon_category*') || request()->is('coupon*') ? 'is-expanded' : '' }}">
                <a class="app-menu__item" href="javascript:void(0)" data-toggle="treeview"><i
                        class="app-menu__icon fa fa-star"></i><span class="app-menu__label">Manage Coupon</span><i
                        class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    @if (in_array('coupon_category_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('coupon_category*') && $current_uri == 'coupon_category' ? 'active' : '' }}"
                                href="{{ route('coupon_category.index') }}"><i class="icon fa fa-circle-o"></i>Coupon
                                Category</a></li>
                    @endif

                    @if (in_array('coupon_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('coupon*') && $current_uri == 'coupon' ? 'active' : '' }}"
                                href="{{ route('coupon.index') }}"><i class="icon fa fa-circle-o"></i>Coupons</a>
                        </li>
                    @endif

                </ul>
            </li>
        @endif

        @if (in_array('company_index', Session::get('permissions')->toArray()))
            <li class="treeview {{ request()->is('company*') ? 'is-expanded' : '' }}">
                <a class="app-menu__item" href="javascript:void(0)" data-toggle="treeview"><i
                        class="app-menu__icon fa fa-star-o"></i><span class="app-menu__label">Manage Company</span><i
                        class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    @if (in_array('company_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('company*') ? 'active' : '' }}"
                                href="{{ route('company.index') }}"><i class="icon fa fa-circle-o"></i>Companies</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if (in_array('configuration_index', Session::get('permissions')->toArray()) ||
            in_array('payment_method_index', Session::get('permissions')->toArray()) ||
            in_array('booking_platform_index', Session::get('permissions')->toArray()) ||
            in_array('setting_index', Session::get('permissions')->toArray()))
            <li
                class="treeview {{ request()->is('configuration*') || request()->is('payment_method*') || request()->is('booking_platform*') || request()->is('setting*') ? 'is-expanded' : '' }}">
                <a class="app-menu__item" href="javascript:void(0)" data-toggle="treeview"><i
                        class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Manage Setting</span><i
                        class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    @if (in_array('configuration_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('configuration*') ? 'active' : '' }}"
                                href="{{ route('configuration.index') }}"><i
                                    class="icon fa fa-circle-o"></i>Configurations</a></li>
                    @endif

                    @if (in_array('payment_method_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('payment_method*') ? 'active' : '' }}"
                                href="{{ route('payment_method.index') }}"><i class="icon fa fa-circle-o"></i>Payment
                                Methods</a></li>
                    @endif

                    <!-- @if (in_array('booking_platform_index', Session::get('permissions')->toArray()))
<li><a class="treeview-item {{ request()->is('booking_platform*') ? 'active' : '' }}" href="{{ route('booking_platform.index') }}"><i class="icon fa fa-circle-o"></i>Booking Platforms</a></li>
@endif -->

                    @if (in_array('setting_index', Session::get('permissions')->toArray()))
                        <li><a class="treeview-item {{ request()->is('setting*') ? 'active' : '' }}"
                                href="{{ route('setting.index') }}"><i class="icon fa fa-circle-o"></i>Settings</a>
                        </li>
                    @endif

                </ul>
            </li>
        @endif

        <li>
            <a class="app-menu__item" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i
                    class="app-menu__icon fa fa-sign-out"></i> <span class="app-menu__label">Logout</span>
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
