<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}::@yield('title')</title>
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Custom Theme CSS -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom-dashboard.css') }}" rel="stylesheet">
    
    <!-- Fonts (Optimized Plus Jakarta Sans Font Stack) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
      .required {
        color:#ff0000;
      }
    </style>
  	
    <!-- Custom Page Level CSS -->
    @yield('css')
</head>
<body id="body" class="app sidebar-mini rtl">
    <!-- Page Loader Overlay -->
    <div id="pageLoaderOverlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #f8fafc; z-index: 99999; display: flex; align-items: center; justify-content: center; transition: opacity 0.4s ease, visibility 0.4s ease;">
        <div style="display: flex; flex-direction: column; align-items: center; gap: 15px;">
            <div style="width: 45px; height: 45px; border: 4px solid rgba(59, 130, 246, 0.1); border-top-color: #2563eb; border-radius: 50%; animation: pageLoaderSpinner 0.8s linear infinite;"></div>
            <span style="font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; color: #475569; letter-spacing: 0.5px; text-transform: uppercase;">Loading Dashboard...</span>
        </div>
    </div>
    
    <style>
    @keyframes pageLoaderSpinner {
        to { transform: rotate(360deg); }
    }
    </style>

    <div id="app">
        @include('../partials/navbar')
        
        @include('../partials/sidebar')
        
        @yield('content')
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Essential javascripts for application to work-->
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
  	<script src="{{ asset('js/plugins/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/plugins/pace.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <script type="text/javascript">
       $(document).ready(function() {
        $('form').on('submit', function() {
            $(this).find('input[type="submit"], button[type="submit"]').prop('disabled', true);
        });

        // Convert table action buttons text to FontAwesome icons
        function convertButtonsToIcons() {
            $('table td').find('a, button').each(function() {
                var $el = $(this);
                var text = $.trim($el.text());
                
                if (text === 'View Details' || text === 'View') {
                    $el.html('<i class="fa-solid fa-eye" style="margin: 0;"></i>').attr('title', 'View Details');
                } else if (text === 'Edit') {
                    $el.html('<i class="fa-solid fa-pen" style="margin: 0;"></i>').attr('title', 'Edit');
                } else if (text === 'Delete') {
                    $el.html('<i class="fa-solid fa-trash" style="margin: 0;"></i>').attr('title', 'Delete');
                }
            });
        }

        // Convert legacy generic sidebar icons to professional, related FontAwesome 6 icons
        function convertSidebarIcons() {
            var iconMap = {
                // Main Category Titles
                'Dashboard': 'fa-solid fa-gauge-high',
                'Master': 'fa-solid fa-server',
                'Manage Event': 'fa-solid fa-calendar-check',
                'Manage Booking': 'fa-solid fa-receipt',
                'Manage Gallery': 'fa-solid fa-images',
                'Reports': 'fa-solid fa-chart-line',
                'System Configuration': 'fa-solid fa-gears',
                'Security': 'fa-solid fa-shield-halved',

                // Master items
                'States': 'fa-solid fa-map-location',
                'Cities': 'fa-solid fa-city',
                'Pincodes': 'fa-solid fa-location-dot',
                'Organizers': 'fa-solid fa-user-tie',
                'Venues': 'fa-solid fa-building-columns',
                'Sub Venues': 'fa-solid fa-sitemap',
                'Seat Layouts': 'fa-solid fa-chair',

                // Event items
                'Events': 'fa-solid fa-calendar-days',
                'Event Schedules': 'fa-solid fa-clock',
                'Event Show Time': 'fa-solid fa-hourglass-half',
                'Ticket Types': 'fa-solid fa-tags',
                'Event Tickets': 'fa-solid fa-ticket-simple',
                'Show Schedule': 'fa-solid fa-timeline',

                // Booking items
                'Booking List': 'fa-solid fa-table-list',
                'Add Booking': 'fa-solid fa-cart-plus',
                'Sale Status': 'fa-solid fa-chart-pie',

                // Gallery items
                'Photos Gallery': 'fa-solid fa-image',
                'Photo Content': 'fa-solid fa-photo-film',

                // Reports items
                'Booking Report': 'fa-solid fa-file-invoice-dollar',
                'Feedback Report': 'fa-solid fa-comment-dots',
                'General Feedback Report': 'fa-solid fa-comments',
                'Source Report': 'fa-solid fa-network-wired',
                'Payment Mode Report': 'fa-solid fa-wallet',
                'Ticket Sale Report': 'fa-solid fa-cash-register',
                'Booking Type Report': 'fa-solid fa-tags',
                'Cashier Shift Summary': 'fa-solid fa-clipboard-list',
                'Cashier Shift Summary Multiple': 'fa-solid fa-clipboard-check',
                'Cashier Shift Vs Payment Summary': 'fa-solid fa-scale-balanced',
                'Individual Cashier Shift Summary': 'fa-solid fa-user-check',
                'Event Summary Show Wise': 'fa-solid fa-calendar-week',
                'Scan Summary Show Wise': 'fa-solid fa-qrcode',
                'Event Summary Day Wise': 'fa-solid fa-calendar-day',
                'PG Transaction Report': 'fa-solid fa-credit-card',
                'PG Logs Report': 'fa-solid fa-file-shield',
                'Cancelled Booking Report': 'fa-solid fa-rectangle-xmark',
                'Complementary Report': 'fa-solid fa-gift',
                'Sale Summary': 'fa-solid fa-chart-column',
                'Gst Report R1': 'fa-solid fa-percent',

                // Configuration items
                'Configuration': 'fa-solid fa-sliders',
                'SMS Configuration': 'fa-solid fa-comment-sms',
                'Email Configuration': 'fa-solid fa-envelope',
                'PG Configuration': 'fa-solid fa-wallet',
                'Payment Method': 'fa-solid fa-money-bill-transfer',
                'Booking Platform': 'fa-solid fa-laptop-code',

                // Security items
                'Modules': 'fa-solid fa-cubes',
                'Roles': 'fa-solid fa-user-shield',
                'Users': 'fa-solid fa-users-gear'
            };

            $('.app-sidebar a').each(function() {
                var $link = $(this);
                var $label = $link.find('.app-menu__label');
                var text = '';
                
                if ($label.length) {
                    text = $.trim($label.text());
                } else {
                    text = $.trim($link.contents().filter(function() {
                        return this.nodeType === 3;
                    }).text());
                }

                if (text && iconMap[text]) {
                    var $icon = $link.find('i.app-menu__icon, i.icon');
                    if ($icon.length) {
                        var isSidebarMenuIcon = $icon.hasClass('app-menu__icon');
                        var fontClass = iconMap[text];
                        $icon.attr('class', (isSidebarMenuIcon ? 'app-menu__icon ' : 'icon ') + fontClass);
                    }
                }
            });
        }

        // Run conversions on load
        convertButtonsToIcons();
        convertSidebarIcons();

        // Run conversion whenever DataTables draws/redraws the table rows
        $(document).on('draw.dt', function() {
            convertButtonsToIcons();
        });

        // Smooth fade out of page loader overlay once window is fully loaded
        $(window).on('load', function() {
            var $loader = $('#pageLoaderOverlay');
            $loader.css({
                'opacity': 0,
                'visibility': 'hidden'
            });
            setTimeout(function() {
                $loader.remove();
            }, 400);
        });
    });
    </script>
    <!-- Custom Page Level JS -->
    @yield('js')
</body>
</html>
