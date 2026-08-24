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
                        <a href="{{ route('software.contact') }}#contact-form-section" class="btn-secondary">View Demo</a>
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
