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
    <link href="{{ asset('css/custom-dashboard.css') }}?v={{ time() }}" rel="stylesheet">
    
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
    <!-- Inline script to restore sidebar toggle preference without screen flicker -->
    <script type="text/javascript">
        if (localStorage.getItem('sidebar-minimized') === 'true') {
            document.body.classList.add('sidenav-toggled');
        }
    </script>

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
                var text = $.trim($el.text()).replace(/\s+/g, ' ');
                
                if (text === 'View Details' || text === 'View' || text === 'View Seat Layout') {
                    $el.html('<i class="fa-solid fa-eye" style="margin: 0;"></i>').attr('title', 'View Details');
                } else if (text === 'Edit') {
                    $el.html('<i class="fa-solid fa-pen" style="margin: 0;"></i>').attr('title', 'Edit');
                } 
                 else if (text === 'Layout Mapping') {
                    $el.html('<i class="fa-solid fa-layer-group" style="margin: 0;"></i>').attr('title', 'Layout Mapping');
                } 
                else if (text === 'Generate Invoice') {
                    $el.html('<i class="fa-solid fa fa-retweet" style="margin: 0;"></i>').attr('title', 'Generate Invoice');
                } 
                
                else if (text === 'Delete') {
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
                'Manage Setting': 'fa-solid fa-gears',
                'Security': 'fa-solid fa-shield-halved',
                'Manage Coupon': 'fa-solid fa-tags',
                'Manage Company': 'fa-solid fa-building',

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
                'Ticket Types': 'fa-regular fa-circle-check',
                'Event Tickets': 'fa-solid fa-ticket-simple',
                'Show Schedule': 'fa-solid fa-timeline',

                // Booking items
                'Booking List': 'fa-solid fa-table-list',
                'Add Booking': 'fa-solid fa-cart-plus',
                'Sale Status': 'fa-solid fa-chart-pie',

                // Gallery items
                'Photos Gallery': 'fa-solid fa-image',
                'Photo Content': 'fa-solid fa-photo-film',
                'Video Gallery': 'fa-solid fa-video',

                // Reports items
                'Booking Report': 'fa-solid fa-file-invoice-dollar',
                'Feedback Report': 'fa-solid fa-comment-dots',
                'General Feedback Report': 'fa-regular fa-comments',
                'Source Report': 'fa-solid fa-network-wired',
                'Payment Mode Report': 'fa-solid fa-wallet',
                'Ticket Sale Report': 'fa-solid fa-cash-register',
                'Booking Type Report': 'fa-regular fa-circle-check',
                'Cashier Shift Summary': 'fa-solid fa-clipboard-list',
                'Cashier Shift Summary Multiple': 'fa-regular fa-circle-check',
                'Cashier Shift Vs Payment Summary': 'fa-solid fa-scale-balanced',
                'Individual Cashier Shift Summary': 'fa-solid fa-user-check',
                'Event Summary Show Wise': 'fa-solid fa-calendar-week',
                'Scan Summary Show Wise': 'fa-solid fa-qrcode',
                'Event Summary Day Wise': 'fa-solid fa-calendar-day',
                'Payment Gateway Transaction': 'fa-solid fa-credit-card',
                'Customer Payment Report': 'fa-solid fa-file-shield',
                'Cancelled Booking': 'fa-solid fa-rectangle-xmark',
                'Complementry Report': 'fa-solid fa-gift',
                'Analytics Summary': 'fa-solid fa-chart-column',
                'Sale Summary': 'fa-solid fa-chart-column',
                'GST R1 Report': 'fa-solid fa-percent',

                // Scanning items
                'Scan Ticket': 'fa-solid fa-qrcode',
                'Scan Report': 'fa-solid fa-square-poll-vertical',

                // Coupon & Company items
                'Coupon Category': 'fa-solid fa-ticket',
                'Coupons': 'fa-solid fa-tags',
                'Companies': 'fa-solid fa-building',

                // Configuration items
                'Configurations': 'fa-solid fa-sliders',
                'SMS Configuration': 'fa-solid fa-comment-sms',
                'Email Configuration': 'fa-solid fa-envelope',
                'PG Configuration': 'fa-solid fa-wallet',
                'Payment Methods': 'fa-solid fa-money-bill-transfer',
                'Booking Platforms': 'fa-solid fa-laptop-code',
                'Settings': 'fa-solid fa-gears',

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
                    text = $.trim($label.text()).replace(/\s+/g, ' ');
                } else {
                    text = $.trim($link.contents().filter(function() {
                        return this.nodeType === 3;
                    }).text()).replace(/\s+/g, ' ');
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

        function highlightActiveSidebar() {
            var currentUrl = window.location.href.split('?')[0].replace(/\/+$/, ""); // Remove trailing slashes
            $('.app-sidebar a.treeview-item, .app-sidebar a.app-menu__item').each(function() {
                var $link = $(this);
                var linkUrl = ($link.attr('href') || '').split('?')[0].replace(/\/+$/, "");
                
                if (linkUrl && (currentUrl === linkUrl || currentUrl.indexOf(linkUrl + '/') === 0)) {
                    $link.addClass('active');
                    var $parentTree = $link.closest('.treeview');
                    if ($parentTree.length) {
                        $parentTree.addClass('is-expanded');
                    }
                }
            });
        }

        // Run conversions and highlights on load
        convertButtonsToIcons();
        convertSidebarIcons();
        highlightActiveSidebar();

        // Sync collapsed sidebar label width with submenu width on hover
        $('.app-sidebar .treeview').on('mouseenter', function() {
            if ($('body').hasClass('sidenav-toggled')) {
                var $label = $(this).find('.app-menu__label');
                var $submenu = $(this).find('.treeview-menu');
                if ($label.length && $submenu.length) {
                    // Wait a tick for both to render
                    setTimeout(function() {
                        var labelW = $label.outerWidth();
                        var submenuW = $submenu.outerWidth();
                        var maxW = Math.max(labelW, submenuW);
                        $label.css('min-width', maxW + 'px');
                        $submenu.css('min-width', maxW + 'px');
                    }, 10);
                }
            }
        }).on('mouseleave', function() {
            // Reset to CSS defaults
            $(this).find('.app-menu__label').css('min-width', '');
            $(this).find('.treeview-menu').css('min-width', '');
        });

        // Use a MutationObserver to ensure buttons are converted to icons dynamically
        // whenever the table rows change (e.g. pagination, sorting, search filters)
        var observerTimeout;
        var tableObserver = new MutationObserver(function() {
            clearTimeout(observerTimeout);
            observerTimeout = setTimeout(function() {
                tableObserver.disconnect();
                convertButtonsToIcons();
                
                var target = document.querySelector('body');
                if (target) {
                    tableObserver.observe(target, { childList: true, subtree: true });
                }
            }, 30);
        });
        
        var targetNode = document.querySelector('body');
        if (targetNode) {
            tableObserver.observe(targetNode, { childList: true, subtree: true });
        }

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

        // Listen to sidebar toggle button click to save minimized preference
        $('.app-sidebar__toggle').on('click', function() {
            setTimeout(function() {
                var isMinimized = $('body').hasClass('sidenav-toggled');
                localStorage.setItem('sidebar-minimized', isMinimized);
            }, 100);
        });
    });
    </script>
    <!-- Custom Page Level JS -->
    @yield('js')
</body>
</html>
