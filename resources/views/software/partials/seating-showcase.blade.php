    <!-- Seating Layout Mapping Showcase Section -->
    <section class="seating-section" id="seating-section">
        <div class="stg-container">
            <div class="seating-grid">
                
                <!-- Left Seating Grid simulation -->
                <div class="seating-panel-visual">
                    <div class="seating-stage">STAGE</div>
                    <div class="seating-matrix">
                        <!-- Row A -->
                        <div class="seating-row" data-row="A" data-price="2499">
                            <span class="seat-lbl">A</span>
                            <div class="seat-node vip" data-num="A-1"></div>
                            <div class="seat-node vip" data-num="A-2"></div>
                            <div class="seat-node vip booked" data-num="A-3"></div>
                            <div class="seat-node vip" data-num="A-4"></div>
                            <div class="seat-node vip" data-num="A-5"></div>
                            <div class="seat-node vip" data-num="A-6"></div>
                            <div class="seat-node vip booked" data-num="A-7"></div>
                            <div class="seat-node vip" data-num="A-8"></div>
                        </div>
                        <!-- Row B -->
                        <div class="seating-row" data-row="B" data-price="1499">
                            <span class="seat-lbl">B</span>
                            <div class="seat-node premium" data-num="B-1"></div>
                            <div class="seat-node premium booked" data-num="B-2"></div>
                            <div class="seat-node premium" data-num="B-3"></div>
                            <div class="seat-node premium" data-num="B-4"></div>
                            <div class="seat-node premium" data-num="B-5"></div>
                            <div class="seat-node premium" data-num="B-6"></div>
                            <div class="seat-node premium" data-num="B-7"></div>
                            <div class="seat-node premium" data-num="B-8"></div>
                        </div>
                        <!-- Row C -->
                        <div class="seating-row" data-row="C" data-price="1499">
                            <span class="seat-lbl">C</span>
                            <div class="seat-node premium" data-num="C-1"></div>
                            <div class="seat-node premium" data-num="C-2"></div>
                            <div class="seat-node premium" data-num="C-3"></div>
                            <div class="seat-node premium booked" data-num="C-4"></div>
                            <div class="seat-node premium booked" data-num="C-5"></div>
                            <div class="seat-node premium" data-num="C-6"></div>
                            <div class="seat-node premium" data-num="C-7"></div>
                            <div class="seat-node premium" data-num="C-8"></div>
                        </div>
                        <!-- Row D -->
                        <div class="seating-row" data-row="D" data-price="999">
                            <span class="seat-lbl">D</span>
                            <div class="seat-node standard" data-num="D-1"></div>
                            <div class="seat-node standard" data-num="D-2"></div>
                            <div class="seat-node standard" data-num="D-3"></div>
                            <div class="seat-node standard" data-num="D-4"></div>
                            <div class="seat-node standard" data-num="D-5"></div>
                            <div class="seat-node standard" data-num="D-6"></div>
                            <div class="seat-node standard" data-num="D-7"></div>
                            <div class="seat-node standard booked" data-num="D-8"></div>
                        </div>
                    </div>
                    
                    <div class="seating-legend">
                        <div class="legend-dot-item"><span class="legend-box" style="background-color: var(--accent-blue);"></span> VIP (₹2,499)</div>
                        <div class="legend-dot-item"><span class="legend-box" style="background-color: var(--warning);"></span> Standard (₹999)</div>
                        <div class="legend-dot-item"><span class="legend-box" style="background-color: #1e293b; opacity: 0.3;"></span> Booked</div>
                    </div>
                </div>
                
                <!-- Right Details -->
                <div class="showcase-content">
                    <span style="color: var(--accent-blue); font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: 1px; display: block; margin-bottom: 10px;">Designed for every venue</span>
                    <h3>Turn Your Venue Into An Interactive Experience</h3>
                    <p>Build custom seating plans, define block matrices, and let attendees select their preferred seats. Increase tickets conversions with dynamic holds.</p>
                    <ul class="showcase-checklist">
                        <li><i class="fa-solid fa-check"></i> Interactive visual seat mapping</li>
                        <li><i class="fa-solid fa-check"></i> Live real-time availability updates</li>
                        <li><i class="fa-solid fa-check"></i> Custom layout locks and blocked holds</li>
                        <li><i class="fa-solid fa-check"></i> Flexible price rules based on rows</li>
                    </ul>
                    <div style="background-color: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); padding: 15px 20px; border-radius: 12px; margin-top: 25px; display: flex; justify-content: space-between; align-items: center;" id="seatMapStatusBox">
                        <span style="font-size: 13px; color: var(--text-muted);" id="seatMapSelectedText">Tap seats to simulate selection.</span>
                        <strong style="color: var(--success); font-size: 15px;" id="seatMapPriceVal">₹0</strong>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
