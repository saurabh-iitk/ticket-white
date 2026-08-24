@extends('software.layouts.landing')

@section('title', 'Pricing - BookMyTicket SaaS Ticketing Platform')

@section('styles')
<style>
    /* Custom styles matching reference image */
    .pricing-grid-custom {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 40px;
        align-items: stretch;
    }
    @media (max-width: 991px) {
        .pricing-grid-custom {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
    }
    @media (max-width: 767px) {
        .pricing-grid-custom {
            grid-template-columns: 1fr;
            max-width: 450px;
            margin: 40px auto 0;
        }
    }

    .pricing-card-new {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 24px;
        position: relative;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .pricing-card-new:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.08);
    }
    .pricing-card-new.recommended-new {
        border-color: #0070f3;
        box-shadow: 0 8px 30px rgba(0, 112, 243, 0.08);
    }
    .pricing-card-new.recommended-new:hover {
        box-shadow: 0 16px 40px rgba(0, 112, 243, 0.15);
    }

    .pricing-card-header-new {
        padding: 30px 24px;
        text-align: center;
        border-bottom: 1px solid var(--border-color);
        position: relative;
    }

    .pricing-card-header-new h3 {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--text-color);
    }
    .pricing-card-header-new p {
        font-size: 13px;
        color: var(--text-muted);
        margin: 0;
    }

    .pricing-card-header-new.blue-banner {
        background: linear-gradient(135deg, #0070f3, #00a4ff);
        border-bottom: none;
        padding-top: 45px;
    }
    .pricing-card-header-new.blue-banner h3 {
        color: #ffffff !important;
        font-weight: 800;
    }
    .pricing-card-header-new.blue-banner p {
        color: rgba(255, 255, 255, 0.9) !important;
        font-weight: 500;
    }

    .pricing-card-header-new.amber-banner {
        background: linear-gradient(135deg, #92400e, #d97706);
        border-bottom: none;
        padding-top: 45px;
    }
    .pricing-card-header-new.amber-banner h3 {
        color: #ffffff !important;
        font-weight: 800;
    }
    .pricing-card-header-new.amber-banner p {
        color: rgba(255, 255, 255, 0.9) !important;
        font-weight: 500;
    }

    .pricing-card-body-new {
        padding: 35px 30px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .price-display-wrapper {
        text-align: center;
        margin-bottom: 30px;
    }
    .price-display-wrapper .price-amount {
        font-size: 64px;
        font-weight: 800;
        color: var(--text-color);
        line-height: 1;
        display: inline-flex;
        align-items: baseline;
        justify-content: center;
    }
    .price-display-wrapper .price-period {
        font-size: 16px;
        color: var(--text-muted);
        font-weight: 500;
        margin-left: 4px;
    }
    .price-display-wrapper .price-subtext {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 10px;
        display: block;
        min-height: 18px;
    }

    .features-list-new {
        list-style: none;
        padding: 0;
        margin: 0 0 35px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .features-list-new li {
        font-size: 14px;
        color: var(--text-color);
        display: flex;
        align-items: flex-start;
        line-height: 1.4;
        text-align: left;
    }
    .features-list-new li i {
        margin-right: 12px;
        margin-top: 2px;
        font-size: 16px;
        flex-shrink: 0;
    }

    .features-list-new.green-checks li i {
        color: #10b981;
    }
    .features-list-new.blue-checks li i {
        color: #3b82f6;
    }
    .features-list-new.amber-checks li i {
        color: #f59e0b;
    }

    .btn-card-new {
        width: 100%;
        padding: 14px 28px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid var(--border-color);
        background: transparent;
        color: var(--text-color);
        margin-top: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .btn-card-new:hover {
        background: var(--secondary-bg);
        border-color: var(--text-muted);
    }
    .btn-card-new.blue-btn {
        background: #0070f3;
        color: #ffffff;
        border-color: #0070f3;
    }
    .btn-card-new.blue-btn:hover {
        background: #0060d0;
        border-color: #0060d0;
    }
    .btn-card-new.amber-btn {
        background: #92400e;
        color: #ffffff;
        border-color: #92400e;
    }
    .btn-card-new.amber-btn:hover {
        background: #78350f;
        border-color: #78350f;
    }

    /* Switcher Styles */
    .billing-switcher-container {
        text-align: center;
        margin: 30px 0 50px;
    }
    .billing-switcher {
        background: var(--secondary-bg);
        border: 1px solid var(--border-color);
        display: inline-flex;
        align-items: center;
        padding: 4px;
        border-radius: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }
    .billing-switcher .toggle-btn {
        border: none;
        padding: 8px 20px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        background: transparent;
        color: var(--text-muted);
        transition: all 0.2s ease;
    }
    .billing-switcher .toggle-btn.active {
        background: #ffffff;
        color: #111111;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    body:not(.light-theme) .billing-switcher .toggle-btn.active {
        background: rgba(255,255,255,0.15);
        color: #ffffff;
    }
    .save-badge {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
        font-weight: 600;
        font-size: 12px;
        padding: 5px 12px;
        border-radius: 20px;
        margin-left: 12px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        vertical-align: middle;
    }

    /* Most Popular Badge placement */
    .most-popular-badge {
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-50%);
        background: #0070f3;
        color: #ffffff;
        font-weight: 700;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 4px 14px;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0, 112, 243, 0.3);
        z-index: 10;
    }
</style>
@endsection

@section('content')

    <!-- Pricing Header -->
    <section class="stg-container" style="padding-top: 80px; padding-bottom: 20px;">
        <div class="section-header">
            <span style="color: var(--accent-blue); font-weight: 700; text-transform: uppercase; font-size: 14px; letter-spacing: 2px;">Simple, Transparent Pricing</span>
            <h2 style="margin-top: 10px;">Start small. Scale when you need to.</h2>
            <p>Choose the perfect licensing plan tailored to your transaction scale. Billed in USD with trial access included.</p>
        </div>
        
        <!-- Monthly / Annual Toggle Switcher -->
        <div class="billing-switcher-container">
            <div class="billing-switcher">
                <button id="toggle-monthly" class="toggle-btn active">Monthly</button>
                <button id="toggle-annual" class="toggle-btn">Annual</button>
            </div>
            <span class="save-badge">
                <i class="fa-solid fa-check"></i> Save up to $58 a year
            </span>
        </div>
    </section>

    <!-- Pricing Cards Grid -->
    <section style="padding-top: 10px; padding-bottom: 60px;">
        <div class="stg-container">
            <div class="pricing-grid-custom">
                
                <!-- Card 1: Forever Free -->
                <div class="pricing-card-new">
                    <div class="pricing-card-header-new">
                        <h3>Forever Free</h3>
                        <p>Perfect for getting started</p>
                    </div>
                    
                    <div class="pricing-card-body-new">
                        <div class="price-display-wrapper">
                            <span class="price-amount"><span id="price-free">$0</span><span class="price-period" id="period-free">/month</span></span>
                            <span class="price-subtext" id="subtext-free">Perfect for getting started</span>
                        </div>
                        
                        <ul class="features-list-new green-checks">
                            <li><i class="fa-solid fa-circle-check"></i> Unlimited events and schedules</li>
                            <li><i class="fa-solid fa-circle-check"></i> Mobile-optimized, professional design</li>
                            <li><i class="fa-solid fa-circle-check"></i> Custom schedule URLs</li>
                            <li><i class="fa-solid fa-circle-check"></i> Venue location maps</li>
                            <li><i class="fa-solid fa-circle-check"></i> Google Calendar sync</li>
                            <li><i class="fa-solid fa-circle-check"></i> CalDAV sync</li>
                            <li><i class="fa-solid fa-circle-check"></i> Fan videos & comments on events</li>
                            <li><i class="fa-solid fa-circle-check"></i> Embed calendar on website</li>
                            <li><i class="fa-solid fa-circle-check"></i> Recurring events</li>
                            <li><i class="fa-solid fa-circle-check"></i> Free event registration</li>
                            <li><i class="fa-solid fa-circle-check"></i> Appointment booking (1 type)</li>
                        </ul>
                        
                        <button class="btn-card-new query-price-btn" data-plan="Forever Free Plan">Start Free</button>
                    </div>
                </div>
                
                <!-- Card 2: Pro -->
                <div class="pricing-card-new recommended-new">
                    <span class="most-popular-badge">Most Popular</span>
                    <div class="pricing-card-header-new blue-banner">
                        <h3>7-Day Free Trial</h3>
                        <p>Try all Pro features risk-free</p>
                    </div>
                    
                    <div class="pricing-card-body-new">
                        <div class="price-display-wrapper">
                            <span class="price-amount"><span id="price-pro">$9</span><span class="price-period" id="period-pro">/month</span></span>
                            <span class="price-subtext" id="subtext-pro">Billed monthly after your free trial</span>
                        </div>
                        
                        <ul class="features-list-new blue-checks">
                            <li><i class="fa-solid fa-circle-check"></i> Everything in Free</li>
                            <li><i class="fa-solid fa-circle-check"></i> Remove Event Schedule branding</li>
                            <li><i class="fa-solid fa-circle-check"></i> Unlimited ticket sales & check-in dashboard</li>
                            <li><i class="fa-solid fa-circle-check"></i> Passes, subscriptions & individual tickets</li>
                            <li><i class="fa-solid fa-circle-check"></i> Unlimited appointment types</li>
                            <li><i class="fa-solid fa-circle-check"></i> Boost events with ads</li>
                            <li><i class="fa-solid fa-circle-check"></i> Custom fields</li>
                            <li><i class="fa-solid fa-circle-check"></i> Custom CSS styling</li>
                            <li><i class="fa-solid fa-circle-check"></i> Generate event graphics</li>
                            <li><i class="fa-solid fa-circle-check"></i> REST API & webhooks</li>
                            <li><i class="fa-solid fa-circle-check"></i> Event polls</li>
                            <li><i class="fa-solid fa-circle-check"></i> Post-event feedback</li>
                        </ul>
                        
                        <button class="btn-card-new blue-btn query-price-btn" data-plan="Pro Plan (Free Trial)">Start Free Trial</button>
                    </div>
                </div>
                
                <!-- Card 3: Enterprise -->
                <div class="pricing-card-new">
                    <div class="pricing-card-header-new amber-banner">
                        <h3>7-Day Free Trial</h3>
                        <p>Try all Enterprise features risk-free</p>
                    </div>
                    
                    <div class="pricing-card-body-new">
                        <div class="price-display-wrapper">
                            <span class="price-amount"><span id="price-ent">$29</span><span class="price-period" id="period-ent">/month</span></span>
                            <span class="price-subtext" id="subtext-ent">Billed monthly after your free trial</span>
                        </div>
                        
                        <ul class="features-list-new amber-checks">
                            <li><i class="fa-solid fa-circle-check"></i> Everything in Pro</li>
                            <li><i class="fa-solid fa-circle-check"></i> Multiple team members per account</li>
                            <li><i class="fa-solid fa-circle-check"></i> Private & password-protected events</li>
                            <li><i class="fa-solid fa-circle-check"></i> WhatsApp event creation</li>
                            <li><i class="fa-solid fa-circle-check"></i> Custom domains</li>
                            <li><i class="fa-solid fa-circle-check"></i> Email scheduling</li>
                            <li><i class="fa-solid fa-circle-check"></i> Agenda scanning</li>
                            <li><i class="fa-solid fa-circle-check"></i> AI-powered content generation</li>
                            <li><i class="fa-solid fa-circle-check"></i> Availability management</li>
                            <li><i class="fa-solid fa-circle-check"></i> Priority support</li>
                            <li><i class="fa-solid fa-circle-check"></i> 1,000 newsletter emails / month</li>
                        </ul>
                        
                        <button class="btn-card-new amber-btn query-price-btn" data-plan="Enterprise Plan (Free Trial)">Start Free Trial</button>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- FAQ Accordion -->
    <section class="faq-section">
        <div class="stg-container">
            <div class="section-header">
                <span>FAQS</span>
                <h2>Frequently asked <span class="gradient-text">questions</span></h2>
                <p>Have questions about the BookMyTicket SaaS software license? Review our standard answers below.</p>
            </div>
            
            <div class="faq-accordion">
                <!-- FAQ 1 -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Can I switch between category and layout bookings?</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Yes! Every event schedule you configure inside the admin panel can be set up in category mode (e.g. general access) or layout mode (seating layout). You can even combine them in sub-venues if needed.</p>
                    </div>
                </div>
                
                <!-- FAQ 2 -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What payment gateways do you support?</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>We support multiple gateways out-of-the-box, including Razorpay and PayU. Custom API bridges can be developed on our Enterprise plan for Stripe, PayPal, or any region-specific merchant gateways.</p>
                    </div>
                </div>
                
                <!-- FAQ 3 -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>How does the customer seat hold logic work?</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>When an attendee clicks on a seat in a layout booking, our system reserves that seat in the database cart for 10 minutes. If the payment webhook does not confirm booking success within that window, the cron automatically clears the reservation, ensuring seats are never double booked.</p>
                    </div>
                </div>
                
                <!-- FAQ 4 -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Can we use our own domain name?</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, domain masking is fully supported on the Enterprise plan. Your users will only see your custom brand subdomain (e.g., tickets.yourvenue.com) during checkout.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Query Modal Popup (Dark Theme Styled) -->
    <div class="popup-modal" id="priceQueryModal">
        <div class="popup-container">
            <button class="popup-close" id="priceQueryClose"><i class="fa-solid fa-xmark"></i></button>
            <div class="popup-header">
                <div class="popup-icon">
                    <i class="fa-solid fa-ticket" style="color: var(--accent-blue);"></i>
                </div>
                <h3 id="queryPlanTitle">Query Price: Plan</h3>
                <p>Enter your details to receive an instant commercial quote or demo setup credentials.</p>
            </div>
            
            <div>
                <div class="alert-banner success"></div>
                <div class="alert-banner error"></div>

                <form class="popup-form ajax-contact-form" id="priceQueryForm" method="POST" action="{{ route('software.contact.submit') }}">
                    @csrf
                    <input type="hidden" name="type" value="contact_form">
                    <input type="hidden" name="subject" id="queryPlanSubject" value="SaaS License Price Inquiry">
                    
                    <div class="form-control-wrap">
                        <label class="form-label" for="query_name">Your Name</label>
                        <input type="text" id="query_name" name="name" class="input-field" placeholder="John Doe" required>
                    </div>
                    
                    <div class="form-control-wrap">
                        <label class="form-label" for="query_email">Email Address</label>
                        <input type="email" id="query_email" name="email" class="input-field" placeholder="john@example.com" required>
                    </div>
                    
                    <div class="form-control-wrap">
                        <label class="form-label" for="query_phone">Phone Number</label>
                        <input type="text" id="query_phone" name="phone" class="input-field" placeholder="+91 98765 43210" required>
                    </div>
                    
                    <div class="form-control-wrap">
                        <label class="form-label" for="query_message">Message / Ticket Volume</label>
                        <textarea id="query_message" name="message" class="input-field" style="min-height: 80px;" placeholder="Tell us about your estimated annual ticket sales..."></textarea>
                    </div>
                    
                    <button type="submit" class="btn-primary form-submit-btn" style="width: 100%; margin-top: 10px; justify-content: center;">
                        Submit Request
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Contact Form embedded CTA -->
    <section class="stg-container" id="contact-form-section">
        <div style="max-width: 800px; margin: 0 auto; background-color: var(--card-bg); border: 1px solid var(--border-color); padding: 45px; border-radius: 16px;">
            <h2 style="text-align: center; margin-bottom: 10px;">Inquire About Custom Deployments</h2>
            <p style="text-align: center; color: var(--text-muted); margin-bottom: 40px;">Need custom volume rates or dedicated API deployment support? Fill in details below to receive a custom quote.</p>
            
            @include('software.partials.contact-form')
        </div>
    </section>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
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

        // Switcher Logic
        $('#toggle-monthly').click(function() {
            $('.toggle-btn').removeClass('active');
            $(this).addClass('active');
            
            // Update Prices to Monthly
            $('#price-free').text('$0');
            $('#period-free').text('/month');
            $('#subtext-free').text('Perfect for getting started');
            
            $('#price-pro').text('$9');
            $('#period-pro').text('/month');
            $('#subtext-pro').text('Billed monthly after your free trial');
            
            $('#price-ent').text('$29');
            $('#period-ent').text('/month');
            $('#subtext-ent').text('Billed monthly after your free trial');
        });

        $('#toggle-annual').click(function() {
            $('.toggle-btn').removeClass('active');
            $(this).addClass('active');
            
            // Update Prices to Annual
            $('#price-free').text('$0');
            $('#period-free').text('/month');
            $('#subtext-free').text('Perfect for getting started');
            
            $('#price-pro').text('$7');
            $('#period-pro').text('/month');
            $('#subtext-pro').text('Billed annually as $84/year');
            
            $('#price-ent').text('$24.15');
            $('#period-ent').text('/month');
            $('#subtext-ent').text('Billed annually as $290/year');
        });

        // Query Price button click - open modal
        $('.query-price-btn').click(function() {
            const planName = $(this).data('plan');
            
            // Set dynamic modal values
            $('#queryPlanTitle').text(`Query Price: ${planName}`);
            $('#queryPlanSubject').val(`SaaS License Price Inquiry - ${planName}`);
            
            // Reset modal form alerts and fields
            $('#priceQueryModal .alert-banner').hide().text('');
            $('#priceQueryForm').trigger('reset');
            
            // Show modal
            $('#priceQueryModal').addClass('show');
        });

        // Close modal
        function closeQueryModal() {
            $('#priceQueryModal').removeClass('show');
        }

        $('#priceQueryClose').click(closeQueryModal);
        
        // Close modal clicking outside
        $('#priceQueryModal').click(function(e) {
            if (e.target === this) {
                closeQueryModal();
            }
        });
        
        // Listen for successful AJAX submissions inside this modal to auto-close
        $(document).on('submit', '#priceQueryForm', function() {
            const checkSuccess = setInterval(function() {
                const $banner = $('#priceQueryModal').find('.alert-banner.success');
                if ($banner.is(':visible')) {
                    clearInterval(checkSuccess);
                    setTimeout(function() {
                        closeQueryModal();
                    }, 3000);
                }
            }, 500);
            
            // Safety timeout
            setTimeout(function() {
                clearInterval(checkSuccess);
            }, 10000);
        });
    });
</script>
@endsection

