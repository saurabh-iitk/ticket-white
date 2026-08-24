    <!-- Analytics Section -->
    <section class="analytics-section" id="analytics-charts-section">
        <div class="stg-container">
            <div class="section-header">
                <span>Know Your Event. Grow Your Business.</span>
                <h2>Your event data, <span class="gradient-text">in real time.</span></h2>
                <p>Analyze transaction graphs, visitor log conversions, and category performances to optimize pricing and maximize revenue.</p>
            </div>

            <div class="analytics-dashboard-panel">
                <div class="chart-tabs-wrap">
                    <div class="chart-tabs">
                        <button class="chart-tab-btn active" data-tab="revenue">
                            <i class="fa-solid fa-chart-line"></i> Revenue Analytics
                        </button>
                        <button class="chart-tab-btn" data-tab="distribution">
                            <i class="fa-solid fa-chart-pie"></i> Booking Channels
                        </button>
                    </div>
                    <div class="chart-filters" id="chartFilters">
                        <button class="chart-filter-btn active" data-filter="week">Weekly</button>
                        <button class="chart-filter-btn" data-filter="month">Monthly</button>
                    </div>
                </div>

                <div class="chart-body-grid">
                    <!-- SVG Chart Container -->
                    <div class="chart-svg-container" id="chartContainer">
                        <div class="chart-tooltip-bubble" id="chartTooltip">
                            <strong id="tooltipDate">Aug 20</strong><br>
                            <span id="tooltipVal" style="color: var(--accent-blue); font-weight: 700;">₹1,24,000</span>
                        </div>

                        <!-- Revenue Line Chart SVG -->
                        <svg viewBox="0 0 600 250" width="100%" height="250" id="revenueSvg" style="overflow: visible;">
                            <!-- Grid Lines -->
                            <line x1="50" y1="50" x2="550" y2="50" stroke="rgba(255,255,255,0.05)" stroke-width="1"></line>
                            <line x1="50" y1="110" x2="550" y2="110" stroke="rgba(255,255,255,0.05)" stroke-width="1"></line>
                            <line x1="50" y1="170" x2="550" y2="170" stroke="rgba(255,255,255,0.05)" stroke-width="1"></line>
                            <line x1="50" y1="220" x2="550" y2="220" stroke="rgba(255,255,255,0.1)" stroke-width="1.5"></line>

                            <!-- Y-Axis Labels -->
                            <text x="15" y="55" fill="var(--text-muted)" font-size="11" font-family="var(--font-family)">₹2.5L</text>
                            <text x="15" y="115" fill="var(--text-muted)" font-size="11" font-family="var(--font-family)">₹1.5L</text>
                            <text x="15" y="175" fill="var(--text-muted)" font-size="11" font-family="var(--font-family)">₹50K</text>
                            <text x="35" y="225" fill="var(--text-muted)" font-size="11" font-family="var(--font-family)">0</text>

                            <!-- Line Chart Paths -->
                            <path d="M 50 190 L 133 150 L 216 110 L 299 130 L 382 70 L 465 90 L 550 50" 
                                  fill="none" stroke="var(--accent-blue)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
                                  class="animate-chart-path" id="weeklyPath" style="display: block;"></path>
                                  
                            <path d="M 50 170 L 133 180 L 216 140 L 299 90 L 382 60 L 465 110 L 550 40" 
                                  fill="none" stroke="#7C3AED" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
                                  class="animate-chart-path" id="monthlyPath" style="display: none;"></path>

                            <!-- Clickable/Hoverable Data Points -->
                            <g id="weeklyNodes">
                                <circle cx="50" cy="190" r="6" fill="var(--secondary-bg)" stroke="var(--accent-blue)" stroke-width="3" style="cursor: pointer;" data-date="Aug 17" data-val="₹35,000"></circle>
                                <circle cx="133" cy="150" r="6" fill="var(--secondary-bg)" stroke="var(--accent-blue)" stroke-width="3" style="cursor: pointer;" data-date="Aug 18" data-val="₹85,000"></circle>
                                <circle cx="216" cy="110" r="6" fill="var(--secondary-bg)" stroke="var(--accent-blue)" stroke-width="3" style="cursor: pointer;" data-date="Aug 19" data-val="₹1,50,000"></circle>
                                <circle cx="299" cy="130" r="6" fill="var(--secondary-bg)" stroke="var(--accent-blue)" stroke-width="3" style="cursor: pointer;" data-date="Aug 20" data-val="₹1,24,000"></circle>
                                <circle cx="382" cy="70" r="6" fill="var(--secondary-bg)" stroke="var(--accent-blue)" stroke-width="3" style="cursor: pointer;" data-date="Aug 21" data-val="₹2,10,000"></circle>
                                <circle cx="465" cy="90" r="6" fill="var(--secondary-bg)" stroke="var(--accent-blue)" stroke-width="3" style="cursor: pointer;" data-date="Aug 22" data-val="₹1,85,000"></circle>
                                <circle cx="550" cy="50" r="6" fill="var(--secondary-bg)" stroke="var(--accent-blue)" stroke-width="3" style="cursor: pointer;" data-date="Aug 23" data-val="₹2,45,000"></circle>
                            </g>

                            <g id="monthlyNodes" style="display: none;">
                                <circle cx="50" cy="170" r="6" fill="var(--secondary-bg)" stroke="#7C3AED" stroke-width="3" style="cursor: pointer;" data-date="May 2026" data-val="₹2,62,000"></circle>
                                <circle cx="133" cy="180" r="6" fill="var(--secondary-bg)" stroke="#7C3AED" stroke-width="3" style="cursor: pointer;" data-date="Jun 2026" data-val="₹2,50,000"></circle>
                                <circle cx="216" cy="140" r="6" fill="var(--secondary-bg)" stroke="#7C3AED" stroke-width="3" style="cursor: pointer;" data-date="Jul 2026" data-val="₹4,05,000"></circle>
                                <circle cx="299" cy="90" r="6" fill="var(--secondary-bg)" stroke="#7C3AED" stroke-width="3" style="cursor: pointer;" data-date="Aug 2026" data-val="₹6,80,000"></circle>
                                <circle cx="382" cy="60" r="6" fill="var(--secondary-bg)" stroke="#7C3AED" stroke-width="3" style="cursor: pointer;" data-date="Sep 2026" data-val="₹8,25,000"></circle>
                                <circle cx="465" cy="110" r="6" fill="var(--secondary-bg)" stroke="#7C3AED" stroke-width="3" style="cursor: pointer;" data-date="Oct 2026" data-val="₹5,50,000"></circle>
                                <circle cx="550" cy="40" r="6" fill="var(--secondary-bg)" stroke="#7C3AED" stroke-width="3" style="cursor: pointer;" data-date="Nov 2026" data-val="₹9,60,000"></circle>
                            </g>

                            <!-- X-Axis Labels -->
                            <g id="xAxisLabels" fill="var(--text-muted)" font-size="11" font-family="var(--font-family)">
                                <g id="weeklyLabels">
                                    <text x="40" y="242">Mon</text>
                                    <text x="123" y="242">Tue</text>
                                    <text x="206" y="242">Wed</text>
                                    <text x="289" y="242">Thu</text>
                                    <text x="372" y="242">Fri</text>
                                    <text x="455" y="242">Sat</text>
                                    <text x="535" y="242">Sun</text>
                                </g>
                                <g id="monthlyLabels" style="display: none;">
                                    <text x="40" y="242">May</text>
                                    <text x="123" y="242">Jun</text>
                                    <text x="206" y="242">Jul</text>
                                    <text x="289" y="242">Aug</text>
                                    <text x="372" y="242">Sep</text>
                                    <text x="455" y="242">Oct</text>
                                    <text x="535" y="242">Nov</text>
                                </g>
                            </g>
                        </svg>

                        <!-- Distribution Bar Chart SVG -->
                        <svg viewBox="0 0 600 250" width="100%" height="250" id="distributionSvg" style="overflow: visible; display: none;">
                            <line x1="50" y1="50" x2="550" y2="50" stroke="rgba(255,255,255,0.05)" stroke-width="1"></line>
                            <line x1="50" y1="110" x2="550" y2="110" stroke="rgba(255,255,255,0.05)" stroke-width="1"></line>
                            <line x1="50" y1="170" x2="550" y2="170" stroke="rgba(255,255,255,0.05)" stroke-width="1"></line>
                            <line x1="50" y1="220" x2="550" y2="220" stroke="rgba(255,255,255,0.1)" stroke-width="1.5"></line>

                            <text x="20" y="55" fill="var(--text-muted)" font-size="11">100%</text>
                            <text x="25" y="115" fill="var(--text-muted)" font-size="11">60%</text>
                            <text x="25" y="175" fill="var(--text-muted)" font-size="11">20%</text>
                            <text x="35" y="225" fill="var(--text-muted)" font-size="11">0</text>

                            <!-- Bars -->
                            <rect x="75" y="80" width="50" height="140" fill="var(--accent-blue)" rx="4" class="animate-chart-path" data-date="Direct Web sales" data-val="72% (₹17,94,240)" style="cursor: pointer;"></rect>
                            <rect x="200" y="140" width="50" height="80" fill="#10B981" rx="4" class="animate-chart-path" data-date="Organizer Widget" data-val="18% (₹4,48,560)" style="cursor: pointer;"></rect>
                            <rect x="325" y="200" width="50" height="20" fill="#F59E0B" rx="4" class="animate-chart-path" data-date="Affiliate networks" data-val="6% (₹1,49,520)" style="cursor: pointer;"></rect>
                            <rect x="450" y="210" width="50" height="10" fill="#EC4899" rx="4" class="animate-chart-path" data-date="Box Office Cash" data-val="4% (₹99,680)" style="cursor: pointer;"></rect>

                            <!-- X-Axis Labels -->
                            <g fill="var(--text-muted)" font-size="11" font-family="var(--font-family)">
                                <text x="75" y="242">Web portal</text>
                                <text x="195" y="242">Web Embeds</text>
                                <text x="325" y="242">Affiliates</text>
                                <text x="455" y="242">Offline cash</text>
                            </g>
                        </svg>
                    </div>

                    <!-- Side Stats Legends -->
                    <div class="chart-legends-side">
                        <div style="margin-bottom: 25px;">
                            <span class="legend-lbl">TOTAL SALES REVENUE</span>
                            <div class="legend-primary-val" id="legendPrimaryVal">₹9,94,000</div>
                            <p class="legend-desc">Gross transactions processed successfully.</p>
                        </div>
                        <div>
                            <span class="legend-lbl">TICKETS DISPATCHED</span>
                            <div class="legend-primary-val" id="legendSecondaryVal">8,340</div>
                            <p class="legend-desc">Total ticket issues generated with active QR codes.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
