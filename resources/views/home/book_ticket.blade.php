<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/venue/venue.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @include('includes.analytics')
    <style>
            html, body {
                margin: 0;
                padding: 0;
                min-height: 100%;
                font-family: 'Inter', sans-serif !important;
                background: #f4f6fb;
                color: #10214b;
            }

            body {
                line-height: 1.5;
            }

            /* Header adjustments to match Image 1 */
            header {
                display: flex;
                background: #234a9f;
                padding: 10px 10px !important;
                box-shadow: 0px 1px 4px #E5E5E5;
            }
            .header {
                width: 100% !important;
                max-width: 556px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                margin: 0 auto !important;
                padding: 0 !important;
            }
            .header img {
                height: 24px !important;
                width: auto !important;
                filter: invert(1);
            }
            .header-title {
                  flex-grow: 1;
    text-align: center;
    font-size: 15px;
    font-weight: 500;
            }
            .header-icons .icon {
                font-size: 20px;
                margin-left: 20px;
                cursor: pointer;
            }

            .book-ticket-container {
                max-width: 840px;
                margin: 0 auto;
                padding: 24px 16px 40px;
            }

            /* Stepper Progress bar style matching Image 1 */
            /* Stepper Progress bar style matching Image 1 */
         
         
         .progress_sec {
                background-color: #fff;
                padding: 3px 0 8px;
                position: relative;
                overflow: hidden;
            }

            .progress-bar {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                position: relative;
                gap: 0;
                padding: 0 16px;
                min-height: 52px;
            }

            .progress-bar .step {
                position: relative;
                width: 100%;
                max-width: 120px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
                gap: 4px;
                text-align: center;
                padding: 0;
            }

            .progress-bar .step .circle {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                border: 2px solid #e5e8f2;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 17px;
                font-weight: normal !important;
                margin-top: 10px;
                margin-bottom: 0;
                position: relative;
                line-height: 10px;
                z-index: 2;
            }

            .progress-bar .step .circle span {
                display: block;
                width: auto !important;
                height: auto !important;
                background: transparent !important;
                border-radius: 0 !important;
            }

            .progress-bar .step.completed .circle {
                background: #234a9f;
                border-color: #234a9f;
                color: #fff;
            }

            .progress-bar .step.active .circle {
                background: #234a9f;
                border-color: #234a9f;
                color: #fff;
            }

            .progress-bar .step:not(.completed):not(.active) .circle {
                background: #eff3fb;
                border-color: #dce4f4;
                color: #7b84a1;
            }

            .progress-bar .step:not(:last-child)::after, .progress-bar .step:not(:first-child)::before {
                content: '';
                position: absolute;
                top: 26px;
                height: 4px;
                border-radius: 999px;
                z-index: 1;
            }

            .progress-bar .step:not(:last-child)::after {
                left: calc(42% + 35px);
                right: -100px;
            }

            .progress-bar .step:not(:first-child)::before {
                left: -156px;
                right: calc(53% + 19px);
                background: #eff3fb;
            }

            .progress-bar .step.completed::after, .progress-bar .step.active::before {
                background: linear-gradient(90deg, #1b49d9 0%, #234a9f 100%);
            }

            .progress-bar .step .label {
                font-size: 13px;
                font-weight: 500;
                color: #10214b;
            }

            .progress-bar .step.completed .label, .progress-bar .step.active .label {
                color: #234a9f;
            }

            .progress-bar .step .label {
                margin-top: 4px;
            }

            .progress-bar .step .label span {
                display: block;
                margin-top: 4px;
                color: #7b84a1;
                font-size: 12px;
                font-weight: 600;
            }

            .progress-bar .step .label.active {
                color: #234a9f;
            }

            @media (max-width: 720px) {
                .progress-bar {
                    padding: 0 8px;
                    min-height: 90px;
                }

                .progress-bar .step {
                    max-width: 90px;
                }
            }
            
            
            /* Event Header Card matching Image 1 */
            .event-header-card {
                background: #f5f8ff;
                border-radius: 20px;
                border: 1px solid #e1e8f8;
                padding: 20px;
                margin-bottom: 24px;
                box-shadow: 0 10px 25px rgba(16, 24, 64, 0.02);
            }
            .event-header-content {
                display: grid;
                grid-template-columns: auto 1fr;
                gap: 20px;
                align-items: center;
            }
            .event-image {
                width: 100px;
                height: 100px;
                border-radius: 16px;
                border: 1px solid #dce4f4;
                background: #fff;
                display: grid;
                place-items: center;
                overflow: hidden;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            }
            .event-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            .event-info h2 {
                color: #0f172a;
                margin: 0 0 8px;
                font-size: 20px;
                font-weight: 800;
                line-height: 1.2;
            }
            .venue-location {
                margin: 0 0 8px;
                color: #475569;
                display: flex;
                align-items: flex-start;
                gap: 6px;
                font-size: 13.5px;
                line-height: 1.4;
            }
            .venue-location i {
                color: #64748b;
                margin-top: 3px;
            }
            .venue-location span {
                display: flex;
                flex-direction: column;
            }
            .venue-location span .city-sub {
                font-size: 12.5px;
                color: #64748b;
                font-weight: 400;
                margin-top: 2px;
            }
            .event-tags {
                margin: 0;
                display: flex;
                align-items: center;
                gap: 6px;
                color: #64748b;
                font-size: 13px;
                font-weight: 500;
            }

            /* Selection Card styling (Date and Available Shows) */
            .selection-card {
                background: #fff;
                border-radius: 20px;
                border: 1px solid #e2e8f0;
                padding: 24px;
                margin-bottom: 24px;
                box-shadow: 0 10px 25px rgba(16, 24, 64, 0.02);
            }
            .section-heading {
                margin-bottom: 20px;
            }

            /* Horizontally Scrollable Date Grid */
            .date-grid-wrapper {
                position: relative;
                display: flex;
                align-items: center;
                width: 100%;
            }
            .date-grid {
                display: flex;
                overflow-x: auto;
                gap: 10px;
                padding: 4px 0 12px;
                width: 100%;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }
            .date-grid::-webkit-scrollbar {
                display: none;
            }
            .scroll-arrow-right {
                position: absolute;
                right: -12px;
                z-index: 10;
                width: 32px;
                height: 32px;
                border-radius: 50%;
                background: #fff;
                box-shadow: 0 4px 12px rgba(0,0,0,0.08);
                display: grid;
                place-items: center;
                cursor: pointer;
                border: 1px solid #e2e8f0;
                color: #234a9f;
                transition: all 0.2s ease;
            }
            .scroll-arrow-right:hover {
                background: #f8fafc;
                transform: scale(1.05);
            }
            
             .scroll-arrow-left {
                opacity: 0;
                display: none ;
                position: absolute;
                left: -12px;
                z-index: 10;
                width: 32px;
                height: 32px;
                border-radius: 50%;
                background: #fff;
                box-shadow: 0 4px 12px rgba(0,0,0,0.08);
                display: grid;
                place-items: center;
                cursor: pointer;
                border: 1px solid #e2e8f0;
                color: #234a9f;
                transition: all 0.2s ease;
            }
            .scroll-arrow-left:hover {
                background: #f8fafc;
                transform: scale(1.05);
            }

            /* Date Pill styling matching Image 1 */
            .date-pill {
                flex: 0 0 78px;
                width: 78px;
                padding: 14px 4px;
                border-radius: 12px;
                border: 1px solid #e2e8f0;
                background: #fff;
                text-align: center;
                cursor: pointer;
                transition: all 0.2s ease;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 6px;
                box-sizing: border-box;
            }
            .date-pill:hover {
                border-color: #cbd5e1;
                background: #f8fafc;
            }
            .date-pill.selected {
                background: #234a9f;
                border-color: #234a9f;
                color: #fff !important;
                box-shadow: 0 8px 16px rgba(35, 74, 159, 0.15);
                transform: translateY(-1px);
            }
            .date-pill p {
                margin: 0;
            }
            .date-pill .day-name {
                font-size: 11px;
                font-weight: 700;
                color: #64748b;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            .date-pill.selected .day-name {
                color: rgba(255, 255, 255, 0.8) !important;
            }
            .date-pill .day-number {
                font-size: 20px;
                font-weight: 800;
                color: #0f172a;
                line-height: 1;
            }
            .date-pill.selected .day-number {
                color: #fff !important;
            }
            .date-pill .month-text {
                font-size: 11px;
                font-weight: 700;
                color: #64748b;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            .date-pill.selected .month-text {
                color: rgba(255, 255, 255, 0.8) !important;
            }

            /* Shows Section styling matching Image 1 */
            .shows-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 16px;
                margin-top: 8px;
            }
            .show-card-item {
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                padding: 20px 10px;
                position: relative;
                display: flex;
                flex-direction: column;
                transition: all 0.2s ease;
                cursor: pointer;
                box-sizing: border-box;
                overflow: hidden;
            }
            .show-card-item:hover {
                transform: translateY(-2px);
                border-color: #234a9f;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.04);
            }
            .show-card-item.selected, .show-card-item.most-popular {
                border: 2px solid #234a9f;
                box-shadow: 0 10px 25px rgba(35, 74, 159, 0.1);
            }
            .popular-ribbon {
                position: absolute;
                top: 0;
                right: 12px;
                background: #234a9f;
                color: #fff;
                font-size: 9px;
                font-weight: 800;
                padding: 5px 8px 6px;
                border-radius: 0 0 4px 4px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                line-height: 1;
                z-index: 2;
            }
            .show-time-title {
                font-size: 20px;
                font-weight: 800;
                color: #0f172a;
                text-align: center;
                margin-top: 6px;
                margin-bottom: 6px;
            }
            .show-status {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
                font-size: 13px;
                font-weight: 600;
                margin-bottom: 14px;
            }
            .status-dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                display: inline-block;
            }
            .show-status.good-availability {
                color: #16a34a;
            }
            .status-dot.good-availability {
                background-color: #22c55e;
            }
            .show-status.filling-fast {
                color: #ea580c;
            }
            .show-status.almost-full {
                color: #dc2626;
            }
            .status-dot.almost-full {
                background-color: #ef4444;
            }
            .show-divider {
                height: 1px;
                background: #f1f5f9;
                width: 100%;
                margin-bottom: 14px;
            }
            .class-grid {
                display: grid;
                gap: 4px;
                text-align: center;
                margin-bottom: 16px;
            }
            .class-item {
                position: relative;
            }
            .class-name {
                font-size: 10px;
                font-weight: 700;
                color: #94a3b8;
                letter-spacing: 0.5px;
                text-transform: uppercase;
                margin-bottom: 4px;
            }
            .class-seats {
                font-size: 10px;
                font-weight: 700;
                color: #334155;
            }
            .class-seats.available {
                color: #16a34a !important;
            }
            .class-seats.filling-fast {
                color: #ea580c !important;
            }
            .class-seats.few-left {
                color: #dc2626 !important;
            }
            .class-seats.sold-out {
                color: #94a3b8 !important;
            }
            .select-show-btn {
                width: 100%;
                padding: 9px 16px;
                border-radius: 10px;
                font-size: 13px;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.2s ease;
                text-align: center;
                background: transparent;
                border: 1px solid #234a9f;
                color: #234a9f;
                outline: none;
            }
            .show-card-item:hover .select-show-btn {
                background: #234a9f;
                color: #fff;
            }
            .show-card-item.selected .select-show-btn, .show-card-item.most-popular .select-show-btn {
                background: #234a9f;
                border-color: #234a9f;
                color: #fff;
            }
            .show-card-item.selected .select-show-btn:hover, .show-card-item.most-popular .select-show-btn:hover {
                background: #1b3d85;
                border-color: #1b3d85;
            }

            /* Why Book Early Yellow Banner matching Image 1 */
            .early-booking-banner {
                background-color: #fffdf5;
                border: 1px solid #ebdcb2;
                border-radius: 16px;
                padding: 16px 20px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                margin-top: 10px;
                margin-bottom: 20px;
                box-shadow: 0 4px 12px rgba(235, 220, 178, 0.1);
            }
            .banner-title {
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 14.5px;
                font-weight: 800;
                color: #856404;
                flex-shrink: 0;
            }
            .banner-title i {
                color: #eab308;
                font-size: 18px;
            }
            .banner-divider-vertical {
                width: 1px;
                height: 36px;
                background: #e2d2a2;
                flex-shrink: 0;
            }
            .banner-items {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                flex-grow: 1;
            }
            .banner-item {
                display: flex;
                align-items: center;
                gap: 10px;
                flex: 1;
            }
            .banner-item-icon {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                background: #fff;
                display: grid;
                place-items: center;
                border: 1px solid #e2d2a2;
                color: #234a9f;
                font-size: 14px;
                flex-shrink: 0;
            }
            .banner-item-text {
                display: flex;
                flex-direction: column;
                line-height: 1.3;
            }
            .banner-item-title {
                font-size: 12.5px;
                font-weight: 800;
                color: #0f172a;
            }
            .banner-item-desc {
                font-size: 11px;
                color: #64748b;
                font-weight: 400;
            }

            .footer-badges {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 8px;
                margin-top: 20px;
                margin-bottom: 20px;
                font-size: 13px;
                font-weight: 600;
                color: #64748b;
            }
            .footer-badges i {
                font-size: 15px;
            }

            @media (max-width: 960px) {
                .shows-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }

            @media (max-width: 768px) {
                .progress-bar {
                    padding: 0 16px;
                }
                .progress-bar::before, .progress-bar-fill {
                    left: 16px;
                    right: 16px;
                }
                .shows-grid {
                    grid-template-columns: 1fr;
                }
                .early-booking-banner {
                    flex-direction: column;
                    align-items: flex-start;
                    padding: 16px;
                }
                .banner-divider-vertical {
                    display: none;
                }
                .banner-items {
                    flex-direction: column;
                    align-items: flex-start;
                    width: 100%;
                    gap: 14px;
                }
                .banner-item {
                    width: 100%;
                }
            }
        </style>
