<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BookMyTicket - Enterprise Event Ticketing SaaS Platform')</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/software-landing.css') }}?v={{ file_exists(public_path('assets/css/software-landing.css')) ? filemtime(public_path('assets/css/software-landing.css')) : time() }}">
    
    @yield('styles')
</head>
<body class="light-theme">
    <!-- Immediate theme block to prevent flash -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            if (savedTheme === 'dark') {
                document.body.classList.remove('light-theme');
            }
        })();
    </script>

    <!-- Header Navigation -->
    <header class="landing-header" id="mainHeader">
        <div class="header-container">
            <a href="{{ route('software.home') }}" class="logo-link">
                <i class="fa-solid fa-ticket" style="color: var(--accent-blue);"></i> Book My<span>Ticket</span>
            </a>
            
            <ul class="nav-menu">
                <li><a href="{{ route('software.features') }}" class="nav-link {{ Route::is('software.features') ? 'active' : '' }}">Features</a></li>
                <li><a href="{{ route('software.pricing') }}" class="nav-link {{ Route::is('software.pricing') ? 'active' : '' }}">Pricing</a></li>
                <li><a href="{{ route('software.industry') }}" class="nav-link {{ Route::is('software.industry') ? 'active' : '' }}">Industry</a></li>
            </ul>
            
            <div class="nav-right-desktop">
                <button id="themeToggleBtn" class="theme-toggle-btn" aria-label="Toggle Theme">
                    <i class="fa-solid fa-moon"></i>
                </button>
                <a href="{{ route('software.contact') }}#contact-form-section" class="nav-cta">View Demo</a>
            </div>
            
            <button class="mobile-nav-toggle" id="mobileMenuOpen">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Mobile Sidebar Navigation -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="mobile-sidebar" id="mobileSidebar">
        <button class="sidebar-close" id="mobileMenuClose">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; padding: 0 10px;">
            <span style="font-size: 13px; font-weight: 600; color: var(--text-muted); text-transform: uppercase;">Theme</span>
            <button id="mobileThemeToggleBtn" class="theme-toggle-btn" aria-label="Toggle Theme">
                <i class="fa-solid fa-moon"></i>
            </button>
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('software.home') }}" class="sidebar-link">Home</a></li>
            <li><a href="{{ route('software.features') }}" class="sidebar-link {{ Route::is('software.features') ? 'active' : '' }}">Features</a></li>
            <li><a href="{{ route('software.pricing') }}" class="sidebar-link {{ Route::is('software.pricing') ? 'active' : '' }}">Pricing</a></li>
            <li><a href="{{ route('software.industry') }}" class="sidebar-link {{ Route::is('software.industry') ? 'active' : '' }}">Industry</a></li>
            <li><a href="{{ route('software.contact') }}#contact-form-section" class="sidebar-cta">View Demo</a></li>
        </ul>
    </div>

    <!-- Main Content Area -->
    <main class="main-wrapper">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="landing-footer">
        <div class="stg-container">
            <div class="footer-grid">
                <!-- Brand block -->
                <div class="footer-logo-block">
                    <a href="{{ route('software.home') }}" class="logo-link">
                        <i class="fa-solid fa-ticket" style="color: var(--accent-blue);"></i> Book My<span>Ticket</span>
                    </a>
                    <p>The modern event ticketing platform for organizers, venues and businesses. Simplify your sales and operations.</p>
                    <div class="social-links">
                        <a href="#" class="social-btn"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="social-btn"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="social-btn"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="social-btn"><i class="fa-brands fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <!-- Col 1 -->
                <div class="footer-links-block">
                    <h4>Platform</h4>
                    <ul class="footer-links-list">
                        <li><a href="{{ route('software.home') }}#features-grid">Ticketing</a></li>
                        <li><a href="{{ route('software.home') }}#features-grid">Event Management</a></li>
                        <li><a href="{{ route('software.home') }}#seating-section">Seat Mapping</a></li>
                        <li><a href="{{ route('software.home') }}#analytics-charts-section">Analytics</a></li>
                        <li><a href="{{ route('software.home') }}#operations-section">Check-in</a></li>
                    </ul>
                </div>
                
                <!-- Col 2 -->
                <div class="footer-links-block">
                    <h4>Solutions</h4>
                    <ul class="footer-links-list">
                        <li><a href="{{ route('software.home') }}#solutions">Organizers</a></li>
                        <li><a href="{{ route('software.home') }}#solutions">Venues</a></li>
                        <li><a href="{{ route('software.home') }}#solutions">Festivals</a></li>
                        <li><a href="{{ route('software.home') }}#solutions">Corporate</a></li>
                    </ul>
                </div>

                <!-- Col 3 -->
                <div class="footer-links-block">
                    <h4>Resources</h4>
                    <ul class="footer-links-list">
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">API Status</a></li>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
                
                <!-- Col 4 -->
                <div class="footer-links-block">
                    <h4>Company</h4>
                    <ul class="footer-links-list">
                        <li><a href="#">About</a></li>
                        <li><a href="{{ route('software.contact') }}">Contact</a></li>
                        <li><a href="{{ route('software.features') }}">Features</a></li>
                        <li><a href="{{ route('software.pricing') }}">Pricing</a></li>
                        <li><a href="{{ route('software.industry') }}">Industry</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                <p>&copy; {{ date('Y') }} BookMyTicket. All rights reserved.</p>
                <div style="display: flex; gap: 20px;">
                    <a href="#" class="nav-link" style="font-size: 13px;">Privacy</a>
                    <a href="#" class="nav-link" style="font-size: 13px;">Terms</a>
                    <a href="#" class="nav-link" style="font-size: 13px;">Security</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Global Javascript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Base Interactions Script -->
    <script>
        $(document).ready(function() {
            // Header Scroll class
            $(window).scroll(function() {
                if ($(this).scrollTop() > 30) {
                    $('#mainHeader').addClass('scrolled');
                } else {
                    $('#mainHeader').removeClass('scrolled');
                }
            });

            // Mobile Menu interactions
            const openMenu = () => {
                $('#mobileSidebar').addClass('open');
                $('#sidebarOverlay').addClass('show');
                $('body').css('overflow', 'hidden');
            };
            
            const closeMenu = () => {
                $('#mobileSidebar').removeClass('open');
                $('#sidebarOverlay').removeClass('show');
                $('body').css('overflow', '');
            };

            $('#mobileMenuOpen').click(openMenu);
            $('#mobileMenuClose').click(closeMenu);
            $('#sidebarOverlay').click(closeMenu);
            $('.sidebar-link, .sidebar-cta').click(closeMenu);

            // Theme Toggle Logic
            const themeToggleBtns = $('#themeToggleBtn, #mobileThemeToggleBtn');
            
            function applyTheme(theme) {
                if (theme === 'light') {
                    $('body').addClass('light-theme');
                    themeToggleBtns.find('i').removeClass('fa-moon').addClass('fa-sun');
                    localStorage.setItem('theme', 'light');
                } else {
                    $('body').removeClass('light-theme');
                    themeToggleBtns.find('i').removeClass('fa-sun').addClass('fa-moon');
                    localStorage.setItem('theme', 'dark');
                }
            }

            // Check saved preference (default to light)
            const savedTheme = localStorage.getItem('theme') || 'light';
            applyTheme(savedTheme);
            
            themeToggleBtns.click(function() {
                const isLight = $('body').hasClass('light-theme');
                applyTheme(isLight ? 'dark' : 'light');
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>
