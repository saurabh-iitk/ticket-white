@extends('software.layouts.landing')

@section('title', 'Book My Ticket - Enterprise Event Ticketing & Venue SaaS')

@section('content')
    @include('software.partials.hero')
    @include('software.partials.trust-marquee')
    @include('software.partials.features-bento')
    @include('software.partials.checkout-showcase')
    @include('software.partials.seating-showcase')
    @include('software.partials.operations')
    @include('software.partials.analytics')
    @include('software.partials.solutions')
    @include('software.partials.testimonials')
    @include('software.partials.faq')
    @include('software.partials.final-cta')
    @include('software.partials.popup-modal')
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
