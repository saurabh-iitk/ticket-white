    <!-- Feature Bento Grid Section -->
    <section class="features-section" id="features-grid">
        <div class="stg-container">
            <div class="section-header">
                <span>Everything You Need to Run Better Events</span>
                <h2>Everything You Need<br><span class="gradient-text">To Run Better Events</span></h2>
                <p>From ticket sales to check-in, payments and analytics — manage your entire event from one powerful platform.</p>
            </div>
            
            <div class="bento-grid-wrapper">
                <!-- Card 1: Ticketing & QR Check-ins -->
                <div class="bento-card bento-card-1">
                    <div class="bento-card-header-row">
                        <div class="bento-card-icon bento-accent-blue"><i class="fa-solid fa-ticket"></i></div>
                        <h3>Ticketing & QR Check-ins</h3>
                    </div>
                    <p class="bento-card-desc">Sell tickets online with multiple types, scan QR codes for check-ins, and track attendance with a live dashboard.</p>
                    
                    <div class="bento-card-body ticket-preview-box">
                        <!-- Digital Event Ticket Mockup -->
                        <div class="bmt-digital-ticket">
                            <div class="ticket-header" style="background-color: var(--accent-blue); padding: 12px 16px 14px 16px; margin: -14px -14px 14px -14px; border-bottom: none;">
                                <h4 style="color: #FFFFFF !important; margin: 0; font-size: 9px; font-weight: 700; letter-spacing: 1px; opacity: 0.9;">EVENT SCHEDULE</h4>
                                <span style="color: #FFFFFF !important; font-size: 14px; font-weight: 800; display: block; margin-top: 2px;">Jazz Night</span>
                            </div>
                            
                            <!-- Ticket notches and perforation -->
                            <div class="ticket-notch notch-left"></div>
                            <div class="ticket-notch notch-right"></div>
                            <div class="ticket-perforated"></div>
                            
                            <div class="ticket-qr-wrap" style="padding: 6px 0; display: flex; justify-content: center; position: relative;">
                                <div class="qr-placeholder" style="position: relative; display: inline-block; padding: 10px; background-color: #FFFFFF; border-radius: 6px;">
                                    <img src="{{ asset('assets/images/qr-code-user.png') }}" style="width: 96px; height: 96px; display: block; object-fit: contain;" alt="QR Code">
                                    <!-- Scanning laser animation line -->
                                    <div class="scan-laser-line"></div>
                                </div>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 10px; color: var(--text-muted); margin-top: 10px; border-top: none; padding-top: 8px;">
                                <span>GA x1</span>
                                <span>#0042</span>
                            </div>
                        </div>
                        
                        <!-- Floating Checked In Badge -->
                        <div class="bento-floating-stat" style="position: absolute; bottom: 20px; left: 16px; padding: 5px 10px; border-radius: 6px;">
                            <span class="lbl" style="font-weight: 700; color: var(--text-light); font-size: 9px;"><i class="fa-solid fa-circle-check" style="color: var(--success); margin-right: 3px;"></i> 142 checked in</span>
                        </div>
                    </div>
                    
                    <div class="bento-card-footer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; font-size: 11px; border-top: 1px solid var(--border-color); padding-top: 12px;">
                        <span style="color: var(--text-muted);"><i class="fa-solid fa-lock" style="margin-right: 4px;"></i> Secure Stripe payments</span>
                        <a href="{{ route('software.features') }}" class="bento-learn-more-link link-accent-blue" style="font-weight: 600;">Learn more <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Card 2: Newsletters -->
                <div class="bento-card bento-card-2">
                    <div class="bento-card-header-row">
                        <div class="bento-card-icon bento-accent-blue"><i class="fa-solid fa-envelope"></i></div>
                        <h3>Newsletters</h3>
                    </div>
                    
                    <div class="bento-card-body-row">
                        <div class="bento-text-side">
                            <p class="bento-card-desc">Send branded emails to followers and ticket buyers with a drag-and-drop editor and A/B testing.</p>
                            <div>
                                <div style="color: var(--text-dark); font-size: 10px; margin-bottom: 6px;">Templates &bull; Audience segments &bull; A/B testing</div>
                                <a href="{{ route('software.features') }}" class="bento-learn-more-link link-accent-blue" style="font-weight: 600;">Learn more <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="bento-visual-side">
                            <!-- Mini Newsletter Preview Mockup -->
                            <div style="position: relative; width: 100%; max-width: 145px; margin-left: auto;">
                                <!-- Sent to 940 followers tag -->
                                <div style="position: absolute; top: -10px; right: 0; background-color: var(--accent-blue); color: #FFFFFF; font-size: 8px; font-weight: 700; padding: 3px 8px; border-radius: 10px; z-index: 2; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                    Sent to 940 followers
                                </div>
                                <div style="background-color: var(--secondary-bg); border: 1px solid var(--border-color); border-radius: 10px; padding: 12px; width: 100%; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                                    <div style="background-color: var(--accent-blue); padding: 6px 10px; border-radius: 5px; font-size: 9px; color: #FFFFFF; font-weight: 700; display: flex; align-items: center; gap: 5px;">
                                        <i class="fa-solid fa-envelope-open"></i> This Week's Events
                                    </div>
                                    <div style="background-color: rgba(59, 130, 246, 0.05); height: 32px; border-radius: 5px; border: 1px dashed var(--border-color); margin-top: 8px; display: flex; align-items: center; justify-content: center; font-size: 8px; font-weight: 700; color: var(--accent-blue);">
                                        Featured Event
                                    </div>
                                    <div style="display: flex; gap: 6px; margin-top: 8px;">
                                        <div style="flex:1; height: 16px; background-color: rgba(255,255,255,0.01); border: 1px solid var(--border-color); border-radius: 4px;"></div>
                                        <div style="flex:1; height: 16px; background-color: rgba(255,255,255,0.01); border: 1px solid var(--border-color); border-radius: 4px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: AI-Powered -->
                <div class="bento-card bento-card-3">
                    <div class="bento-card-header-row">
                        <div class="bento-card-icon bento-accent-blue"><i class="fa-solid fa-brain"></i></div>
                        <h3>AI-Powered</h3>
                    </div>
                    
                    <div class="bento-card-body-row">
                        <div class="bento-text-side">
                            <p class="bento-card-desc">Parse text and images, generate flyers and descriptions, create your brand style, and translate to 12 languages with AI.</p>
                            <div>
                                <a href="{{ route('software.features') }}" class="bento-learn-more-link link-accent-blue" style="font-weight: 600;">Learn more <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="bento-visual-side">
                            <div style="display: flex; align-items: center; gap: 10px; width: 100%; max-width: 176px; margin-left: auto;">
                                <!-- Left card (uploaded flyer thumbnail) -->
                                <div style="background-color: var(--secondary-bg); border: 1px solid var(--border-color); border-radius: 8px; padding: 10px; text-align: center; flex: 1; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                                    <i class="fa-regular fa-image" style="font-size: 14px; color: var(--text-muted); margin-bottom: 5px; display: block;"></i>
                                    <div style="height: 3px; background-color: var(--border-color); border-radius: 2px; width: 80%; margin: 3px auto;"></div>
                                    <div style="height: 3px; background-color: var(--border-color); border-radius: 2px; width: 50%; margin: 3px auto;"></div>
                                </div>
                                <i class="fa-solid fa-arrow-right" style="color: var(--accent-blue); font-size: 12px;"></i>
                                <!-- Right stack (extracted attributes) -->
                                <div style="display: flex; flex-direction: column; gap: 5px; flex: 1.5;">
                                    <div style="background-color: var(--secondary-bg); border: 1px solid var(--border-color); border-radius: 5px; padding: 4px 6px; display: flex; align-items: center; gap: 5px; color: var(--text-light); font-size: 8px; font-weight:600;"><i class="fa-regular fa-calendar" style="color: var(--accent-blue);"></i> Sat, Jul 18 - 8:00 PM</div>
                                    <div style="background-color: var(--secondary-bg); border: 1px solid var(--border-color); border-radius: 5px; padding: 4px 6px; display: flex; align-items: center; gap: 5px; color: var(--text-light); font-size: 8px; font-weight:600;"><i class="fa-solid fa-location-dot" style="color: var(--accent-blue);"></i> The Blue Note</div>
                                    <div style="background-color: var(--secondary-bg); border: 1px solid var(--border-color); border-radius: 5px; padding: 4px 6px; display: flex; align-items: center; gap: 5px; color: var(--text-light); font-size: 8px; font-weight:600;"><i class="fa-solid fa-ticket" style="color: var(--accent-blue);"></i> $25 - 120 tickets</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Boost -->
                <div class="bento-card bento-card-4">
                    <div class="bento-card-header-row">
                        <div class="bento-card-icon bento-accent-orange"><i class="fa-solid fa-rocket"></i></div>
                        <h3>Boost</h3>
                    </div>
                    <p class="bento-card-desc">Turn any event into a Facebook or Instagram ad in minutes. Set your budget, pick your audience, and launch.</p>
                    
                    <div class="bento-card-body" style="margin-top: 15px;">
                        <div style="background-color: var(--secondary-bg); border: 1px solid var(--border-color); border-radius: 10px; padding: 10px; width: 100%; max-width: 136px; margin: 12px auto 0 auto; box-shadow: 0 4px 15px rgba(0,0,0,0.05); font-size: 9px;">
                            <div style="display: flex; align-items: center; gap: 5px; margin-bottom: 6px;">
                                <div style="width: 14px; height: 14px; border-radius: 50%; background-color: var(--accent-orange); display: flex; align-items: center; justify-content: center; color: #FFFFFF; font-size: 7px;"><i class="fa-solid fa-music"></i></div>
                                <div>
                                    <div style="font-weight: 700; color: var(--text-light); line-height: 1;">The Blue Note</div>
                                    <div style="font-size: 7px; color: var(--text-muted);">Sponsored</div>
                                </div>
                            </div>
                            <div style="background-color: #FEF08A; color: #854D0E; padding: 14px 8px; border-radius: 6px; font-weight: 800; text-align: center; margin-bottom: 6px; font-size: 11px; letter-spacing: 0.5px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);">
                                Jazz Night
                             </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 8px;">
                                <span style="color: var(--text-muted);"><i class="fa-regular fa-heart"></i> 142</span>
                                <span style="background-color: #EA580C; color: #FFFFFF; padding: 2px 6px; border-radius: 3px; font-weight: 700; font-size: 8px;">Learn More</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bento-card-footer" style="margin-top: 15px; font-size: 12px;">
                        <a href="{{ route('software.features') }}" class="bento-learn-more-link link-accent-orange" style="font-weight: 600;">Learn more <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Card 5: Built-in Analytics -->
                <div class="bento-card bento-card-5">
                    <div class="bento-card-header-row">
                        <div class="bento-card-icon bento-accent-green"><i class="fa-solid fa-chart-simple"></i></div>
                        <h3>Built-in Analytics</h3>
                    </div>
                    <p class="bento-card-desc">Track page views, device breakdown, top events, and traffic sources. No external services required.</p>
                    
                    <div class="bento-card-body" style="margin-top: 15px;">
                        <div style="display: flex; justify-content: center; align-items: flex-end; gap: 8px; height: 72px; margin-bottom: 12px;">
                            <!-- 5 solid green bars -->
                            <div style="width: 18px; height: 28px; background-color: rgba(16, 185, 129, 0.7); border-radius: 4px;"></div>
                            <div style="width: 18px; height: 45px; background-color: rgba(16, 185, 129, 0.7); border-radius: 4px;"></div>
                            <div style="width: 18px; height: 35px; background-color: rgba(16, 185, 129, 0.7); border-radius: 4px;"></div>
                            <div style="width: 18px; height: 60px; background-color: rgba(16, 185, 129, 0.7); border-radius: 4px;"></div>
                            <div style="width: 18px; height: 50px; background-color: rgba(16, 185, 129, 0.7); border-radius: 4px;"></div>
                            <!-- 1 solid blue bar -->
                            <div style="width: 18px; height: 72px; background-color: #4E81FA; border-radius: 4px;"></div>
                        </div>
                        <div style="font-size: 10px; font-weight: 700; text-align: center; color: var(--text-light);">12,480 page views this month</div>
                    </div>
                    
                    <div class="bento-card-footer" style="margin-top: 15px; font-size: 12px;">
                        <a href="{{ route('software.features') }}" class="bento-learn-more-link link-accent-green" style="font-weight: 600;">Learn more <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Card 6: Calendar Sync -->
                <div class="bento-card bento-card-6">
                    <div class="bento-card-header-row">
                        <div class="bento-card-icon bento-accent-blue"><i class="fa-solid fa-calendar-days"></i></div>
                        <h3>Calendar Sync</h3>
                    </div>
                    <p class="bento-card-desc">Two-way sync with Google Calendar. Let attendees add events to Apple, Google, or Outlook calendars.</p>
                    
                    <div class="bento-card-body" style="margin-top: 15px; display: flex; align-items: center; justify-content: center; gap: 12px;">
                        <div style="background-color: var(--accent-blue); width: 28px; height: 28px; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #FFFFFF; font-size: 10px; font-weight: 800; box-shadow: 0 4px 10px rgba(59, 130, 246, 0.2);">ES</div>
                        <div style="border-top: 2px dashed var(--border-color); width: 36px; position: relative;">
                            <div style="position: absolute; top: -4px; left: 15px; width: 6px; height: 6px; border-radius: 50%; background-color: var(--accent-bright);"></div>
                        </div>
                        <div class="mini-calendar-mockup" style="background-color: var(--secondary-bg); border: 1px solid var(--border-color); width: 32px; height: 32px; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 4px 12px rgba(0,0,0,0.08); position: relative; flex-shrink: 0;">
                            <div style="background-color: var(--accent-blue); height: 8px; width: 100%; display: flex; justify-content: space-around; align-items: center; padding: 0 4px;">
                                <div style="width: 2px; height: 3px; background-color: #FFFFFF; border-radius: 1px;"></div>
                                <div style="width: 2px; height: 3px; background-color: #FFFFFF; border-radius: 1px;"></div>
                            </div>
                            <div style="flex-grow: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; background-color: var(--card-bg); padding: 2px;">
                                <span style="font-size: 12px; font-weight: 800; color: var(--text-light); line-height: 1;">24</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bento-card-footer" style="margin-top: 15px; font-size: 12px;">
                        <a href="{{ route('software.features') }}" class="bento-learn-more-link link-accent-blue" style="font-weight: 600;">Learn more <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
