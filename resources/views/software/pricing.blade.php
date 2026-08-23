@extends('software.layouts.landing')

@section('title', 'Pricing - BookMyTicket SaaS Ticketing Software')

@section('content')

    <!-- Pricing Header -->
    <section class="stg-container" style="padding-top: 60px; padding-bottom: 20px;">
        <div class="section-header">
            <span style="color: var(--accent-blue); font-weight: 700; text-transform: uppercase; font-size: 14px; letter-spacing: 2px;">Flexible Plans</span>
            <h2 style="margin-top: 10px;">Select the Best Plan for Your Venue</h2>
            <p>Transparent plans designed to support rising organizers and large-scale stadium check-ins. No hidden transaction fees.</p>
        </div>
        
        <!-- Toggle Switch -->
        <div class="pricing-toggle-wrap">
            <span class="pricing-toggle-label active" id="labelMonthly">Monthly Billing</span>
            <label class="switch">
                <input type="checkbox" id="pricingToggle">
                <span class="slider"></span>
            </label>
            <span class="pricing-toggle-label" id="labelYearly">Annual Billing <span class="save-badge">Save 20%</span></span>
        </div>
    </section>

    <!-- Pricing Cards Grid -->
    <section style="padding-top: 10px; padding-bottom: 60px;">
        <div class="stg-container">
            <div class="pricing-grid">
                
                <!-- Plan 1 -->
                <div class="pricing-card">
                    <div class="pricing-card-header">
                        <h3>Starter</h3>
                        <p>Perfect for independent clubs and general entry festivals.</p>
                    </div>
                    <div>
                        <div class="pricing-price">
                            <span class="price-symbol">$</span>
                            <span class="price-val" data-monthly="49" data-yearly="39">49</span>
                            <span class="price-period">/mo</span>
                        </div>
                        <ul class="pricing-list">
                            <li><i class="fa-solid fa-circle-check"></i> Category-Wise Booking Only</li>
                            <li><i class="fa-solid fa-circle-check"></i> Standard Email Tickets</li>
                            <li><i class="fa-solid fa-circle-check"></i> 1 Main Payment Gateway</li>
                            <li><i class="fa-solid fa-circle-check"></i> Basic Visitor Logs</li>
                            <li class="disabled"><i class="fa-solid fa-circle-xmark"></i> Interactive Seating Maps</li>
                            <li class="disabled"><i class="fa-solid fa-circle-xmark"></i> Custom Branding Settings</li>
                        </ul>
                    </div>
                    <a href="#contact-form-section" class="btn-secondary">Start Starter Trial</a>
                </div>
                
                <!-- Plan 2 -->
                <div class="pricing-card recommended">
                    <span class="card-badge">Popular</span>
                    <div class="pricing-card-header">
                        <h3>Growth</h3>
                        <p>Best for theaters, halls, and multi-venue organizers.</p>
                    </div>
                    <div>
                        <div class="pricing-price">
                            <span class="price-symbol">$</span>
                            <span class="price-val" data-monthly="99" data-yearly="79">99</span>
                            <span class="price-period">/mo</span>
                        </div>
                        <ul class="pricing-list">
                            <li><i class="fa-solid fa-circle-check"></i> Category & Layout-Wise Bookings</li>
                            <li><i class="fa-solid fa-circle-check"></i> Interactive Seat Mapping tool</li>
                            <li><i class="fa-solid fa-circle-check"></i> Mobile scanner web check-in</li>
                            <li><i class="fa-solid fa-circle-check"></i> Multi-gateway accounts</li>
                            <li><i class="fa-solid fa-circle-check"></i> Custom CSS theme controls</li>
                            <li class="disabled"><i class="fa-solid fa-circle-xmark"></i> Custom Domain URL</li>
                        </ul>
                    </div>
                    <a href="#contact-form-section" class="btn-primary">Start Growth Trial</a>
                </div>
                
                <!-- Plan 3 -->
                <div class="pricing-card">
                    <div class="pricing-card-header">
                        <h3>Enterprise</h3>
                        <p>For stadium organizers and white-label ticket agencies.</p>
                    </div>
                    <div>
                        <div class="pricing-price">
                            <span class="price-symbol">$</span>
                            <span class="price-val" data-monthly="249" data-yearly="199">249</span>
                            <span class="price-period">/mo</span>
                        </div>
                        <ul class="pricing-list">
                            <li><i class="fa-solid fa-circle-check"></i> Unlimited active venues & seats</li>
                            <li><i class="fa-solid fa-circle-check"></i> Full White-label Domain mapping</li>
                            <li><i class="fa-solid fa-circle-check"></i> Priority API integrations</li>
                            <li><i class="fa-solid fa-circle-check"></i> Dedicated SLA Support contract</li>
                            <li><i class="fa-solid fa-circle-check"></i> Staff role permission matrix</li>
                            <li><i class="fa-solid fa-circle-check"></i> Custom PDF design templates</li>
                        </ul>
                    </div>
                    <a href="#contact-form-section" class="btn-secondary">Get Enterprise Demo</a>
                </div>
                
            </div>
        </div>
    </section>

    <!-- FAQ Accordion -->
    <section class="faq-section">
        <div class="stg-container">
            <div class="section-header">
                <h2>Frequently Asked Questions</h2>
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
                        <span>How does the 5-second customer hold logic work?</span>
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

    <!-- Contact Form embedded -->
    <section class="stg-container" id="contact-form-section">
        <div class="contact-section-embedded">
            <div style="max-width: 800px; margin: 0 auto;">
                <h2>Inquire About Custom Pricing</h2>
                <p class="lead-text">Need custom volume rates or dedicated API deployment support? Fill in details below to receive a custom quote.</p>
                
                @include('software.partials.contact-form')
            </div>
        </div>
    </section>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Monthly/Yearly toggle
        $('#pricingToggle').change(function() {
            const isYearly = $(this).is(':checked');
            
            if (isYearly) {
                $('#labelMonthly').removeClass('active');
                $('#labelYearly').addClass('active');
            } else {
                $('#labelYearly').removeClass('active');
                $('#labelMonthly').addClass('active');
            }
            
            $('.price-val').each(function() {
                const monthly = $(this).data('monthly');
                const yearly = $(this).data('yearly');
                
                $(this).fadeOut(150, function() {
                    $(this).text(isYearly ? yearly : monthly).fadeIn(150);
                });
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
