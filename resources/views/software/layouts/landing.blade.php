<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BookMyTicket Software - Event Ticket Booking Platform')</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/software-landing.css') }}">
    
    @yield('styles')
</head>
<body>

    <!-- Header Navigation -->
    <header class="landing-header" id="mainHeader">
        <div class="header-container">
            <a href="{{ route('software.home') }}" class="logo-link">
                <i class="fa-solid fa-ticket"></i> BookMy<span>Ticket</span>
            </a>
            
            <ul class="nav-menu">
                <li><a href="{{ route('software.home') }}" class="nav-link {{ Route::is('software.home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('software.features') }}" class="nav-link {{ Route::is('software.features') ? 'active' : '' }}">Features</a></li>
                <li><a href="{{ route('software.pricing') }}" class="nav-link {{ Route::is('software.pricing') ? 'active' : '' }}">Pricing</a></li>
                <li><a href="{{ route('software.contact') }}" class="nav-link {{ Route::is('software.contact') ? 'active' : '' }}">Contact Us</a></li>
                <li><a href="{{ route('software.contact') }}#contact-form-section" class="nav-cta">Book a Demo</a></li>
            </ul>
            
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
        <ul class="sidebar-menu">
            <li><a href="{{ route('software.home') }}" class="sidebar-link">Home</a></li>
            <li><a href="{{ route('software.features') }}" class="sidebar-link">Features</a></li>
            <li><a href="{{ route('software.pricing') }}" class="sidebar-link">Pricing</a></li>
            <li><a href="{{ route('software.contact') }}" class="sidebar-link">Contact Us</a></li>
            <li><a href="{{ route('software.contact') }}#contact-form-section" class="sidebar-cta">Book a Demo</a></li>
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
                <div class="footer-logo-block">
                    <a href="{{ route('software.home') }}" class="logo-link">
                        <i class="fa-solid fa-ticket"></i> BookMy<span>Ticket</span>
                    </a>
                    <p>Next-generation ticketing SaaS software that empowers event organizers with flexible categories and seat-layout based bookings. Scale your venue operations seamlessly.</p>
                    <div class="social-links">
                        <a href="#" class="social-btn"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="social-btn"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="social-btn"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="social-btn"><i class="fa-brands fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="footer-links-block">
                    <h4>Product</h4>
                    <ul class="footer-links-list">
                        <li><a href="{{ route('software.home') }}">Home</a></li>
                        <li><a href="{{ route('software.features') }}">Features</a></li>
                        <li><a href="{{ route('software.pricing') }}">Pricing Plans</a></li>
                        <li><a href="{{ route('software.home') }}#demo-widget">Live Demo</a></li>
                    </ul>
                </div>
                
                <div class="footer-links-block">
                    <h4>Company</h4>
                    <ul class="footer-links-list">
                        <li><a href="{{ route('software.contact') }}">Contact Us</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                    </ul>
                </div>
                
                <div class="footer-newsletter">
                    <h4>Request Sandbox</h4>
                    <p>Enter your business email below to request sandbox dashboard access credentials.</p>
                    <form class="footer-newsletter-form" id="footerLeadForm">
                        @csrf
                        <input type="hidden" name="type" value="popup_newsletter">
                        <input type="email" name="email" class="input-field" placeholder="business@email.com" required>
                        <button type="submit" class="btn-primary">Request</button>
                    </form>
                    <div style="margin-top: 10px; font-size: 13px;" id="footerLeadMsg"></div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} BookMyTicket Software. All rights reserved. Powered by stable next-gen ticketing technology.</p>
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

            // Footer lead form submission
            $('#footerLeadForm').submit(function(e) {
                e.preventDefault();
                const $form = $(this);
                const $msgDiv = $('#footerLeadMsg');
                const $btn = $form.find('button');
                
                $btn.prop('disabled', true).text('Sending...');
                $msgDiv.removeClass('success error').text('');

                $.ajax({
                    url: "{{ route('software.contact.submit') }}",
                    method: "POST",
                    data: $form.serialize(),
                    success: function(response) {
                        $btn.prop('disabled', false).text('Request');
                        if (response.success) {
                            $msgDiv.css('color', '#10b981').text(response.message);
                            $form.trigger('reset');
                        } else {
                            $msgDiv.css('color', '#ef4444').text('An error occurred. Please try again.');
                        }
                    },
                    error: function(xhr) {
                        $btn.prop('disabled', false).text('Request');
                        let errorMsg = 'Failed to submit. Please check your email.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMsg = Object.values(xhr.responseJSON.errors)[0][0];
                        }
                        $msgDiv.css('color', '#ef4444').text(errorMsg);
                    }
                });
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>
