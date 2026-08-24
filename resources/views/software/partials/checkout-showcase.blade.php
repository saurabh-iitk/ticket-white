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