</head>
<body>
     
    <header>
        <div class="logo">
            <a href="{{ route('index') }}"><img src="{{ asset('assets/venue/logo.png') }}" alt="ops logo" style="height: auto;width: 90px;position: absolute;margin-top: -2px;object-fit: cover;"></a>
        </div>
        <div class="header">
            <div class="hder_icon" style="cursor:pointer;" onclick="javascript:history.go(-1)"><img src="{{ asset('assets/venue/left.png') }}" alt=""></div>
            <div class="header-title">{{ env('APP_NAME') }}</div>
            <div class="header-icons">
                <div class="icon"><a href="{{ route('index') }}"><img src="{{ asset('assets/venue/close.png') }}" alt="" style="width: 24px;height: 24px;"></a></div>
            </div>
        </div>
    </header>
    <section class="progress_sec">
        <div class="progress-bar">
           
            <div class="step completed">
                <div class="circle"><span><i class="fa-solid fa-check"></i></span></div>
                <div class="label">Venue</div>
            </div>
            <div class="step active">
                <div class="circle"><span>2</span></div>
                <div class="label">Date & Time</div>
            </div>
            <div class="step">
                <div class="circle"><span>3</span></div>
                <div class="label">Seats</div>
            </div>
        </div>
    </section>
    <div class="book-ticket-container">

        @php
            try {
                $event_data = getEvent($event_id);
                $event_title = ucwords($event_data->event_title);
                $city_data = getCity($event_data->city_id);
                $city_name = $city_data->name;
                $city_name = strtolower($city_name);
                $city_name = ucfirst($city_name);
                $venue_data = getVenue($event_data->venue_id);
                $venue_name = ucfirst($venue_data->name);
                $event_banner = $event_data->event_banner ?? null;

                $state_data = null;
                if ($city_data && isset($city_data->state_id)) {
                    $state_data = getState($city_data->state_id);
                }
                $state_name = $state_data ? strtoupper(strtolower($state_data->name)) : '';

                $unique_date_id = [];
                $event_seat_dates = DB::table('event_seat')
                    ->where('event_id', $event_id)
                    ->groupBy('event_schedule_list_id')
                    ->get();
                foreach ($event_seat_dates as $event_schedule) {
                    $unique_date_id[] = $event_schedule->event_schedule_list_id;
                }

                $event_schedule_lists = DB::table('event_schedule_list')
                    ->where('event_id', $event_id)
                    ->where('allow_online_booking', 'YES')
                    ->whereDate('event_date', '>=', date('Y-m-d'))
                    ->whereIn('id', $unique_date_id)
                    ->take(35)
                    ->get();
            } catch (Exception $e) {
                $event_title = 'Error loading event data';
                $venue_name = 'N/A';
                $city_name = 'N/A';
                $state_name = '';
                $event_banner = null;
                $event_schedule_lists = collect();
            }
        @endphp

        @php
            $current_month = $event_schedule_lists->first() ? date('F Y', strtotime($event_schedule_lists->first()->event_date)) : date('F Y');
        @endphp

        <div class="event-header-card">
            <div class="event-header-content">
                <div class="event-image">
                    @if(isset($event_banner) && $event_banner != '')
                        <img src="{{ asset($event_banner) }}" alt="{{ $event_title }}" />
                    @else
                        <div class="placeholder-image"><img src="{{ asset('opspose_web.png') }}" alt="Placeholder Image">  </div>
                    @endif
                </div>
                <div class="event-info">
                    <h2>{{ $event_title ?? 'Event Name' }}</h2>
                    <p class="venue-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>
                            <strong style="color: #0f172a;">{{ $venue_name ?? 'Venue' }}</strong>
                            <span class="city-sub">{{ $city_name ?? 'City' }}{{ $state_name ? ', ' . $state_name : '' }}</span>
                        </span>
                    </p>
                    <p class="event-tags">
                        <i class="fas fa-users" style="color: #64748b; margin-right: 4px;"></i>
                        <span>Family Show &nbsp;•&nbsp; All Ages</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="selection-card" style="padding: 20px;">
            <div class="section-heading" style="display: flex; justify-content: space-between; align-items: center; width: 100%; border-bottom: none; margin-bottom: 16px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-calendar3" style="color: #234a9f; font-size: 18px; width: auto; height: auto; display: inline-block;"></i>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a;">Select Date</h3>
                </div>
                
            </div>
            
            <div class="date-grid-wrapper">
                
                <div class="scroll-arrow-left">
                    <i class="bi bi-chevron-left"></i>
                </div>
                <div class="date-grid" id="show_date_list">
                    @if ($event_schedule_lists->isEmpty())
                        <div style="grid-column: 1 / -1; text-align: center; padding: 20px; color: #5d6888;">No schedule available</div>
                    @else
                        @foreach ($event_schedule_lists as $event_schedule_list)
                            <div class="date-pill" onclick="choose_date('{{ $event_schedule_list->id }}', '{{ $event_schedule_list->event_date }}', this)">
                                <p class="day-name">{{ date('D', strtotime($event_schedule_list->event_date)) }}</p>
                                <p class="day-number">{{ date('d', strtotime($event_schedule_list->event_date)) }}</p>
                                <p class="month-text">{{ date('M', strtotime($event_schedule_list->event_date)) }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="scroll-arrow-right">
                    <i class="bi bi-chevron-right"></i>
                </div>
            </div>
        </div>

        <div class="selection-card" id="show_list" style="display:none; padding: 20px;">
            <div class="section-heading" style="display: flex; align-items: center; gap: 8px; border-bottom: none; margin-bottom: 20px;">
                <i class="bi bi-clock" style="color: #234a9f; font-size: 18px; width: auto; height: auto; display: inline-block;"></i>
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a;">Available Shows on <span id="selected-date-text" style="color: #234a9f;">Selected Date</span></h3>
                </div>
            </div>
            <div class="shows-section">
                <div class="shows-grid" id="show_list_row"></div>
            </div>
        </div>

        <div class="early-booking-banner">
            <div class="banner-title">
                <i class="fas fa-star"></i>
                <span>Why book early?</span>
            </div>
            
            <div class="banner-divider-vertical"></div>
            
            <div class="banner-items">
                <div class="banner-item">
                    <div class="banner-item-icon">
                        <i class="fas fa-chair"></i>
                    </div>
                    <div class="banner-item-text">
                        <span class="banner-item-title">Best Seats</span>
                        <span class="banner-item-desc">Get the best seats</span>
                    </div>
                </div>
                
                <div class="banner-item">
                    <div class="banner-item-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="banner-item-text">
                        <span class="banner-item-title">Better Prices</span>
                        <span class="banner-item-desc">Early bird offers</span>
                    </div>
                </div>
                
                <div class="banner-item">
                    <div class="banner-item-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="banner-item-text">
                        <span class="banner-item-title">Hassle Free</span>
                        <span class="banner-item-desc">Smooth entry</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-badges">
            <i class="bi bi-shield-check" style="color: #10b981;"></i>
            <span>Secure Booking</span>
             <i class="bi bi-telephone" style="color: #10b981;"></i>
            <span>Quick Support</span>
        </div>
    </div>

    <form class="card" method="post" action="{{ route('book_ticket_next') }}" id="book_ticket_next">
        @csrf
        <input type="hidden" id="show_date_id" name="show_date_id">
        <input type="hidden" id="show_time_id" name="show_time_id">
    </form>

    <script type="text/javascript">
        function choose_show_time(show_id) {
            if (typeof posthog !== 'undefined') {
                posthog.capture('ShowTime Selected');
            }
            $('#show_time_id').val(show_id);
            $('.show-card-item').removeClass('selected');
            $('#show_time_' + show_id).addClass('selected');
            $('#book_ticket_next').submit();
        }

        function choose_date(scheduleId, eventDate, element) {
            if (typeof posthog !== 'undefined') {
                posthog.capture('Date Selected');
            }
            $('.date-pill').removeClass('selected');
            $(element).addClass('selected');
            $('#show_date_id').val(scheduleId);
            $('#show_list').fadeOut('fast');
            if (scheduleId !== '') {
                $('#show_list').fadeIn('fast');
                
                // Safe local date formatting to "Tue, 02 Jun" to avoid timezone offset shifts
                var dateParts = eventDate.split('-');
                var dateObj = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
                var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                var dayName = days[dateObj.getDay()];
                var dayNum = ('0' + dateObj.getDate()).slice(-2);
                var monthName = months[dateObj.getMonth()];
                var formattedDateStr = dayName + ', ' + dayNum + ' ' + monthName;
                
                $('#selected-date-text').text(formattedDateStr);
                
                var fullMonthYear = dateObj.toLocaleDateString('default', { month: 'long', year: 'numeric' });
                $('#current-month').text(fullMonthYear);
                
                var data = {
                    _token: '{{ csrf_token() }}',
                    event_schedule_list_id: scheduleId
                };
                $.ajax({
                    type: 'POST',
                    url: '{{ route('fetch_show_time') }}',
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#show_list_row').html('<div style="grid-column: 1 / -1; text-align: center; padding: 20px;"><i class="fas fa-spinner fa-spin"></i></div>');
                    },
                    success: function(response) {
                        $('#show_list_row').html('');
                        var showTimes = response.event_show_times || [];
                        $.each(showTimes, function(key, value) {
                            var statusClass = value.status_class || 'good-availability';
                            var statusText = value.status_text || 'Good Availability';
                            var startTime = value.start_time || value.show_time || value.time || '00:00';
                            
                            var isMostPopular = (statusClass === 'filling-fast');
                            if (!isMostPopular && showTimes.length >= 2 && key === 1) {
                                isMostPopular = true;
                            }
                            
                            var popularBadge = '';
                            var cardClass = 'show-card-item';
                            if (isMostPopular) {
                                cardClass += ' most-popular';
                                popularBadge = '<div class="popular-ribbon">MOST POPULAR</div>';
                            }
                            
                            var statusIndicator = '';
                            if (statusClass === 'filling-fast') {
                                statusIndicator = '<i class="fas fa-fire" style="color: #ea580c; font-size: 12px; margin-right: 4px;"></i>';
                            } else if (statusClass === 'almost-full') {
                                statusIndicator = '<span class="status-dot almost-full" style="background-color: #ef4444; margin-right: 6px;"></span>';
                            } else {
                                statusIndicator = '<span class="status-dot good-availability" style="background-color: #22c55e; margin-right: 6px;"></span>';
                            }
                            
                            // Build ticket categories list dynamically
                            var categories = value.categories || [];
                            var categoriesHtml = '';
                            $.each(categories, function(catIndex, cat) {
                                var borderStyle = (catIndex < categories.length - 1) ? ' border-right: 1px solid #e2e8f0;' : '';
                                categoriesHtml += 
                                    '<div class="class-item" style="position: relative;' + borderStyle + '">' +
                                    '<div class="class-name">' + cat.category_name + '</div>' +
                                    '<div class="class-seats ' + cat.status_class + '">' + cat.status + '</div>' +
                                    '</div>';
                            });
                            
                            var gridStyle = 'display: grid; grid-template-columns: repeat(' + categories.length + ', 1fr); gap: 4px; text-align: center; margin-bottom: 16px;';
                            
                            $('#show_list_row').append(
                                '<div class="' + cardClass + '" id="show_time_' + value.id + '" onclick="choose_show_time(' + value.id + ')">' +
                                popularBadge +
                                '<div class="show-time-title">' + startTime + '</div>' +
                                '<div class="show-status ' + statusClass + '">' +
                                statusIndicator + statusText +
                                '</div>' +
                                '<div class="show-divider"></div>' +
                                '<div class="class-grid" style="' + gridStyle + '">' +
                                categoriesHtml +
                                '</div>' +
                                '<button class="select-show-btn">Select Show</button>' +
                                '</div>'
                            );
                        });
                    },
                    error: function() {
                        $('#show_list_row').html('<div style="grid-column: 1 / -1; text-align: center; padding: 20px; color: #c62828;">Unable to load show times. Please try again.</div>');
                    }
                });
            } else {
                $('#show_list_row').empty();
            }
        }

        $(document).ready(function() {
            // Auto click the first date pill if it exists to pre-populate shows
            var firstDatePill = $('.date-pill').first();
            if (firstDatePill.length > 0) {
                firstDatePill.click();
            }

            // Click handler for date scrollbar right arrow
            $(document).on('click', '.scroll-arrow-right', function() {
                var container = $('#show_date_list');
                container.animate({ scrollLeft: container.scrollLeft() + 200 }, 300);
                $('.scroll-arrow-left').css('opacity', '1');
                 $('.scroll-arrow-right').css('opacity', '0');
            });
            
            
             $(document).on('click', '.scroll-arrow-left', function() {
                var container = $('#show_date_list');
                container.animate({ scrollLeft: container.scrollLeft() - 200 }, 300);
                 $('.scroll-arrow-left').css('opacity', '0');
                  $('.scroll-arrow-right').css('opacity', '1');
            });
        });
    </script>
</body>
</html>
