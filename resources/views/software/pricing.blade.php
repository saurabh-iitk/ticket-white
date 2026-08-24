@extends('software.layouts.landing')

@section('title', 'Pricing - BookMyTicket SaaS Ticketing Platform')

@section('content')

    <!-- Pricing Header -->
    <section class="stg-container" style="padding-top: 80px; padding-bottom: 20px;">
        <div class="section-header">
            <span>Simple, Transparent Pricing</span>
            <h2>Start small. Scale when you need to.</h2>
            <p>Choose the perfect licensing plan tailored to your transaction scale. All pricing shown in Indian Rupees (INR) with no hidden implementation fees.</p>
        </div>
    </section>

    <!-- Pricing Cards Grid -->
    <section style="padding-top: 10px; padding-bottom: 60px;">
        <div class="stg-container">
            <div class="pricing-grid">
                
                <!-- Starter Plan -->
                <div class="pricing-card">
                    <div class="pricing-card-header">
                        <h3>Starter</h3>
                        <p>Perfect for independent clubs and general entry festivals.</p>
                    </div>
                    <div>
                        <div class="pricing-price">
                            ₹0 <span>/ month</span>
                        </div>
                        <ul class="pricing-list">
                            <li><i class="fa-solid fa-circle-check"></i> General Admission Ticketing</li>
                            <li><i class="fa-solid fa-circle-check"></i> Standard Email Delivery</li>
                            <li><i class="fa-solid fa-circle-check"></i> 1 Active Payment Gateway</li>
                            <li><i class="fa-solid fa-circle-check"></i> Basic Visitor Analytics</li>
                            <li class="disabled"><i class="fa-solid fa-circle-xmark"></i> Interactive Seating Maps</li>
                            <li class="disabled"><i class="fa-solid fa-circle-xmark"></i> Custom Subdomain Settings</li>
                        </ul>
                    </div>
                    <button class="btn-secondary query-price-btn" data-plan="Starter Plan">Start Free</button>
                </div>
                
                <!-- Growth Plan -->
                <div class="pricing-card recommended">
                    <span class="card-badge">Most Popular</span>
                    <div class="pricing-card-header">
                        <h3>Growth</h3>
                        <p>Best for theaters, halls, and multi-venue organizers.</p>
                    </div>
                    <div>
                        <div class="pricing-price">
                            ₹4,999 <span>/ month</span>
                        </div>
                        <ul class="pricing-list">
                            <li><i class="fa-solid fa-circle-check"></i> Category & Seating Layouts</li>
                            <li><i class="fa-solid fa-circle-check"></i> Interactive Venue Seating Maps</li>
                            <li><i class="fa-solid fa-circle-check"></i> Gate mobile check-in scanners</li>
                            <li><i class="fa-solid fa-circle-check"></i> 3 Payment Gateways routing</li>
                            <li><i class="fa-solid fa-circle-check"></i> Advanced UTM & conversion metrics</li>
                            <li class="disabled"><i class="fa-solid fa-circle-xmark"></i> Dedicated Account SLA</li>
                        </ul>
                    </div>
                    <button class="btn-primary query-price-btn" data-plan="Growth Plan">Start Growth</button>
                </div>
                
                <!-- Enterprise Plan -->
                <div class="pricing-card">
                    <div class="pricing-card-header">
                        <h3>Enterprise</h3>
                        <p>For stadium organizers and white-label ticket agencies.</p>
                    </div>
                    <div>
                        <div class="pricing-price">
                            Custom <span>/ monthly</span>
                        </div>
                        <ul class="pricing-list">
                            <li><i class="fa-solid fa-circle-check"></i> Unlimited active venues & seats</li>
                            <li><i class="fa-solid fa-circle-check"></i> White-label Domain mapping</li>
                            <li><i class="fa-solid fa-circle-check"></i> Priority checkout API access</li>
                            <li><i class="fa-solid fa-circle-check"></i> Dedicated SLA Support contract</li>
                            <li><i class="fa-solid fa-circle-check"></i> Custom layout templates builder</li>
                            <li><i class="fa-solid fa-circle-check"></i> Multi-organizer role permissions</li>
                        </ul>
                    </div>
                    <button class="btn-secondary query-price-btn" data-plan="Enterprise Plan">Contact Sales</button>
                </div>
                
            </div>
        </div>
    </section>

    <!-- FAQ Accordion -->
    <section class="faq-section">
        <div class="stg-container">
            <div class="section-header">
                <span>FAQS</span>
                <h2>Frequently asked <span class="gradient-text">question</span></h2>
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
                    <i class="fa-solid fa-indian-rupee-sign"></i>
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
                    <input type="hidden" name="subject" id="queryPlanSubject" value="INR Price Inquiry">
                    
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

    <!-- Contact Form embedded -->
    <section class="stg-container" id="contact-form-section">
        <div style="max-width: 800px; margin: 0 auto; background-color: var(--card-bg); border: 1px solid var(--border-color); padding: 45px; border-radius: 16px;">
            <h2 style="text-align: center; margin-bottom: 10px;">Inquire About Custom Pricing</h2>
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

        // Query Price button click - open modal
        $('.query-price-btn').click(function() {
            const planName = $(this).data('plan');
            
            // Set dynamic modal values
            $('#queryPlanTitle').text(`Query Price: ${planName}`);
            $('#queryPlanSubject').val(`INR Price Inquiry - ${planName}`);
            
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
            const $form = $(this);
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
