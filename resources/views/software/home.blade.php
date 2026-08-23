@extends('software.layouts.landing')

@section('title', 'BookMyTicket - Next-Gen Event Ticketing & Layout Software')

@section('content')

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="stg-container">
            <div class="hero-grid">
                <div class="hero-content">
                    <h1>The Ultimate Event Ticketing <span class="gradient-text">SaaS Platform</span></h1>
                    <p>Empower your venues with a customizable ticketing system. Support simple category selection or dynamic seat layouts. Maximize sales with advanced box office features.</p>
                    <div class="hero-btns">
                        <a href="#demo-widget" class="btn-primary">Try Live Demo</a>
                        <a href="{{ route('software.features') }}" class="btn-secondary">Explore Features</a>
                    </div>
                </div>
                
                <div class="hero-visual">
                    <div class="hero-img-wrapper">
                        <img src="{{ asset('assets/image/software-mockup.png') }}" alt="BookMyTicket Software Dashboard Mockup">
                    </div>
                    
                    <!-- Floating badge 1 -->
                    <div class="floating-badge badge-1">
                        <div class="icon-wrap">
                            <i class="fa-solid fa-chair"></i>
                        </div>
                        <div>
                            <h4>Layout Designer</h4>
                            <p>Visual mapping tool active</p>
                        </div>
                    </div>
                    
                    <!-- Floating badge 2 -->
                    <div class="floating-badge badge-2">
                        <div class="icon-wrap">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <h4>SaaS Enabled</h4>
                            <p>Multi-gateway support</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stg-container">
            <div class="stats-grid">
                <div class="stat-item">
                    <h3>5M+</h3>
                    <p>Tickets Processed</p>
                </div>
                <div class="stat-item">
                    <h3>100%</h3>
                    <p>White Label Control</p>
                </div>
                <div class="stat-item">
                    <h3>500+</h3>
                    <p>Venues & Organizers</p>
                </div>
                <div class="stat-item">
                    <h3>99.99%</h3>
                    <p>API Platform Uptime</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Booking Feature Showcase (Interactive Widget) -->
    <section class="demo-section" id="demo-widget">
        <div class="stg-container">
            <div class="section-header">
                <h2>Interactive Booking Demo</h2>
                <p>Discover how BookMyTicket allows attendees to buy tickets using simple Categories or choose their preferred Seats using our custom interactive seating maps.</p>
            </div>
            
            <div class="demo-widget-wrapper">
                <!-- Tab Toggles -->
                <div class="demo-toggle-buttons">
                    <button class="demo-toggle-btn active" data-target="category-booking">
                        <i class="fa-solid fa-layer-group"></i> Category-Wise Booking
                    </button>
                    <button class="demo-toggle-btn" data-target="layout-booking">
                        <i class="fa-solid fa-chair"></i> Layout-Wise Booking
                    </button>
                </div>
                
                <div class="demo-content-grid">
                    <!-- Dynamic Booking Panel -->
                    <div class="demo-view-panel">
                        
                        <!-- Category Booking Sub-Panel -->
                        <div id="categoryBookingPanel" class="demo-sub-panel">
                            <h3 style="margin-bottom: 20px; font-size: 20px;"><i class="fa-solid fa-circle-info"></i> Category Booking Simulator</h3>
                            <div class="category-demo-list">
                                <!-- Card 1 -->
                                <div class="category-demo-card" data-id="vip" data-name="VIP Box" data-price="150">
                                    <div class="header-block">
                                        <div>
                                            <span class="category-tag">VIP</span>
                                            <h4 style="margin-top: 8px;">VIP Box</h4>
                                        </div>
                                        <div class="category-price">$150</div>
                                    </div>
                                    <p style="font-size: 13px; color: var(--text-muted);">Front row seating, complimentary lounge access and free drinks.</p>
                                    <div class="category-qty-selector">
                                        <button class="qty-btn qty-minus">-</button>
                                        <span class="qty-val">0</span>
                                        <button class="qty-btn qty-plus">+</button>
                                    </div>
                                </div>
                                
                                <!-- Card 2 -->
                                <div class="category-demo-card" data-id="premium" data-name="Premium Circle" data-price="80">
                                    <div class="header-block">
                                        <div>
                                            <span class="category-tag" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">Premium</span>
                                            <h4 style="margin-top: 8px;">Premium Circle</h4>
                                        </div>
                                        <div class="category-price">$80</div>
                                    </div>
                                    <p style="font-size: 13px; color: var(--text-muted);">Great elevated viewing angles, cushioned seats, fast-track entry.</p>
                                    <div class="category-qty-selector">
                                        <button class="qty-btn qty-minus">-</button>
                                        <span class="qty-val">0</span>
                                        <button class="qty-btn qty-plus">+</button>
                                    </div>
                                </div>
                                
                                <!-- Card 3 -->
                                <div class="category-demo-card" data-id="general" data-name="General Admission" data-price="35">
                                    <div class="header-block">
                                        <div>
                                            <span class="category-tag" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b;">Standard</span>
                                            <h4 style="margin-top: 8px;">General Admission</h4>
                                        </div>
                                        <div class="category-price">$35</div>
                                    </div>
                                    <p style="font-size: 13px; color: var(--text-muted);">Standing arena, close contact with the performance, general entry.</p>
                                    <div class="category-qty-selector">
                                        <button class="qty-btn qty-minus">-</button>
                                        <span class="qty-val">0</span>
                                        <button class="qty-btn qty-plus">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Layout Booking Sub-Panel -->
                        <div id="layoutBookingPanel" class="demo-sub-panel" style="display: none;">
                            <div class="layout-demo-stage">STAGE</div>
                            
                            <div class="layout-seats-grid">
                                <!-- Row A -->
                                <div class="layout-row" data-row="A" data-price="120">
                                    <span class="row-label">A</span>
                                    <div class="seat-node" data-seat="A-1"></div>
                                    <div class="seat-node" data-seat="A-2"></div>
                                    <div class="seat-node booked" data-seat="A-3"></div>
                                    <div class="seat-node" data-seat="A-4"></div>
                                    <div class="seat-node" data-seat="A-5"></div>
                                    <div class="seat-node" data-seat="A-6"></div>
                                    <div class="seat-node booked" data-seat="A-7"></div>
                                    <div class="seat-node" data-seat="A-8"></div>
                                </div>
                                
                                <!-- Row B -->
                                <div class="layout-row" data-row="B" data-price="90">
                                    <span class="row-label">B</span>
                                    <div class="seat-node" data-seat="B-1"></div>
                                    <div class="seat-node booked" data-seat="B-2"></div>
                                    <div class="seat-node" data-seat="B-3"></div>
                                    <div class="seat-node" data-seat="B-4"></div>
                                    <div class="seat-node" data-seat="B-5"></div>
                                    <div class="seat-node" data-seat="B-6"></div>
                                    <div class="seat-node" data-seat="B-7"></div>
                                    <div class="seat-node" data-seat="B-8"></div>
                                </div>
                                
                                <!-- Row C -->
                                <div class="layout-row" data-row="C" data-price="70">
                                    <span class="row-label">C</span>
                                    <div class="seat-node" data-seat="C-1"></div>
                                    <div class="seat-node" data-seat="C-2"></div>
                                    <div class="seat-node" data-seat="C-3"></div>
                                    <div class="seat-node booked" data-seat="C-4"></div>
                                    <div class="seat-node booked" data-seat="C-5"></div>
                                    <div class="seat-node" data-seat="C-6"></div>
                                    <div class="seat-node" data-seat="C-7"></div>
                                    <div class="seat-node" data-seat="C-8"></div>
                                </div>
                                
                                <!-- Row D -->
                                <div class="layout-row" data-row="D" data-price="50">
                                    <span class="row-label">D</span>
                                    <div class="seat-node" data-seat="D-1"></div>
                                    <div class="seat-node" data-seat="D-2"></div>
                                    <div class="seat-node" data-seat="D-3"></div>
                                    <div class="seat-node" data-seat="D-4"></div>
                                    <div class="seat-node" data-seat="D-5"></div>
                                    <div class="seat-node" data-seat="D-6"></div>
                                    <div class="seat-node" data-seat="D-7"></div>
                                    <div class="seat-node booked" data-seat="D-8"></div>
                                </div>
                            </div>
                            
                            <div class="layout-legend">
                                <div class="legend-item"><span class="legend-dot available"></span> Available</div>
                                <div class="legend-item"><span class="legend-dot selected"></span> Selected</div>
                                <div class="legend-item"><span class="legend-dot booked"></span> Booked</div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <!-- Cart Summary Panel -->
                    <div class="demo-sidebar-panel">
                        <div>
                            <h3><i class="fa-solid fa-cart-shopping"></i> Selected Tickets</h3>
                            <div class="cart-items-list" id="demoCartList">
                                <div class="empty-cart-text">No tickets selected yet. Tap items on the left to start booking simulation.</div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="cart-total-block">
                                <span>Total Price:</span>
                                <h4 id="demoCartTotal">$0</h4>
                            </div>
                            <button class="btn-primary checkout-btn" id="demoCheckoutBtn" disabled>
                                Simulate Booking
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to action featuring Contact Form -->
    <section class="stg-container" id="contact-form-section">
        <div class="contact-section-embedded">
            <div style="max-width: 800px; margin: 0 auto;">
                <h2>Request a Live Sandbox Demo</h2>
                <p class="lead-text">Fill in details below. Our technical experts will schedule an interactive walkthrough and share customized deployment proposals for your ticketing operations.</p>
                
                @include('software.partials.contact-form')
            </div>
        </div>
    </section>

    <!-- 5-Second Delayed Popup Lead Modal -->
    <div class="popup-modal" id="leadPopup">
        <div class="popup-container">
            <button class="popup-close" id="leadPopupClose"><i class="fa-solid fa-xmark"></i></button>
            <div class="popup-header">
                <div class="popup-icon">
                    <i class="fa-solid fa-gift"></i>
                </div>
                <h3>Get Sandbox Access!</h3>
                <p>Subscribe to our developers list and get instance sandbox access keys to test our layout editor.</p>
            </div>
            
            <form class="popup-form" id="popupLeadForm" method="POST" action="{{ route('software.contact.submit') }}">
                @csrf
                <input type="hidden" name="type" value="popup_newsletter">
                <div class="form-control-wrap">
                    <input type="email" name="email" class="input-field" placeholder="yourname@domain.com" required>
                </div>
                <button type="submit" class="btn-primary">Request Access</button>
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
            
            // Reset simulation cart on tab switch
            resetCart();
        });

        // Cart items data structure
        let cartItems = [];

        function updateCartUI() {
            const $cartList = $('#demoCartList');
            const $totalVal = $('#demoCartTotal');
            const $checkoutBtn = $('#demoCheckoutBtn');
            
            $cartList.empty();
            
            if (cartItems.length === 0) {
                $cartList.append('<div class="empty-cart-text">No tickets selected yet. Tap items on the left to start booking simulation.</div>');
                $totalVal.text('$0');
                $checkoutBtn.prop('disabled', true);
                return;
            }
            
            let total = 0;
            cartItems.forEach(item => {
                const subtotal = item.qty * item.price;
                total += subtotal;
                
                let detailsHtml = item.type === 'category' 
                    ? `Qty: ${item.qty}` 
                    : `Seat coordinate`;
                
                $cartList.append(`
                    <div class="cart-item-row">
                        <div class="cart-item-info">
                            <strong>${item.name}</strong>
                            <span>${detailsHtml}</span>
                        </div>
                        <div style="font-weight: 600;">$${subtotal}</div>
                    </div>
                `);
            });
            
            $totalVal.text('$' + total);
            $checkoutBtn.prop('disabled', false);
        }

        function resetCart() {
            cartItems = [];
            // Reset category inputs UI
            $('.qty-val').text('0');
            // Reset seat layout map selections
            $('.seat-node.selected').removeClass('selected');
            updateCartUI();
        }

        // Category quantity selection
        $('.qty-plus').click(function() {
            const $card = $(this).closest('.category-demo-card');
            const id = $card.data('id');
            const name = $card.data('name');
            const price = parseFloat($card.data('price'));
            const $qtyVal = $card.find('.qty-val');
            
            let currentQty = parseInt($qtyVal.text());
            currentQty++;
            $qtyVal.text(currentQty);
            
            let item = cartItems.find(i => i.id === id);
            if (item) {
                item.qty = currentQty;
            } else {
                cartItems.push({
                    id: id,
                    name: name,
                    price: price,
                    qty: currentQty,
                    type: 'category'
                });
            }
            updateCartUI();
        });

        $('.qty-minus').click(function() {
            const $card = $(this).closest('.category-demo-card');
            const id = $card.data('id');
            const $qtyVal = $card.find('.qty-val');
            
            let currentQty = parseInt($qtyVal.text());
            if (currentQty <= 0) return;
            
            currentQty--;
            $qtyVal.text(currentQty);
            
            let itemIdx = cartItems.findIndex(i => i.id === id);
            if (itemIdx !== -1) {
                if (currentQty === 0) {
                    cartItems.splice(itemIdx, 1);
                } else {
                    cartItems[itemIdx].qty = currentQty;
                }
            }
            updateCartUI();
        });

        // Layout seat selection
        $('.seat-node').click(function() {
            if ($(this).hasClass('booked')) return;
            
            $(this).toggleClass('selected');
            const seatId = $(this).data('seat');
            const price = parseFloat($(this).closest('.layout-row').data('price'));
            
            if ($(this).hasClass('selected')) {
                cartItems.push({
                    id: seatId,
                    name: `Seat ${seatId}`,
                    price: price,
                    qty: 1,
                    type: 'layout'
                });
            } else {
                cartItems = cartItems.filter(i => i.id !== seatId);
            }
            updateCartUI();
        });

        // Booking Checkout trigger
        $('#demoCheckoutBtn').click(function() {
            alert('Simulation Successful! Your event ticketing demo flow is complete. In production, this integration triggers secure payment checkouts and issues instant QR tickets.');
            resetCart();
        });

        // 5-Second Delayed Lead Modal Popup logic
        setTimeout(function() {
            // Check session storage so we do not bother the same visitor during the session
            if (!sessionStorage.getItem('lead_popup_shown')) {
                $('#leadPopup').addClass('show');
            }
        }, 5000);

        // Close modal
        function closePopup() {
            $('#leadPopup').removeClass('show');
            sessionStorage.setItem('lead_popup_shown', 'true');
        }

        $('#leadPopupClose').click(closePopup);
        
        // Close modal clicking outside container
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
    });
</script>
@endsection
