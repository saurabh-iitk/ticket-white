@extends('software.layouts.landing')

@section('title', 'Industries - BookMyTicket SaaS Ticketing Platform')

@section('content')

    <!-- Page Header -->
    <section class="stg-container" style="padding-top: 60px; padding-bottom: 40px;">
        <div class="section-header">
            <span style="color: var(--accent-blue); font-weight: 700; text-transform: uppercase; font-size: 14px; letter-spacing: 2px;">Tailored for Every Industry</span>
            <h2 style="margin-top: 10px;">Ticketing Solutions Built for Your Sector</h2>
            <p>Whether you run a multiplex cinema, a massive music festival, or a corporate arena, BookMyTicket has dedicated tools designed for your industry's unique demands.</p>
        </div>
    </section>

    <!-- Industry Cards Grid -->
    <section style="padding-top: 20px; padding-bottom: 60px;">
        <div class="stg-container">
            <div class="features-grid">
                
                <!-- Cinema & Movie Theaters -->
                <div class="feature-card">
                    <div class="feature-icon" style="background: rgba(0, 112, 243, 0.1); color: #0070f3;">
                        <i class="fa-solid fa-film"></i>
                    </div>
                    <h3>Cinema & Movie Theaters</h3>
                    <p>Configure row-wise screen layouts, manage complex seat matrices, block seats for reservations, and handle multiple daily showtimes dynamically. Offer seamless concession add-ons during ticket checkouts.</p>
                </div>
                
                <!-- Live Concerts & Music Festivals -->
                <div class="feature-card">
                    <div class="feature-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                        <i class="fa-solid fa-music"></i>
                    </div>
                    <h3>Concerts & Festivals</h3>
                    <p>Handle massive general admission crowds, VIP zones, and multi-day ticket access with rapid mobile scanning and high-concurrency checkout queues that handle traffic spikes without crashing.</p>
                </div>
                
                <!-- Sports Stadiums & Arenas -->
                <div class="feature-card">
                    <div class="feature-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                    <h3>Stadiums & Arenas</h3>
                    <p>Manage complex tiered seating sections, season passes, membership gates, and handle ticketing operations across large geographic layouts. Perfect for sports teams and event venues.</p>
                </div>
                
                <!-- Corporate Events & Conferences -->
                <div class="feature-card">
                    <div class="feature-icon" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <h3>Corporate Conferences</h3>
                    <p>Streamline check-ins, capture UTM tags, generate automatic GST-compliant invoices, track company registration details, and manage roles for organizational event coordinators.</p>
                </div>
                
                <!-- Comedy Clubs & Performing Arts -->
                <div class="feature-card">
                    <div class="feature-icon" style="background: rgba(236, 72, 153, 0.1); color: #ec4899;">
                        <i class="fa-solid fa-masks-theater"></i>
                    </div>
                    <h3>Comedy & Performing Arts</h3>
                    <p>Perfect for intimate table seating plans. Host daily stand-ups, manage guest lists, run early-bird pricing rules, and offer flexible promo coupons directly from a unified dashboard.</p>
                </div>
                
                <!-- Amusement Parks & Attractions -->
                <div class="feature-card">
                    <div class="feature-icon" style="background: rgba(20, 184, 166, 0.1); color: #14b8a6;">
                        <i class="fa-solid fa-ticket-simple"></i>
                    </div>
                    <h3>Parks & Attractions</h3>
                    <p>Sell timed-entry passes, manage daily visitor caps, implement QR code wristbands, and control multi-attraction access points with robust security. Improve customer flow and track check-ins.</p>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Industry Highlight Section -->
    <section style="background-color: var(--secondary-bg); padding: 80px 0; border-top: 1px solid var(--border-dark); border-bottom: 1px solid var(--border-dark);">
        <div class="stg-container interactive-demo-grid">
            <div>
                <h2 style="font-size: 32px; font-weight: 700; margin-bottom: 20px;">Why Industry Leaders Choose BookMyTicket</h2>
                <p style="color: var(--text-muted); margin-bottom: 20px;">We understand that each sector has distinct operational workflows. Our ticketing platform provides deep customization capabilities, allowing businesses to control branding, data routing, and checkout systems.</p>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 15px;">
                    <li style="display: flex; gap: 10px; font-size: 15px;"><i class="fa-solid fa-circle-check" style="color: var(--accent-blue); font-size: 18px; margin-top: 3px;"></i> <span><strong>White Label Branding:</strong> Maintain your company's identity with custom domains, styled email tickets, and personalized portals.</span></li>
                    <li style="display: flex; gap: 10px; font-size: 15px;"><i class="fa-solid fa-circle-check" style="color: var(--accent-blue); font-size: 18px; margin-top: 3px;"></i> <span><strong>Real-time Security & Logs:</strong> Prevent ticket fraud with unique encrypted QR codes and live scan logs for gate entry systems.</span></li>
                    <li style="display: flex; gap: 10px; font-size: 15px;"><i class="fa-solid fa-circle-check" style="color: var(--accent-blue); font-size: 18px; margin-top: 3px;"></i> <span><strong>High-Performance Infrastructure:</strong> Handle thousands of requests per second during peak ticket releases without downtime.</span></li>
                </ul>
            </div>
            <div>
                <div class="hero-img-wrapper" style="box-shadow: 0 10px 40px rgba(0,0,0,0.4);">
                    <div style="background: rgba(11, 19, 41, 0.85); padding: 40px; text-align: center; border-radius: 12px;">
                        <i class="fa-solid fa-industry" style="font-size: 50px; color: var(--accent-blue); margin-bottom: 20px;"></i>
                        <h4 style="font-size: 18px; font-weight: 600; margin-bottom: 10px;">Explore Tailored Setup</h4>
                        <p style="font-size: 14px; color: var(--text-muted); margin-bottom: 25px;">Connect with our industry solutions engineering group to design custom databases and dashboards for your venues.</p>
                        <a href="#contact-form-section" class="btn-primary" style="font-size: 13px; padding: 10px 24px;">Get Industry Consultation</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Embedded Contact Form CTA -->
    <section class="stg-container" id="contact-form-section">
        <div class="contact-section-embedded">
            <div style="max-width: 800px; margin: 0 auto;">
                <h2>Scale Your Industry Operations</h2>
                <p class="lead-text">Fill in the contact form below. Our product consultants will assist you in mapping your physical venue seating layouts to our database schemas.</p>
                
                @include('software.partials.contact-form')
            </div>
        </div>
    </section>

@endsection
