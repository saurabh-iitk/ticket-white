@extends('software.layouts.landing')

@section('title', 'Book My Ticket - Enterprise Event Ticketing & Venue SaaS')

@section('content')

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="stg-container">
            <div class="hero-grid">
                <div style="max-width: 900px; margin: 0 auto;">
                    <div class="hero-eyebrow">ALL-IN-ONE EVENT TICKETING PLATFORM</div>
                    <h1 class="hero-headline">Run Every Event. <span class="gradient-text">Sell Every Seat.</span></h1>
                    <p class="hero-desc">The complete ticketing platform for organizers, venues, and businesses to create events, sell tickets, manage attendees, and grow revenue.</p>
                    
                    <div class="hero-btns">
                        <a href="{{ route('software.pricing') }}" class="btn-primary">Start Free <i class="fa-solid fa-arrow-right"></i></a>
                        <a href="{{ route('software.contact') }}#contact-form-section" class="btn-secondary">Book a Demo</a>
                    </div>
                    
                    <div class="hero-bullets">
                        <span><i class="fa-solid fa-circle-check"></i> No setup fees</span>
                        <span><i class="fa-solid fa-circle-check"></i> Secure payments</span>
                        <span><i class="fa-solid fa-circle-check"></i> Real-time analytics</span>
                    </div>
                </div>
            </div>
            
            <!-- Coded Interactive Dashboard Visual -->
            <div class="dashboard-mockup-wrapper">
                
                <!-- Floating Card 1 -->
                <div class="floating-widget-card sales-growth">
                    <span class="growth-tag"><i class="fa-solid fa-arrow-trend-up"></i> 24.8%</span>
                    <p style="font-size: 11px; font-weight: 600; color: var(--text-muted);">Ticket sales this month</p>
                </div>
                
                <!-- Floating Card 2 -->
                <div class="floating-widget-card live-occupancy">
                    <div class="occupancy-tag">
                        <span><i class="fa-solid fa-circle" style="color: var(--success); font-size: 8px; vertical-align: middle; margin-right: 4px;"></i> Live Event</span>
                        <span style="font-weight: 800; color: var(--accent-bright);">84%</span>
                    </div>
                    <h4 style="font-size: 13px; font-weight: 600; margin-bottom: 2px;">Summer Music Festival</h4>
                    <p style="font-size: 11px; color: var(--text-muted);">8,420 / 10,000 tickets sold</p>
                    <div class="progress-bar-wrap">
                        <div class="progress-fill" style="width: 84%;"></div>
                    </div>
                </div>
                
                <!-- Main Dashboard Window -->
                <div class="bmt-dashboard-window">
                    <!-- Left Sidebar -->
                    <div class="db-sidebar">
                        <div>
                            <div class="db-brand">
                                <i class="fa-solid fa-ticket" style="color: var(--accent-blue);"></i> BookMyTicket
                            </div>
                            <ul class="db-menu-list">
                                <li><a href="#" class="db-menu-item active"><i class="fa-solid fa-chart-pie"></i> Dashboard</a></li>
                                <li><a href="#" class="db-menu-item"><i class="fa-solid fa-calendar-days"></i> Events</a></li>
                                <li><a href="#" class="db-menu-item"><i class="fa-solid fa-receipt"></i> Orders</a></li>
                                <li><a href="#" class="db-menu-item"><i class="fa-solid fa-users"></i> Attendees</a></li>
                                <li><a href="#" class="db-menu-item"><i class="fa-solid fa-map-location-dot"></i> Venues</a></li>
                                <li><a href="#" class="db-menu-item"><i class="fa-solid fa-bullhorn"></i> Marketing</a></li>
                                <li><a href="#" class="db-menu-item"><i class="fa-solid fa-square-poll-vertical"></i> Analytics</a></li>
                                <li><a href="#" class="db-menu-item"><i class="fa-solid fa-credit-card"></i> Settlements</a></li>
                            </ul>
                        </div>
                        <div class="db-user-profile">
                            <div class="db-user-avatar">AA</div>
                            <div class="db-user-info">
                                <h4>Alex Admin</h4>
                                <p>Venue Manager</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Main Workspace -->
                    <div class="db-workspace">
                        <div class="db-header">
                            <h3>Sales Overview</h3>
                            <div class="db-search"><i class="fa-solid fa-magnifying-glass"></i> Search orders...</div>
                        </div>
                        
                        <div class="db-metrics-row">
                            <div class="db-metric-card">
                                <h5>Total Revenue</h5>
                                <div class="value">₹12.48L</div>
                            </div>
                            <div class="db-metric-card">
                                <h5>Tickets Sold</h5>
                                <div class="value">3,640</div>
                            </div>
                            <div class="db-metric-card">
                                <h5>Occupancy</h5>
                                <div class="value">84%</div>
                            </div>
                        </div>
                        
                        <!-- Simple visual graph curve representation -->
                        <div class="db-chart-placeholder">
                            <svg viewBox="0 0 500 100" width="100%" height="100%" style="overflow:visible;">
                                <path d="M 0 80 Q 80 40 160 50 T 320 20 T 480 10" fill="none" stroke="var(--accent-blue)" stroke-width="3" stroke-linecap="round"></path>
                                <path d="M 0 80 Q 80 40 160 50 T 320 20 T 480 10 L 480 100 L 0 100 Z" fill="none" style="fill: rgba(59, 130, 246, 0.05);"></path>
                                <circle cx="160" cy="50" r="4" fill="var(--accent-blue)"></circle>
                                <circle cx="320" cy="20" r="4" fill="var(--accent-blue)"></circle>
                            </svg>
                            <span style="position: absolute; font-size: 11px; color: var(--text-dark); bottom: 10px;">Sales Performance Tracker</span>
                        </div>
                        
                        <div class="db-recent-orders">
                            <h4>Recent Orders</h4>
                            <table class="db-table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Event Name</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>BMT-8452</td>
                                        <td>Summer Music Festival</td>
                                        <td>₹2,499</td>
                                        <td><span class="status-badge">Checked In</span></td>
                                    </tr>
                                    <tr>
                                        <td>BMT-8453</td>
                                        <td>Standup Comedy Tour</td>
                                        <td>₹999</td>
                                        <td><span class="status-badge">Checked In</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    <!-- Trust Strip -->
    <section class="trust-strip">
        <div class="stg-container">
            <div class="trust-grid">
                <div class="trust-item">
                    <h3>500+</h3>
                    <p>Events Managed</p>
                </div>
                <div class="trust-item">
                    <h3>100+</h3>
                    <p>Organizers</p>
                </div>
                <div class="trust-item">
                    <h3>50+</h3>
                    <p>Venues Scaled</p>
                </div>
                <div class="trust-item">
                    <h3>1M+</h3>
                    <p>Tickets Processed</p>
                </div>
            </div>
    </section>

    <!-- Client Logos Infinite Marquee / Slider -->
    <section style="background-color: var(--secondary-bg); padding: 20px 0; border-bottom: 1px solid var(--border-color); overflow: hidden;">
        <div style="display: flex; flex-direction: column; gap: 6px; width: 100%;">
            <!-- Row 1: Going Left -->
            <div class="logo-marquee-wrapper">
                <div class="logo-marquee-track">
                    <div class="marquee-logo-badge"><i class="fa-solid fa-volleyball" style="color: #10B981;"></i> City Arena</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-microphone-lines" style="color: #EC4899;"></i> Comedy Club</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-umbrella-beach" style="color: #F59E0B;"></i> Goa Sunfest</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-display" style="color: #06B6D4;"></i> IMAX Noida</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-champagne-glasses" style="color: #EAB308;"></i> Club Aura</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-guitar" style="color: #EF4444;"></i> Sunburn Beats</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-masks-theater" style="color: #A855F7;"></i> Grand Theatre</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-guitar" style="color: #F43F5E;"></i> Ultra Music</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-monument" style="color: #059669;"></i> Kingdom Dome</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-circle-play" style="color: #4F46E5;"></i> Indie Fest</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-music" style="color: #DC2626;"></i> Lollapalooza</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-volume-high" style="color: #0D9488;"></i> Decibel Hall</div>
                    <!-- Duplicate for infinite scroll loop -->
                    <div class="marquee-logo-badge"><i class="fa-solid fa-volleyball" style="color: #10B981;"></i> City Arena</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-microphone-lines" style="color: #EC4899;"></i> Comedy Club</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-umbrella-beach" style="color: #F59E0B;"></i> Goa Sunfest</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-display" style="color: #06B6D4;"></i> IMAX Noida</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-champagne-glasses" style="color: #EAB308;"></i> Club Aura</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-guitar" style="color: #EF4444;"></i> Sunburn Beats</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-masks-theater" style="color: #A855F7;"></i> Grand Theatre</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-guitar" style="color: #F43F5E;"></i> Ultra Music</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-monument" style="color: #059669;"></i> Kingdom Dome</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-circle-play" style="color: #4F46E5;"></i> Indie Fest</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-music" style="color: #DC2626;"></i> Lollapalooza</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-volume-high" style="color: #0D9488;"></i> Decibel Hall</div>
                </div>
            </div>
            
            <!-- Row 2: Going Right -->
            <div class="logo-marquee-wrapper">
                <div class="logo-marquee-track-reverse">
                    <div class="marquee-logo-badge"><i class="fa-solid fa-volume-high" style="color: #0D9488;"></i> Decibel Hall</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-music" style="color: #DC2626;"></i> Lollapalooza</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-circle-play" style="color: #4F46E5;"></i> Indie Fest</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-monument" style="color: #059669;"></i> Kingdom Dome</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-guitar" style="color: #F43F5E;"></i> Ultra Music</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-masks-theater" style="color: #A855F7;"></i> Grand Theatre</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-guitar" style="color: #EF4444;"></i> Sunburn Beats</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-champagne-glasses" style="color: #EAB308;"></i> Club Aura</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-display" style="color: #06B6D4;"></i> IMAX Noida</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-umbrella-beach" style="color: #F59E0B;"></i> Goa Sunfest</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-microphone-lines" style="color: #EC4899;"></i> Comedy Club</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-volleyball" style="color: #10B981;"></i> City Arena</div>
                    <!-- Duplicate for infinite scroll loop -->
                    <div class="marquee-logo-badge"><i class="fa-solid fa-volume-high" style="color: #0D9488;"></i> Decibel Hall</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-music" style="color: #DC2626;"></i> Lollapalooza</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-circle-play" style="color: #4F46E5;"></i> Indie Fest</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-monument" style="color: #059669;"></i> Kingdom Dome</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-guitar" style="color: #F43F5E;"></i> Ultra Music</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-masks-theater" style="color: #A855F7;"></i> Grand Theatre</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-guitar" style="color: #EF4444;"></i> Sunburn Beats</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-champagne-glasses" style="color: #EAB308;"></i> Club Aura</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-display" style="color: #06B6D4;"></i> IMAX Noida</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-umbrella-beach" style="color: #F59E0B;"></i> Goa Sunfest</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-microphone-lines" style="color: #EC4899;"></i> Comedy Club</div>
                    <div class="marquee-logo-badge"><i class="fa-solid fa-volleyball" style="color: #10B981;"></i> City Arena</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Bento Grid Section -->
    <section class="features-section" id="features-grid">
        <div class="stg-container">
            <div class="section-header">
                <span>Everything You Need to Run Better Events</span>
                <h2>Everything You Need<br><span class="gradient-text">To Run Better Events</span></h2>
                <p>From ticket sales to check-in, payments and analytics — manage your entire event from one powerful platform.</p>
            </div>
                 <div class="bento-grid-wrapper">
                <!-- Card 1: Ticketing & QR Check-ins -->
                <div class="bento-card bento-card-1">
                    <div class="bento-card-header-row">
                        <div class="bento-card-icon bento-accent-blue"><i class="fa-solid fa-ticket"></i></div>
                        <h3>Ticketing & QR Check-ins</h3>
                    </div>
                    <p class="bento-card-desc">Sell tickets online with multiple types, scan QR codes for check-ins, and track attendance with a live dashboard.</p>
                    
                    <div class="bento-card-body ticket-preview-box">
                        <!-- Digital Event Ticket Mockup -->
                        <div class="bmt-digital-ticket">
                            <div class="ticket-header" style="background-color: var(--accent-blue); padding: 12px 16px 14px 16px; margin: -14px -14px 14px -14px; border-bottom: none;">
                                <h4 style="color: #FFFFFF !important; margin: 0; font-size: 9px; font-weight: 700; letter-spacing: 1px; opacity: 0.9;">EVENT SCHEDULE</h4>
                                <span style="color: #FFFFFF !important; font-size: 14px; font-weight: 800; display: block; margin-top: 2px;">Jazz Night</span>
                            </div>
                            
                            <!-- Ticket notches and perforation -->
                            <div class="ticket-notch notch-left"></div>
                            <div class="ticket-notch notch-right"></div>
                            <div class="ticket-perforated"></div>
                            
                            <div class="ticket-qr-wrap" style="padding: 6px 0; display: flex; justify-content: center; position: relative;">
                                <div class="qr-placeholder" style="position: relative; display: inline-block; padding: 10px; background-color: #FFFFFF; border-radius: 6px;">
                                    <img src="{{ asset('assets/images/qr-code-user.png') }}" style="width: 96px; height: 96px; display: block; object-fit: contain;" alt="QR Code">
                                    <!-- Scanning laser animation line -->
                                    <div class="scan-laser-line"></div>
                                </div>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 10px; color: var(--text-muted); margin-top: 10px; border-top: none; padding-top: 8px;">
                                <span>GA x1</span>
                                <span>#0042</span>
                            </div>
                        </div>
                        
                        <!-- Floating Checked In Badge -->
                        <div class="bento-floating-stat" style="position: absolute; bottom: 20px; left: 16px; padding: 5px 10px; border-radius: 6px;">
                            <span class="lbl" style="font-weight: 700; color: var(--text-light); font-size: 9px;"><i class="fa-solid fa-circle-check" style="color: var(--success); margin-right: 3px;"></i> 142 checked in</span>
                        </div>
                    </div>
                    
                    <div class="bento-card-footer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; font-size: 11px; border-top: 1px solid var(--border-color); padding-top: 12px;">
                        <span style="color: var(--text-muted);"><i class="fa-solid fa-lock" style="margin-right: 4px;"></i> Secure Stripe payments</span>
                        <a href="{{ route('software.features') }}" class="bento-learn-more-link link-accent-blue" style="font-weight: 600;">Learn more <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Card 2: Newsletters -->
                <div class="bento-card bento-card-2">
                    <div class="bento-card-header-row">
                        <div class="bento-card-icon bento-accent-blue"><i class="fa-solid fa-envelope"></i></div>
                        <h3>Newsletters</h3>
                    </div>
                    
                    <div class="bento-card-body-row">
                        <div class="bento-text-side">
                            <p class="bento-card-desc">Send branded emails to followers and ticket buyers with a drag-and-drop editor and A/B testing.</p>
                            <div>
                                <div style="color: var(--text-dark); font-size: 10px; margin-bottom: 6px;">Templates &bull; Audience segments &bull; A/B testing</div>
                                <a href="{{ route('software.features') }}" class="bento-learn-more-link link-accent-blue" style="font-weight: 600;">Learn more <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="bento-visual-side">
                            <!-- Mini Newsletter Preview Mockup -->
                            <div style="position: relative; width: 100%; max-width: 145px; margin-left: auto;">
                                <!-- Sent to 940 followers tag -->
                                <div style="position: absolute; top: -10px; right: 0; background-color: var(--accent-blue); color: #FFFFFF; font-size: 8px; font-weight: 700; padding: 3px 8px; border-radius: 10px; z-index: 2; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                    Sent to 940 followers
                                </div>
                                <div style="background-color: var(--secondary-bg); border: 1px solid var(--border-color); border-radius: 10px; padding: 12px; width: 100%; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                                    <div style="background-color: var(--accent-blue); padding: 6px 10px; border-radius: 5px; font-size: 9px; color: #FFFFFF; font-weight: 700; display: flex; align-items: center; gap: 5px;">
                                        <i class="fa-solid fa-envelope-open"></i> This Week's Events
                                    </div>
                                    <div style="background-color: rgba(59, 130, 246, 0.05); height: 32px; border-radius: 5px; border: 1px dashed var(--border-color); margin-top: 8px; display: flex; align-items: center; justify-content: center; font-size: 8px; font-weight: 700; color: var(--accent-blue);">
                                        Featured Event
                                    </div>
                                    <div style="display: flex; gap: 6px; margin-top: 8px;">
                                        <div style="flex:1; height: 16px; background-color: rgba(255,255,255,0.01); border: 1px solid var(--border-color); border-radius: 4px;"></div>
                                        <div style="flex:1; height: 16px; background-color: rgba(255,255,255,0.01); border: 1px solid var(--border-color); border-radius: 4px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: AI-Powered -->
                <div class="bento-card bento-card-3">
                    <div class="bento-card-header-row">
                        <div class="bento-card-icon bento-accent-blue"><i class="fa-solid fa-brain"></i></div>
                        <h3>AI-Powered</h3>
                    </div>
                    
                    <div class="bento-card-body-row">
                        <div class="bento-text-side">
                            <p class="bento-card-desc">Parse text and images, generate flyers and descriptions, create your brand style, and translate to 12 languages with AI.</p>
                            <div>
                                <a href="{{ route('software.features') }}" class="bento-learn-more-link link-accent-blue" style="font-weight: 600;">Learn more <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="bento-visual-side">
                            <div style="display: flex; align-items: center; gap: 10px; width: 100%; max-width: 176px; margin-left: auto;">
                                <!-- Left card (uploaded flyer thumbnail) -->
                                <div style="background-color: var(--secondary-bg); border: 1px solid var(--border-color); border-radius: 8px; padding: 10px; text-align: center; flex: 1; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                                    <i class="fa-regular fa-image" style="font-size: 14px; color: var(--text-muted); margin-bottom: 5px; display: block;"></i>
                                    <div style="height: 3px; background-color: var(--border-color); border-radius: 2px; width: 80%; margin: 3px auto;"></div>
                                    <div style="height: 3px; background-color: var(--border-color); border-radius: 2px; width: 50%; margin: 3px auto;"></div>
                                </div>
                                <i class="fa-solid fa-arrow-right" style="color: var(--accent-blue); font-size: 12px;"></i>
                                <!-- Right stack (extracted attributes) -->
                                <div style="display: flex; flex-direction: column; gap: 5px; flex: 1.5;">
                                    <div style="background-color: var(--secondary-bg); border: 1px solid var(--border-color); border-radius: 5px; padding: 4px 6px; display: flex; align-items: center; gap: 5px; color: var(--text-light); font-size: 8px; font-weight:600;"><i class="fa-regular fa-calendar" style="color: var(--accent-blue);"></i> Sat, Jul 18 - 8:00 PM</div>
                                    <div style="background-color: var(--secondary-bg); border: 1px solid var(--border-color); border-radius: 5px; padding: 4px 6px; display: flex; align-items: center; gap: 5px; color: var(--text-light); font-size: 8px; font-weight:600;"><i class="fa-solid fa-location-dot" style="color: var(--accent-blue);"></i> The Blue Note</div>
                                    <div style="background-color: var(--secondary-bg); border: 1px solid var(--border-color); border-radius: 5px; padding: 4px 6px; display: flex; align-items: center; gap: 5px; color: var(--text-light); font-size: 8px; font-weight:600;"><i class="fa-solid fa-ticket" style="color: var(--accent-blue);"></i> $25 - 120 tickets</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Boost -->
                <div class="bento-card bento-card-4">
                    <div class="bento-card-header-row">
                        <div class="bento-card-icon bento-accent-orange"><i class="fa-solid fa-rocket"></i></div>
                        <h3>Boost</h3>
                    </div>
                    <p class="bento-card-desc">Turn any event into a Facebook or Instagram ad in minutes. Set your budget, pick your audience, and launch.</p>
                    
                    <div class="bento-card-body" style="margin-top: 15px;">
                        <div style="background-color: var(--secondary-bg); border: 1px solid var(--border-color); border-radius: 10px; padding: 10px; width: 100%; max-width: 136px; margin: 12px auto 0 auto; box-shadow: 0 4px 15px rgba(0,0,0,0.05); font-size: 9px;">
                            <div style="display: flex; align-items: center; gap: 5px; margin-bottom: 6px;">
                                <div style="width: 14px; height: 14px; border-radius: 50%; background-color: var(--accent-orange); display: flex; align-items: center; justify-content: center; color: #FFFFFF; font-size: 7px;"><i class="fa-solid fa-music"></i></div>
                                <div>
                                    <div style="font-weight: 700; color: var(--text-light); line-height: 1;">The Blue Note</div>
                                    <div style="font-size: 7px; color: var(--text-muted);">Sponsored</div>
                                </div>
                            </div>
                            <div style="background-color: #FEF08A; color: #854D0E; padding: 14px 8px; border-radius: 6px; font-weight: 800; text-align: center; margin-bottom: 6px; font-size: 11px; letter-spacing: 0.5px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);">
                                Jazz Night
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 8px;">
                                <span style="color: var(--text-muted);"><i class="fa-regular fa-heart"></i> 142</span>
                                <span style="background-color: #EA580C; color: #FFFFFF; padding: 2px 6px; border-radius: 3px; font-weight: 700; font-size: 8px;">Learn More</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bento-card-footer" style="margin-top: 15px; font-size: 12px;">
                        <a href="{{ route('software.features') }}" class="bento-learn-more-link link-accent-orange" style="font-weight: 600;">Learn more <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Card 5: Built-in Analytics -->
                <div class="bento-card bento-card-5">
                    <div class="bento-card-header-row">
                        <div class="bento-card-icon bento-accent-green"><i class="fa-solid fa-chart-simple"></i></div>
                        <h3>Built-in Analytics</h3>
                    </div>
                    <p class="bento-card-desc">Track page views, device breakdown, top events, and traffic sources. No external services required.</p>
                    
                    <div class="bento-card-body" style="margin-top: 15px;">
                        <div style="display: flex; justify-content: center; align-items: flex-end; gap: 8px; height: 72px; margin-bottom: 12px;">
                            <!-- 5 solid green bars -->
                            <div style="width: 18px; height: 28px; background-color: rgba(16, 185, 129, 0.7); border-radius: 4px;"></div>
                            <div style="width: 18px; height: 45px; background-color: rgba(16, 185, 129, 0.7); border-radius: 4px;"></div>
                            <div style="width: 18px; height: 35px; background-color: rgba(16, 185, 129, 0.7); border-radius: 4px;"></div>
                            <div style="width: 18px; height: 60px; background-color: rgba(16, 185, 129, 0.7); border-radius: 4px;"></div>
                            <div style="width: 18px; height: 50px; background-color: rgba(16, 185, 129, 0.7); border-radius: 4px;"></div>
                            <!-- 1 solid blue bar -->
                            <div style="width: 18px; height: 72px; background-color: #4E81FA; border-radius: 4px;"></div>
                        </div>
                        <div style="font-size: 10px; font-weight: 700; text-align: center; color: var(--text-light);">12,480 page views this month</div>
                    </div>
                    
                    <div class="bento-card-footer" style="margin-top: 15px; font-size: 12px;">
                        <a href="{{ route('software.features') }}" class="bento-learn-more-link link-accent-green" style="font-weight: 600;">Learn more <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Card 6: Calendar Sync -->
                <div class="bento-card bento-card-6">
                    <div class="bento-card-header-row">
                        <div class="bento-card-icon bento-accent-blue"><i class="fa-solid fa-calendar-days"></i></div>
                        <h3>Calendar Sync</h3>
                    </div>
                    <p class="bento-card-desc">Two-way sync with Google Calendar. Let attendees add events to Apple, Google, or Outlook calendars.</p>
                    
                    <div class="bento-card-body" style="margin-top: 15px; display: flex; align-items: center; justify-content: center; gap: 12px;">
                        <div style="background-color: var(--accent-blue); width: 28px; height: 28px; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #FFFFFF; font-size: 10px; font-weight: 800; box-shadow: 0 4px 10px rgba(59, 130, 246, 0.2);">ES</div>
                        <div style="border-top: 2px dashed var(--border-color); width: 36px; position: relative;">
                            <div style="position: absolute; top: -4px; left: 15px; width: 6px; height: 6px; border-radius: 50%; background-color: var(--accent-bright);"></div>
                        </div>
                        <div class="mini-calendar-mockup" style="background-color: var(--secondary-bg); border: 1px solid var(--border-color); width: 32px; height: 32px; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 4px 12px rgba(0,0,0,0.08); position: relative; flex-shrink: 0;">
                            <div style="background-color: var(--accent-blue); height: 8px; width: 100%; display: flex; justify-content: space-around; align-items: center; padding: 0 4px;">
                                <div style="width: 2px; height: 3px; background-color: #FFFFFF; border-radius: 1px;"></div>
                                <div style="width: 2px; height: 3px; background-color: #FFFFFF; border-radius: 1px;"></div>
                            </div>
                            <div style="flex-grow: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; background-color: var(--card-bg); padding: 2px;">
                                <span style="font-size: 12px; font-weight: 800; color: var(--text-light); line-height: 1;">24</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bento-card-footer" style="margin-top: 15px; font-size: 12px;">
                        <a href="{{ route('software.features') }}" class="bento-learn-more-link link-accent-blue" style="font-weight: 600;">Learn more <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>  </div>
        </div>
    </section>

    <!-- Product Showcase (Ticketing Checkout Builder) -->
    <section style="background-color: var(--secondary-bg); border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
        <div class="stg-container">
            <div class="showcase-grid">
                <!-- Left Details -->
                <div class="showcase-content">
                    <span style="color: var(--accent-blue); font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: 1px; display: block; margin-bottom: 10px;">One Platform. Everything under control.</span>
                    <h3>Sell tickets without the complexity.</h3>
                    <p>Create unlimited ticket types, set pricing, manage inventory, and control your entire sales flow from a single platform.</p>
                    <ul class="showcase-checklist">
                        <li><i class="fa-solid fa-check"></i> General admission & VIP options</li>
                        <li><i class="fa-solid fa-check"></i> Early bird pricing & automatic rises</li>
                        <li><i class="fa-solid fa-check"></i> Coupons and custom promos code</li>
                        <li><i class="fa-solid fa-check"></i> Session locks for ticket holds</li>
                    </ul>
                    <a href="{{ route('software.contact') }}#contact-form-section" class="btn-secondary">Explore Ticketing <i class="fa-solid fa-arrow-right" style="margin-left: 5px;"></i></a>
                </div>
                
                <!-- Right Checkout Preview Widget -->
                <div class="checkout-preview-card">
                    <div class="checkout-header">
                        <h4>SUMMER MUSIC FESTIVAL</h4>
                        <p><i class="fa-solid fa-location-dot"></i> Grand Arena | 24 AUG &middot; 7:00 PM</p>
                    </div>
                    
                    <div class="checkout-tier-list">
                        <!-- VIP -->
                        <div class="checkout-tier-item" data-price="2499" data-name="VIP">
                            <div class="tier-info">
                                <h5>VIP Ticket</h5>
                                <span>₹2,499</span>
                            </div>
                            <div class="tier-qty-selector">
                                <button class="tier-qty-btn select-qty-minus">-</button>
                                <span class="tier-qty-val select-qty-val">0</span>
                                <button class="tier-qty-btn select-qty-plus">+</button>
                            </div>
                        </div>
                        
                        <!-- General -->
                        <div class="checkout-tier-item" data-price="999" data-name="General">
                            <div class="tier-info">
                                <h5>General Admission</h5>
                                <span>₹999</span>
                            </div>
                            <div class="tier-qty-selector">
                                <button class="tier-qty-btn select-qty-minus">-</button>
                                <span class="tier-qty-val select-qty-val">0</span>
                                <button class="tier-qty-btn select-qty-plus">+</button>
                            </div>
                        </div>
                        
                        <!-- Early Bird -->
                        <div class="checkout-tier-item" data-price="699" data-name="Early Bird">
                            <div class="tier-info">
                                <h5>Early Bird Special</h5>
                                <span>₹699</span>
                            </div>
                            <div class="tier-qty-selector">
                                <button class="tier-qty-btn select-qty-minus">-</button>
                                <span class="tier-qty-val select-qty-val">0</span>
                                <button class="tier-qty-btn select-qty-plus">+</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="checkout-summary-block">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span id="subtotalVal">₹0</span>
                        </div>
                        <div class="summary-row">
                            <span>GST (18%):</span>
                            <span id="taxVal">₹0</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total Price:</span>
                            <span id="totalVal">₹0</span>
                        </div>
                    </div>
                    
                    <button class="checkout-submit-btn" id="simPaymentBtn" disabled>Proceed to Payment</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Seating Layout Mapping Showcase Section -->
    <section class="seating-section" id="seating-section">
        <div class="stg-container">
            <div class="seating-grid">
                
                <!-- Left Seating Grid simulation -->
                <div class="seating-panel-visual">
                    <div class="seating-stage">STAGE</div>
                    <div class="seating-matrix">
                        <!-- Row A -->
                        <div class="seating-row" data-row="A" data-price="2499">
                            <span class="seat-lbl">A</span>
                            <div class="seat-node vip" data-num="A-1"></div>
                            <div class="seat-node vip" data-num="A-2"></div>
                            <div class="seat-node vip booked" data-num="A-3"></div>
                            <div class="seat-node vip" data-num="A-4"></div>
                            <div class="seat-node vip" data-num="A-5"></div>
                            <div class="seat-node vip" data-num="A-6"></div>
                            <div class="seat-node vip booked" data-num="A-7"></div>
                            <div class="seat-node vip" data-num="A-8"></div>
                        </div>
                        <!-- Row B -->
                        <div class="seating-row" data-row="B" data-price="1499">
                            <span class="seat-lbl">B</span>
                            <div class="seat-node premium" data-num="B-1"></div>
                            <div class="seat-node premium booked" data-num="B-2"></div>
                            <div class="seat-node premium" data-num="B-3"></div>
                            <div class="seat-node premium" data-num="B-4"></div>
                            <div class="seat-node premium" data-num="B-5"></div>
                            <div class="seat-node premium" data-num="B-6"></div>
                            <div class="seat-node premium" data-num="B-7"></div>
                            <div class="seat-node premium" data-num="B-8"></div>
                        </div>
                        <!-- Row C -->
                        <div class="seating-row" data-row="C" data-price="1499">
                            <span class="seat-lbl">C</span>
                            <div class="seat-node premium" data-num="C-1"></div>
                            <div class="seat-node premium" data-num="C-2"></div>
                            <div class="seat-node premium" data-num="C-3"></div>
                            <div class="seat-node premium booked" data-num="C-4"></div>
                            <div class="seat-node premium booked" data-num="C-5"></div>
                            <div class="seat-node premium" data-num="C-6"></div>
                            <div class="seat-node premium" data-num="C-7"></div>
                            <div class="seat-node premium" data-num="C-8"></div>
                        </div>
                        <!-- Row D -->
                        <div class="seating-row" data-row="D" data-price="999">
                            <span class="seat-lbl">D</span>
                            <div class="seat-node standard" data-num="D-1"></div>
                            <div class="seat-node standard" data-num="D-2"></div>
                            <div class="seat-node standard" data-num="D-3"></div>
                            <div class="seat-node standard" data-num="D-4"></div>
                            <div class="seat-node standard" data-num="D-5"></div>
                            <div class="seat-node standard" data-num="D-6"></div>
                            <div class="seat-node standard" data-num="D-7"></div>
                            <div class="seat-node standard booked" data-num="D-8"></div>
                        </div>
                    </div>
                    
                    <div class="seating-legend">
                        <div class="legend-dot-item"><span class="legend-box" style="background-color: var(--accent-blue);"></span> VIP (₹2,499)</div>
                        <div class="legend-dot-item"><span class="legend-box" style="background-color: var(--warning);"></span> Standard (₹999)</div>
                        <div class="legend-dot-item"><span class="legend-box" style="background-color: #1e293b; opacity: 0.3;"></span> Booked</div>
                    </div>
                </div>
                
                <!-- Right Details -->
                <div class="showcase-content">
                    <span style="color: var(--accent-blue); font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: 1px; display: block; margin-bottom: 10px;">Designed for every venue</span>
                    <h3>Turn Your Venue Into An Interactive Experience</h3>
                    <p>Build custom seating plans, define block matrices, and let attendees select their preferred seats. Increase tickets conversions with dynamic holds.</p>
                    <ul class="showcase-checklist">
                        <li><i class="fa-solid fa-check"></i> Interactive visual seat mapping</li>
                        <li><i class="fa-solid fa-check"></i> Live real-time availability updates</li>
                        <li><i class="fa-solid fa-check"></i> Custom layout locks and blocked holds</li>
                        <li><i class="fa-solid fa-check"></i> Flexible price rules based on rows</li>
                    </ul>
                    <div style="background-color: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); padding: 15px 20px; border-radius: 12px; margin-top: 25px; display: flex; justify-content: space-between; align-items: center;" id="seatMapStatusBox">
                        <span style="font-size: 13px; color: var(--text-muted);" id="seatMapSelectedText">Tap seats to simulate selection.</span>
                        <strong style="color: var(--success); font-size: 15px;" id="seatMapPriceVal">₹0</strong>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Event Operations Section -->
    <section class="operations-section" id="operations-section">
        <div class="stg-container">
            <div class="section-header">
                <span>Operational Pipeline</span>
                <h2>From Sale to Scan <span class="gradient-text">Without the Chaos</span></h2>
                <p>Simplify event entry. Integrate ticketing checkout flows, automated confirmations, and check-in scanner tools in a single dashboard.</p>
            </div>
            
            <!-- Horizontal flow steps -->
            <div class="ops-flow-wrapper">
                <div class="ops-step-node active">
                    <div class="ops-icon-ring"><i class="fa-solid fa-plus"></i></div>
                    <h4>Create</h4>
                </div>
                <div class="ops-step-node">
                    <div class="ops-icon-ring"><i class="fa-solid fa-receipt"></i></div>
                    <h4>Sell</h4>
                </div>
                <div class="ops-step-node">
                    <div class="ops-icon-ring"><i class="fa-solid fa-credit-card"></i></div>
                    <h4>Pay</h4>
                </div>
                <div class="ops-step-node">
                    <div class="ops-icon-ring"><i class="fa-solid fa-ticket-simple"></i></div>
                    <h4>Confirm</h4>
                </div>
                <div class="ops-step-node">
                    <div class="ops-icon-ring"><i class="fa-solid fa-expand"></i></div>
                    <h4>Scan</h4>
                </div>
                <div class="ops-step-node">
                    <div class="ops-icon-ring"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
                    <h4>Analyze</h4>
                </div>
            </div>
            
            <div class="ops-metrics-row">
                <div class="ops-metric-card">
                    <h5>Tickets Sold</h5>
                    <div class="metric-val">3,640</div>
                    <p style="color: var(--text-muted);">Real-time count sales</p>
                </div>
                <div class="ops-metric-card">
                    <h5>Ticket Deliveries</h5>
                    <div class="metric-val">QR Ticket</div>
                    <p style="color: var(--text-muted);">Secure digital delivery</p>
                </div>
                <div class="ops-metric-card">
                    <h5>Check-in status</h5>
                    <div class="metric-val">✓ Active</div>
                    <p style="color: var(--text-muted);">Gate scan synchronization</p>
                </div>
                <div class="ops-metric-card">
                    <h5>Attendance</h5>
                    <div class="metric-val">84%</div>
                    <p style="color: var(--text-muted);">Actual attendees scanned</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Analytics Section -->
    <section class="analytics-section" id="analytics-charts-section">
        <div class="stg-container">
            <div class="section-header">
                <span>Know Your Event. Grow Your Business.</span>
                <h2>Your event data, <span class="gradient-text">in real time.</span></h2>
                <p>Analyze transaction graphs, visitor log conversions, and category performances to optimize pricing and maximize revenue.</p>
            </div>

            <div class="analytics-dashboard-panel">
                <div class="chart-tabs-wrap">
                    <div class="chart-tabs">
                        <button class="chart-tab-btn active" data-tab="revenue">
                            <i class="fa-solid fa-chart-line"></i> Revenue Analytics
                        </button>
                        <button class="chart-tab-btn" data-tab="distribution">
                            <i class="fa-solid fa-chart-pie"></i> Booking Channels
                        </button>
                    </div>
                    <div class="chart-filters" id="chartFilters">
                        <button class="chart-filter-btn active" data-filter="week">Weekly</button>
                        <button class="chart-filter-btn" data-filter="month">Monthly</button>
                    </div>
                </div>

                <div class="chart-body-grid">
                    <!-- SVG Chart Container -->
                    <div class="chart-svg-container" id="chartContainer">
                        <div class="chart-tooltip-bubble" id="chartTooltip">
                            <strong id="tooltipDate">Aug 20</strong><br>
                            <span id="tooltipVal" style="color: var(--accent-blue); font-weight: 700;">₹1,24,000</span>
                        </div>

                        <!-- Revenue Line Chart SVG -->
                        <svg viewBox="0 0 600 250" width="100%" height="250" id="revenueSvg" style="overflow: visible;">
                            <!-- Grid Lines -->
                            <line x1="50" y1="50" x2="550" y2="50" stroke="rgba(255,255,255,0.05)" stroke-width="1"></line>
                            <line x1="50" y1="110" x2="550" y2="110" stroke="rgba(255,255,255,0.05)" stroke-width="1"></line>
                            <line x1="50" y1="170" x2="550" y2="170" stroke="rgba(255,255,255,0.05)" stroke-width="1"></line>
                            <line x1="50" y1="220" x2="550" y2="220" stroke="rgba(255,255,255,0.1)" stroke-width="1.5"></line>

                            <!-- Y-Axis Labels -->
                            <text x="15" y="55" fill="var(--text-muted)" font-size="11" font-family="var(--font-family)">₹2.5L</text>
                            <text x="15" y="115" fill="var(--text-muted)" font-size="11" font-family="var(--font-family)">₹1.5L</text>
                            <text x="15" y="175" fill="var(--text-muted)" font-size="11" font-family="var(--font-family)">₹50K</text>
                            <text x="35" y="225" fill="var(--text-muted)" font-size="11" font-family="var(--font-family)">0</text>

                            <!-- Line Chart Paths -->
                            <path d="M 50 190 L 133 150 L 216 110 L 299 130 L 382 70 L 465 90 L 550 50" 
                                  fill="none" stroke="var(--accent-blue)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
                                  class="animate-chart-path" id="weeklyPath" style="display: block;"></path>
                                  
                            <path d="M 50 170 L 133 180 L 216 140 L 299 90 L 382 60 L 465 110 L 550 40" 
                                  fill="none" stroke="#7C3AED" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
                                  class="animate-chart-path" id="monthlyPath" style="display: none;"></path>

                            <!-- Clickable/Hoverable Data Points -->
                            <g id="weeklyNodes">
                                <circle cx="50" cy="190" r="6" fill="var(--secondary-bg)" stroke="var(--accent-blue)" stroke-width="3" style="cursor: pointer;" data-date="Aug 17" data-val="₹35,000"></circle>
                                <circle cx="133" cy="150" r="6" fill="var(--secondary-bg)" stroke="var(--accent-blue)" stroke-width="3" style="cursor: pointer;" data-date="Aug 18" data-val="₹85,000"></circle>
                                <circle cx="216" cy="110" r="6" fill="var(--secondary-bg)" stroke="var(--accent-blue)" stroke-width="3" style="cursor: pointer;" data-date="Aug 19" data-val="₹1,50,000"></circle>
                                <circle cx="299" cy="130" r="6" fill="var(--secondary-bg)" stroke="var(--accent-blue)" stroke-width="3" style="cursor: pointer;" data-date="Aug 20" data-val="₹1,24,000"></circle>
                                <circle cx="382" cy="70" r="6" fill="var(--secondary-bg)" stroke="var(--accent-blue)" stroke-width="3" style="cursor: pointer;" data-date="Aug 21" data-val="₹2,10,000"></circle>
                                <circle cx="465" cy="90" r="6" fill="var(--secondary-bg)" stroke="var(--accent-blue)" stroke-width="3" style="cursor: pointer;" data-date="Aug 22" data-val="₹1,85,000"></circle>
                                <circle cx="550" cy="50" r="6" fill="var(--secondary-bg)" stroke="var(--accent-blue)" stroke-width="3" style="cursor: pointer;" data-date="Aug 23" data-val="₹2,45,000"></circle>
                            </g>

                            <g id="monthlyNodes" style="display: none;">
                                <circle cx="50" cy="170" r="6" fill="var(--secondary-bg)" stroke="#7C3AED" stroke-width="3" style="cursor: pointer;" data-date="May 2026" data-val="₹2,62,000"></circle>
                                <circle cx="133" cy="180" r="6" fill="var(--secondary-bg)" stroke="#7C3AED" stroke-width="3" style="cursor: pointer;" data-date="Jun 2026" data-val="₹2,50,000"></circle>
                                <circle cx="216" cy="140" r="6" fill="var(--secondary-bg)" stroke="#7C3AED" stroke-width="3" style="cursor: pointer;" data-date="Jul 2026" data-val="₹4,05,000"></circle>
                                <circle cx="299" cy="90" r="6" fill="var(--secondary-bg)" stroke="#7C3AED" stroke-width="3" style="cursor: pointer;" data-date="Aug 2026" data-val="₹6,80,000"></circle>
                                <circle cx="382" cy="60" r="6" fill="var(--secondary-bg)" stroke="#7C3AED" stroke-width="3" style="cursor: pointer;" data-date="Sep 2026" data-val="₹8,25,000"></circle>
                                <circle cx="465" cy="110" r="6" fill="var(--secondary-bg)" stroke="#7C3AED" stroke-width="3" style="cursor: pointer;" data-date="Oct 2026" data-val="₹5,50,000"></circle>
                                <circle cx="550" cy="40" r="6" fill="var(--secondary-bg)" stroke="#7C3AED" stroke-width="3" style="cursor: pointer;" data-date="Nov 2026" data-val="₹9,60,000"></circle>
                            </g>

                            <!-- X-Axis Labels -->
                            <g id="xAxisLabels" fill="var(--text-muted)" font-size="11" font-family="var(--font-family)">
                                <g id="weeklyLabels">
                                    <text x="40" y="242">Mon</text>
                                    <text x="123" y="242">Tue</text>
                                    <text x="206" y="242">Wed</text>
                                    <text x="289" y="242">Thu</text>
                                    <text x="372" y="242">Fri</text>
                                    <text x="455" y="242">Sat</text>
                                    <text x="535" y="242">Sun</text>
                                </g>
                                <g id="monthlyLabels" style="display: none;">
                                    <text x="40" y="242">May</text>
                                    <text x="123" y="242">Jun</text>
                                    <text x="206" y="242">Jul</text>
                                    <text x="289" y="242">Aug</text>
                                    <text x="372" y="242">Sep</text>
                                    <text x="455" y="242">Oct</text>
                                    <text x="535" y="242">Nov</text>
                                </g>
                            </g>
                        </svg>

                        <!-- Distribution Bar Chart SVG -->
                        <svg viewBox="0 0 600 250" width="100%" height="250" id="distributionSvg" style="overflow: visible; display: none;">
                            <line x1="50" y1="50" x2="550" y2="50" stroke="rgba(255,255,255,0.05)" stroke-width="1"></line>
                            <line x1="50" y1="110" x2="550" y2="110" stroke="rgba(255,255,255,0.05)" stroke-width="1"></line>
                            <line x1="50" y1="170" x2="550" y2="170" stroke="rgba(255,255,255,0.05)" stroke-width="1"></line>
                            <line x1="50" y1="220" x2="550" y2="220" stroke="rgba(255,255,255,0.1)" stroke-width="1.5"></line>

                            <text x="20" y="55" fill="var(--text-muted)" font-size="11">100%</text>
                            <text x="25" y="115" fill="var(--text-muted)" font-size="11">60%</text>
                            <text x="25" y="175" fill="var(--text-muted)" font-size="11">20%</text>
                            <text x="35" y="225" fill="var(--text-muted)" font-size="11">0%</text>

                            <rect x="150" y="80" width="60" height="140" fill="var(--accent-blue)" rx="6" style="cursor: pointer;" data-date="Category Booking" data-val="64% of Ticket Volume"></rect>
                            <rect x="350" y="136" width="60" height="84" fill="var(--accent-purple)" rx="6" style="cursor: pointer;" data-date="Layout Seating" data-val="36% of Ticket Volume"></rect>

                            <text x="130" y="242" fill="var(--text-light)" font-size="13" font-weight="600">Category Booking</text>
                            <text x="330" y="242" fill="var(--text-light)" font-size="13" font-weight="600">Layout Booking</text>
                        </svg>
                    </div>

                    <!-- Legend Cards -->
                    <div class="chart-legend-grid">
                        <div class="chart-legend-card">
                            <div class="chart-legend-info">
                                <span class="chart-legend-color" style="background: var(--accent-blue);"></span>
                                <div>
                                    <h4 style="font-size: 14px;">Total Sales (INR)</h4>
                                    <p style="font-size: 12px; color: var(--text-muted);">Sum of ticketing revenues</p>
                                </div>
                            </div>
                            <div class="chart-legend-val" id="legendPrimaryVal">₹9,94,000</div>
                        </div>
                        
                        <div class="chart-legend-card">
                            <div class="chart-legend-info">
                                <span class="chart-legend-color" style="background: #7C3AED;"></span>
                                <div>
                                    <h4 style="font-size: 14px;">Total Tickets Sold</h4>
                                    <p style="font-size: 12px; color: var(--text-muted);">Category + Layout seats</p>
                                </div>
                            </div>
                            <div class="chart-legend-val" id="legendSecondaryVal">8,340</div>
                        </div>
                        
                        <div class="chart-legend-card">
                            <div class="chart-legend-info">
                                <span class="chart-legend-color" style="background: #22C55E;"></span>
                                <div>
                                    <h4 style="font-size: 14px;">Conversion Rate</h4>
                                    <p style="font-size: 12px; color: var(--text-muted);">Average booking conversion</p>
                                </div>
                            </div>
                            <div class="chart-legend-val">12.4%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Solutions Section -->
    <section class="solutions-section" id="solutions">
        <div class="stg-container">
            <div class="section-header">
                <span>Built for Your Business</span>
                <h2>Designed for Every <span class="gradient-text">Seating Scale</span></h2>
                <p>Whether you manage general admission festivals, reserved seating theaters, or multi-space arenas, we configure layouts for you.</p>
            </div>
            
            <div class="solutions-grid">
                <!-- Sol 1 -->
                <div class="solution-card">
                    <div class="solution-icon"><i class="fa-solid fa-users-gear"></i></div>
                    <h3>For Event Organizers</h3>
                    <p>Create, sell, and manage tickets for concerts, standup comedy shows, and independent festivals.</p>
                </div>
                
                <!-- Sol 2 -->
                <div class="solution-card">
                    <div class="solution-icon"><i class="fa-solid fa-map-location-dot"></i></div>
                    <h3>For Venues</h3>
                    <p>Manage auditoriums, stadium zones, and cinemas with visual layout grids and blocked seat matrix.</p>
                </div>
                
                <!-- Sol 3 -->
                <div class="solution-card">
                    <div class="solution-icon"><i class="fa-solid fa-guitar"></i></div>
                    <h3>For Festivals</h3>
                    <p>Handle thousands of bookings simultaneously with persistent locks and quick payment checkouts.</p>
                </div>
                
                <!-- Sol 4 -->
                <div class="solution-card">
                    <div class="solution-icon"><i class="fa-solid fa-building"></i></div>
                    <h3>For Corporate Events</h3>
                    <p>Manage employee registers, VIP access badges, registration lists, and analytics reporting logs.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Slider / Carousel Section -->
    <section class="testimonial-section" style="padding: 100px 0; background-color: var(--secondary-bg); border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
        <div class="stg-container">
            <div class="section-header">
                <span>Success Stories</span>
                <h2>Endorsed by <span class="gradient-text">Top Event Promoters</span></h2>
                <p>Read how auditoriums and organizers transitioned their ticketing processes to BookMyTicket to achieve faster sales checkouts.</p>
            </div>
            
            <div class="testimonial-slider-container">
                <div class="testimonial-track">
                    <!-- Slide 1 -->
                    <div class="testimonial-slide">
                        <div style="background: var(--card-bg); border: 1px solid var(--border-color); padding: 40px; border-radius: 16px; position: relative;">
                            <i class="fa-solid fa-quote-left" style="position: absolute; top: 30px; left: 30px; font-size: 60px; color: rgba(59, 130, 246, 0.05); pointer-events: none;"></i>
                            <p style="font-size: 17px; line-height: 1.8; color: var(--text-light); margin-bottom: 25px; font-style: italic; position: relative; z-index: 1;">"Switching to BookMyTicket software was the best decision for our theater. The seating layout designer let us map our 800-seat auditorium exactly. Our patrons love selecting their seats, and check-in scans take less than 2 seconds!"</p>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--accent-blue); color: var(--text-light); display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700;">AV</div>
                                <div>
                                    <h4 style="font-size: 15px; font-weight: 600; color: var(--text-light);">Amit Verma</h4>
                                    <p style="font-size: 12px; color: var(--text-muted);">Director, Grand Palace Theatre, Delhi</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="testimonial-slide">
                        <div style="background: var(--card-bg); border: 1px solid var(--border-color); padding: 40px; border-radius: 16px; position: relative;">
                            <i class="fa-solid fa-quote-left" style="position: absolute; top: 30px; left: 30px; font-size: 60px; color: rgba(59, 130, 246, 0.05); pointer-events: none;"></i>
                            <p style="font-size: 17px; line-height: 1.8; color: var(--text-light); margin-bottom: 25px; font-style: italic; position: relative; z-index: 1;">"Our music festival processed over 15,000 category ticket sales using BookMyTicket. The platform stood stable during peak traffic, and direct payment routing to our merchant gateway saved us massive transaction commissions."</p>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--success); color: var(--text-light); display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700;">RS</div>
                                <div>
                                    <h4 style="font-size: 15px; font-weight: 600; color: var(--text-light);">Rohan Sharma</h4>
                                    <p style="font-size: 12px; color: var(--text-muted);">Founder, Beats Festival, Goa</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Controls -->
                <button id="sliderPrev"><i class="fa-solid fa-chevron-left"></i></button>
                <button id="sliderNext"><i class="fa-solid fa-chevron-right"></i></button>
                
                <!-- Dots indicators -->
                <div style="display: flex; justify-content: center; gap: 10px; margin-top: 30px;" id="sliderDots">
                    <span class="slider-dot active" data-index="0"></span>
                    <span class="slider-dot" data-index="1"></span>
                </div>
            </div>
    </section>

    <!-- FAQ Accordion Section (Homepage) -->
    <section class="faq-section" id="faq-section" style="padding-top: 80px; padding-bottom: 80px; border-bottom: 1px solid var(--border-color);">
        <div class="stg-container">
            <div class="section-header">
                <h2>Frequently asked <span class="gradient-text">question</span></h2>
                <p>Everything you need to know about setting up tickets and seat layouts with BookMyTicket.</p>
            </div>
            
            <div class="faq-accordion">
                <!-- FAQ 1 -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Is BookMyTicket free?</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, we offer a free Starter plan with zero monthly licensing fees. You only pay standard gateway transaction fees when processing ticket sales.</p>
                    </div>
                </div>
                
                <!-- FAQ 2 -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Can I sell tickets with BookMyTicket?</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Absolutely. You can configure general entry ticketing categories, manage seats, assign coupons, collect buyer details, and handle payouts directly through your merchant gateway accounts.</p>
                    </div>
                </div>
                
                <!-- FAQ 3 -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Does BookMyTicket support seat layouts?</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Yes! We feature a robust seating layout editor. You can design custom seating zones, assign individual ticket tier prices to rows, block holds for promoters, and let customers pick their exact seats from a live grid map.</p>
                    </div>
                </div>
                
                <!-- FAQ 4 -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Can I selfhost BookMyTicket?</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Yes. For enterprise venues and agencies, we provide dedicated self-hosted instances on your own cloud infrastructure, giving you full control over transaction routing and database storage.</p>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Who is BookMyTicket for?</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>BookMyTicket is built for event organizers, theaters, arenas, stadiums, festivals, and businesses looking for white-label ticket booking software that scales securely.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section (Gradient card with glowing shadow) -->
    <section class="final-cta-section" style="padding-top: 60px; padding-bottom: 80px;">
        <div class="stg-container">
            <div class="final-cta-card">
                <h2>Ready to Run Your Next Big Event?</h2>
                <p>Everything you need to sell tickets, manage attendees and grow your event. Start today with no setup fees.</p>
                <div class="final-cta-btns">
                    <a href="{{ route('software.pricing') }}" class="btn-primary">Start Free <i class="fa-solid fa-arrow-right" style="margin-left: 5px;"></i></a>
                    <a href="{{ route('software.contact') }}#contact-form-section" class="btn-secondary">Book a Demo</a>
                </div>
            </div>
        </div>
    </section>

    <!-- 5-Second Delayed Popup Lead Modal -->
    <div class="popup-modal" id="leadPopup">
        <div class="popup-container">
            <button class="popup-close" id="leadPopupClose"><i class="fa-solid fa-xmark"></i></button>
            <div class="popup-header">
                <div class="popup-icon"><i class="fa-solid fa-gift"></i></div>
                <h3>Get Sandbox Access!</h3>
                <p>Subscribe to our developers list and get instance sandbox access keys to test our layout editor.</p>
            </div>
            
            <form class="popup-form" id="popupLeadForm" method="POST" action="{{ route('software.contact.submit') }}">
                @csrf
                <input type="hidden" name="type" value="popup_newsletter">
                <div class="form-control-wrap">
                    <input type="email" name="email" class="input-field" placeholder="yourname@domain.com" required>
                </div>
                <button type="submit" class="btn-primary" style="justify-content: center;">Request Access</button>
            </form>
            <div id="popupLeadMsg" style="margin-top: 15px; text-align: center; font-size: 14px; font-weight: 500;"></div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Tab switching logic
        $('.demo-toggle-btn').click(function() {
            $('.demo-toggle-btn').removeClass('active');
            $(this).addClass('active');
            
            const target = $(this).data('target');
            if (target === 'category-booking') {
                $('#layoutBookingPanel').hide();
                $('#categoryBookingPanel').fadeIn();
            } else {
                $('#categoryBookingPanel').hide();
                $('#layoutBookingPanel').fadeIn();
            }
        });

        // 1. Coded Checkout Ticket Calculator Logic
        let quantities = { VIP: 0, General: 0, 'Early Bird': 0 };
        const prices = { VIP: 2499, General: 999, 'Early Bird': 699 };

        function updateShowcaseCheckout() {
            let subtotal = 0;
            for (let tier in quantities) {
                subtotal += quantities[tier] * prices[tier];
            }
            const tax = Math.round(subtotal * 0.18);
            const total = subtotal + tax;

            // Update UI
            $('#subtotalVal').text('₹' + subtotal.toLocaleString('en-IN'));
            $('#taxVal').text('₹' + tax.toLocaleString('en-IN'));
            $('#totalVal').text('₹' + total.toLocaleString('en-IN'));

            // Enable/disable button
            if (total > 0) {
                $('#simPaymentBtn').prop('disabled', false);
            } else {
                $('#simPaymentBtn').prop('disabled', true);
            }
        }

        $('.select-qty-plus').click(function() {
            const tierItem = $(this).closest('.checkout-tier-item');
            const name = tierItem.data('name');
            quantities[name]++;
            tierItem.find('.select-qty-val').text(quantities[name]);
            updateShowcaseCheckout();
        });

        $('.select-qty-minus').click(function() {
            const tierItem = $(this).closest('.checkout-tier-item');
            const name = tierItem.data('name');
            if (quantities[name] > 0) {
                quantities[name]--;
                tierItem.find('.select-qty-val').text(quantities[name]);
                updateShowcaseCheckout();
            }
        });

        $('#simPaymentBtn').click(function() {
            alert('Simulated Checkout Success! Processing transaction routes for ₹' + ($('#totalVal').text().replace('₹', '')) + ' INR using secure payment webhooks.');
            // Reset
            quantities = { VIP: 0, General: 0, 'Early Bird': 0 };
            $('.select-qty-val').text('0');
            updateShowcaseCheckout();
        });

        // 2. Interactive Seating Visual Selection Logic
        let selectedSeats = [];
        $('.seat-node').click(function() {
            if ($(this).hasClass('booked')) return;
            
            $(this).toggleClass('selected');
            const num = $(this).data('num');
            const price = parseInt($(this).closest('.seating-row').data('price'));
            
            if ($(this).hasClass('selected')) {
                selectedSeats.push({ num: num, price: price });
            } else {
                selectedSeats = selectedSeats.filter(s => s.num !== num);
            }

            // Update Seating Status Box
            const $statusText = $('#seatMapSelectedText');
            const $priceVal = $('#seatMapPriceVal');
            
            if (selectedSeats.length === 0) {
                $statusText.text('Tap seats to simulate selection.');
                $priceVal.text('₹0');
            } else {
                const names = selectedSeats.map(s => s.num).join(', ');
                const total = selectedSeats.reduce((sum, s) => sum + s.price, 0);
                $statusText.text(`Selected: ${names}`);
                $priceVal.text('₹' + total.toLocaleString('en-IN'));
            }
        });

        // 3. Chart Tab switcher
        $('.chart-tab-btn').click(function() {
            $('.chart-tab-btn').removeClass('active');
            $(this).addClass('active');
            
            const tab = $(this).data('tab');
            if (tab === 'revenue') {
                $('#chartFilters').css('visibility', 'visible');
                $('#distributionSvg').hide();
                $('#revenueSvg').fadeIn();
                updateRevenueChartInfo();
            } else {
                $('#chartFilters').css('visibility', 'hidden');
                $('#revenueSvg').hide();
                $('#distributionSvg').fadeIn();
                $('#legendPrimaryVal').text('₹6,36,000');
                $('#legendSecondaryVal').text('5,337');
            }
            $('#chartTooltip').removeClass('show');
        });

        // Chart Filter switcher
        $('.chart-filter-btn').click(function() {
            $('.chart-filter-btn').removeClass('active');
            $(this).addClass('active');
            
            const filter = $(this).data('filter');
            if (filter === 'week') {
                $('#monthlyPath, #monthlyNodes, #monthlyLabels').hide();
                $('#weeklyPath, #weeklyNodes, #weeklyLabels').fadeIn();
            } else {
                $('#weeklyPath, #weeklyNodes, #weeklyLabels').hide();
                $('#monthlyPath, #monthlyNodes, #monthlyLabels').fadeIn();
            }
            updateRevenueChartInfo();
            $('#chartTooltip').removeClass('show');
        });

        function updateRevenueChartInfo() {
            const isWeekly = $('.chart-filter-btn.active').data('filter') === 'week';
            if (isWeekly) {
                $('#legendPrimaryVal').text('₹9,94,000');
                $('#legendSecondaryVal').text('8,340');
            } else {
                $('#legendPrimaryVal').text('₹24,92,000');
                $('#legendSecondaryVal').text('20,933');
            }
        }

        // SVG hover tooltip logic
        $(document).on('mouseenter', '#revenueSvg circle, #distributionSvg rect', function(e) {
            const $node = $(this);
            const date = $node.data('date');
            const val = $node.data('val');
            
            $('#tooltipDate').text(date);
            $('#tooltipVal').text(val);
            
            const containerOffset = $('#chartContainer').offset();
            const nodeOffset = $node.offset();
            
            const top = nodeOffset.top - containerOffset.top;
            const left = nodeOffset.left - containerOffset.left;
            
            $('#chartTooltip')
                .css({
                    top: top + 'px',
                    left: left + 'px'
                })
                .addClass('show');
        });

        $(document).on('mouseleave', '#revenueSvg circle, #distributionSvg rect', function() {
            $('#chartTooltip').removeClass('show');
        });

        // 4. Testimonials Slider Logic
        let currentSlide = 0;
        const totalSlides = $('.testimonial-slide').length;

        function showSlide(index) {
            if (index < 0) index = totalSlides - 1;
            if (index >= totalSlides) index = 0;
            currentSlide = index;
            
            const translatePercent = -currentSlide * 100;
            $('.testimonial-track').css('transform', `translateX(${translatePercent}%)`);
            
            $('.slider-dot').removeClass('active');
            $(`.slider-dot[data-index="${currentSlide}"]`).addClass('active');
        }

        $('#sliderPrev').click(function() {
            showSlide(currentSlide - 1);
        });

        $('#sliderNext').click(function() {
            showSlide(currentSlide + 1);
        });

        $('.slider-dot').click(function() {
            const index = $(this).data('index');
            showSlide(index);
        });

        let autoSlideInterval = setInterval(function() {
            showSlide(currentSlide + 1);
        }, 6000);

        $('.testimonial-slider-container').hover(
            function() { clearInterval(autoSlideInterval); },
            function() { 
                autoSlideInterval = setInterval(function() {
                    showSlide(currentSlide + 1);
                }, 6000);
            }
        );

        // 5. 5-Second Delayed Lead Modal Popup logic
        setTimeout(function() {
            if (!sessionStorage.getItem('lead_popup_shown')) {
                $('#leadPopup').addClass('show');
            }
        }, 5000);

        function closePopup() {
            $('#leadPopup').removeClass('show');
            sessionStorage.setItem('lead_popup_shown', 'true');
        }

        $('#leadPopupClose').click(closePopup);
        
        $('#leadPopup').click(function(e) {
            if (e.target === this) {
                closePopup();
            }
        });

        // Popup Lead Form Ajax submission
        $('#popupLeadForm').submit(function(e) {
            e.preventDefault();
            const $form = $(this);
            const $msgDiv = $('#popupLeadMsg');
            const $btn = $form.find('button');
            
            $btn.prop('disabled', true).text('Verifying...');
            $msgDiv.removeClass('success error').text('');

            $.ajax({
                url: $form.attr('action'),
                method: "POST",
                data: $form.serialize(),
                success: function(response) {
                    $btn.prop('disabled', false).text('Request Access');
                    if (response.success) {
                        $msgDiv.css('color', '#10b981').text(response.message);
                        $form.trigger('reset');
                        setTimeout(function() {
                            closePopup();
                        }, 2500);
                    } else {
                        $msgDiv.css('color', '#ef4444').text('An error occurred. Please try again.');
                    }
                },
                error: function(xhr) {
                    $btn.prop('disabled', false).text('Request Access');
                    let errorMsg = 'Failed to submit. Please check your email.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMsg = Object.values(xhr.responseJSON.errors)[0][0];
                    }
                    $msgDiv.css('color', '#ef4444').text(errorMsg);
                }
            });
        });

        // FAQ accordion toggle
        $('.faq-question').click(function() {
            const $item = $(this).closest('.faq-item');
            
            if ($item.hasClass('active')) {
                $item.removeClass('active');
            } else {
                $('.faq-item').removeClass('active');
                $item.addClass('active');
            }
        });
    });
</script>
@endsection
