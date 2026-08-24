@extends('software.layouts.landing')

@section('title', 'Features - BookMyTicket SaaS Ticketing Software')

@section('content')

    <!-- Page Header -->
    <section class="stg-container" style="padding-top: 60px; padding-bottom: 40px;">
        <div class="section-header">
            <span style="color: var(--accent-blue); font-weight: 700; text-transform: uppercase; font-size: 14px; letter-spacing: 2px;">Comprehensive Modules</span>
            <h2 style="margin-top: 10px;">Powerful Features Engineered for Scale</h2>
            <p>From customizable seat maps to mobile entry scanning, BookMyTicket gives you all the tools required to sell tickets and manage event venues.</p>
        </div>
    </section>

    <!-- Detailed Features Grid -->
    <section style="padding-top: 20px; padding-bottom: 60px;">
        <div class="stg-container">
            <div class="features-grid">
                
                <!-- Feature 1 -->
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-compass_drafting"></i>
                    </div>
                    <h3>Interactive Layout Engine</h3>
                    <p>Design complex venue structures with our visual layout builder. Create block sections, stage configurations, row numbers, and custom seat matrices. Organizers can block seats, mark VIP zones, or configure accessible seats in seconds.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <h3>Flexible Category Pricing</h3>
                    <p>Prefer general admission? Set up VIP boxes, front rows, general circles, or standing sections. Dynamically set early bird discounts, configure coupon code rules, and automate ticket rate rises as inventory decreases.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>
                    <h3>Multi-Gateway Integrations</h3>
                    <p>Enable direct customer-to-merchant checkouts. Comes pre-integrated with Razorpay, PayU, and other global processors. Includes automatic cron-based payment verification to recover holds and prevent double booking of seats.</p>
                </div>
                
                <!-- Feature 4 -->
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-qrcode"></i>
                    </div>
                    <h3>Mobile Scanner Check-In</h3>
                    <p>Attendees receive instant PDF and mobile-responsive tickets with secure QR codes. Staff can scan tickets using our web check-in panel or scanner app with real-time entry sync, check-in history logs, and duplicate prevention.</p>
                </div>
                
                <!-- Feature 5 -->
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3>UTM Analytics & CRM</h3>
                    <p>Identify where ticket sales originate. Built-in visitor logs capture IP addresses, browsers, and UTM variables (source, campaign, medium). Track user checkouts, store customer histories, and download detailed invoices.</p>
                </div>
                
                <!-- Feature 6 -->
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-palette"></i>
                    </div>
                    <h3>White Label Control</h3>
                    <p>Customize system settings to match your venue's identity. Set up your custom domain names, adjust color systems, personalize ticket email templates, and manage organizer/roles permissions with ease.</p>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Interactive Demonstration Highlight -->
    <section style="background-color: var(--secondary-bg); padding: 80px 0; border-top: 1px solid var(--border-dark); border-bottom: 1px solid var(--border-dark);">
        <div class="stg-container interactive-demo-grid">
            <div>
                <h2 style="font-size: 32px; font-weight: 700; margin-bottom: 20px;">Category vs. Seating Layout Booking</h2>
                <p style="color: var(--text-muted); margin-bottom: 20px;">BookMyTicket Software accommodates both business models in a single, stable installation. Whether you are running a cinema theater needing precise seat selection or a standing concert requiring broad entry passes, the platform handles it fluidly.</p>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 15px;">
                    <li style="display: flex; gap: 10px; font-size: 15px;"><i class="fa-solid fa-circle-check" style="color: var(--accent-blue); font-size: 18px; margin-top: 3px;"></i> <span><strong>Seamless Integration:</strong> Switch individual event modes between category lists and map nodes.</span></li>
                    <li style="display: flex; gap: 10px; font-size: 15px;"><i class="fa-solid fa-circle-check" style="color: var(--accent-blue); font-size: 18px; margin-top: 3px;"></i> <span><strong>Interactive UI:</strong> Beautiful responsive web views ensure attendees can select seats on tablets, mobile screens, or desktops easily.</span></li>
                    <li style="display: flex; gap: 10px; font-size: 15px;"><i class="fa-solid fa-circle-check" style="color: var(--accent-blue); font-size: 18px; margin-top: 3px;"></i> <span><strong>Cart Persistence:</strong> Session locks hold chosen seats for 10 minutes, automatically releasing them if checkouts fail.</span></li>
                </ul>
            </div>
            <div>
                <div class="hero-img-wrapper" style="box-shadow: 0 10px 40px rgba(0,0,0,0.4);">
                    <!-- A stylized visual depicting seat and layout selection -->
                    <div style="background: rgba(11, 19, 41, 0.85); padding: 40px; text-align: center; border-radius: 12px;">
                        <i class="fa-solid fa-compass-drafting" style="font-size: 50px; color: var(--accent-blue); margin-bottom: 20px;"></i>
                        <h4 style="font-size: 18px; font-weight: 600; margin-bottom: 10px;">Test the Layout Capabilities</h4>
                        <p style="font-size: 14px; color: var(--text-muted); margin-bottom: 25px;">You can experience the category selectors and layout grid in real time on our homepage simulator widget.</p>
                        <a href="{{ route('software.home') }}#demo-widget" class="btn-primary" style="font-size: 13px; padding: 10px 24px;">Test Interactive Widget</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Embedded Contact Form Section -->
    <section class="stg-container" id="contact-form-section">
        <div class="contact-section-embedded">
            <div style="max-width: 800px; margin: 0 auto;">
                <h2>Customize Your Deployments</h2>
                <p class="lead-text">Fill in the contact form below. Our product consultants will assist you in mapping your physical venue seating layouts to our database schemas.</p>
                
                @include('software.partials.contact-form')
            </div>
        </div>
    </section>

@endsection
