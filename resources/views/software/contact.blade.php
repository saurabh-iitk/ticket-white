@extends('software.layouts.landing')

@section('title', 'Contact Us - BookMyTicket SaaS Ticketing Software')

@section('content')

    <!-- Contact Header -->
    <section class="stg-container" style="padding-top: 60px; padding-bottom: 20px;">
        <div class="section-header">
            <span style="color: var(--accent-blue); font-weight: 700; text-transform: uppercase; font-size: 14px; letter-spacing: 2px;">Contact Us</span>
            <h2 style="margin-top: 10px;">We'd Love to Hear From You</h2>
            <p>Have questions about deployment, custom layout seating tools, or enterprise white-label solutions? Let's connect.</p>
        </div>
    </section>

    <!-- Contact Page Grid -->
    <section style="padding-top: 10px; padding-bottom: 80px;">
        <div class="stg-container">
            <div class="contact-page-grid">
                
                <!-- Info Column -->
                <div class="contact-info-panel">
                    <h3>Contact Information</h3>
                    <p style="color: var(--text-muted); font-size: 15px; margin-top: -15px;">Reach out to our teams directly or fill in the message form on the right.</p>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div class="info-text">
                            <h4>Corporate Headquarters</h4>
                            <p>Lucknow, Uttar Pradesh, India</p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div class="info-text">
                            <h4>Email Enquiries</h4>
                            <p><a href="mailto:contact@billionbyte.in">contact@billionbyte.in</a></p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div class="info-text">
                            <h4>Phone Support</h4>
                            <p><a href="tel:+918303441147">+91 8303441147</a></p>
                        </div>
                    </div>
                    
                    <!-- Stylized Map Placeholder -->
                    <div class="map-placeholder">
                        <i class="fa-solid fa-map-location-dot"></i>
                        <strong>Lucknow, Uttar Pradesh</strong>
                        <p style="margin: 0; font-size: 11px;">Sandbox Map Center: 26.8467° N, 80.9462° E</p>
                    </div>
                </div>
                
                <!-- Form Column -->
                <div class="contact-page-form-wrap">
                    <h2>Send us a Message</h2>
                    @include('software.partials.contact-form')
                </div>
                
            </div>
        </div>
    </section>

@endsection
