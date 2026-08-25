<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo env('APP_NAME')?> </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no ">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
       <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset('assets/venue/venue.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        .venue_section
        {
            border-top: 1px solid #f3f3f3 !important;
        }
    </style>
    
   @include('includes.analytics')

<style>

.venue_section
{
    min-height: 53vh !important;
}
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
            .jupiter-banner
            {
                width: 50%;
            }
            
            @media (max-width: 400px) {
               .jupiter-banner
                {
                    width: 80%;
                }
            }
            
             @media (max-width: 600px) {
               .jupiter-banner
                {
                    width: 80%;
                }
            }
            
            @media (max-width: 720px) {
               .jupiter-banner
                {
                    width: 90%;
                }
            }
</style>
</head>

<body style="overflow-x:hidden">
    <header>
        <div class="logo">
            <a href="{{ route('index')}}"><img src="{{asset('assets/venue/logo.png')}}" alt="ops logo" style="height: auto;width: 90px;position: absolute;margin-top: -2px;object-fit: cover;">
            </a>
        </div>
        <div class="header">
            <div class="hder_icon" style="cursor:pointer;" onclick="javascript:history.go(-1)"><img src="{{asset('assets/venue/left.png')}}" alt=""></div>
            <div class="header-title"><?php echo env('APP_NAME')?></div>
            <div class="header-icons">
                <div class="icon"><a href="{{ route('index')}}"><img src="{{asset('assets/venue/close.png')}}" alt="" style="width: 24px;height: 24px;"></a></div>
            </div>
        </div>
    </header>
    <!-- progress bar -->
    <section class="progress_sec">
        <div class="progress-bar">
            <div class="step active">
                <div class="circle"><span>1</div>
                <div class="label">Venue</div>
            </div>
            <div class="step ">
                <div class="circle"><span>2</span></div>
                <div class="label">Date & Time</div>
            </div>
            <div class="step">
                <div class="circle"><span>3</span></div>
                <div class="label">Seats</div>
            </div>
        </div>
    </section>
    <section class="venue_section">
        <div class="venue_event-container">
            <div class="page-header">
                <div class="page-header-icon"><i class="bi bi-geo-alt"></i></div>
                <div>
                    <div class="step-label">Select a venue to continue</div>
                    <div class="step-subtitle">Tap on a venue below to proceed</div>
                </div>
            </div>

            @forelse($events as $index => $event)
                @php
              
                    $event_id = $event->id;
                    $event_data = getEvent($event_id);
                    $event_title = ucwords($event_data->event_title);
                    $city_data = getCity($event_data->city_id);
                    $city_name = strtoupper($city_data->name);
                    $venue_data = getVenue($event_data->venue_id);
                    $venue_name = ucfirst($venue_data->name);
                    $address = ucfirst($venue_data->address);
                    $event_banner = $event_data->event_banner;
                    $openMapLink = data_get($venue_data, 'map');
                @endphp

                <div class="event-card-wrapper">
                    <div class="event-card {{ $index === 0 ? 'recommended-card' : '' }}" onclick="redirect_to('{{ $event_id }}')">
                        @if($index === 0)
                            <span class="badge"><i class="bi bi-star-fill"></i> &nbsp; Recommended</span>
                        @endif
                        <div class="event-card-main">
                            <div class="event-card-info">
                                <div class="event-title">{{ $venue_name }} : {{ $city_name }}</div>
                                <div class="event-address"><i class="fas fa-map-marker-alt"></i> {{ $address }}</div>
                            </div>
                        </div>
                        <div class="event-card-footer">
                            @if($openMapLink)
                                <a href="{{ $openMapLink }}" class="map-link" target="_blank" rel="noopener"><i class="fas fa-map-marker-alt"></i> Open in Maps <i class="bi bi-box-arrow-up-right"></i></a>
                            @endif
                            <button type="button" class="select-button">Select Venue <i class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
                
               
        
            @empty
                <div class="event-card-wrapper">
                    <div class="event-card">
                        <div class="event-card-main">
                            <div class="event-card-info">
                                <div class="event-title">No venues available</div>
                                <div class="event-address">Currently there are no published events to show. Please check back later.</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
            
        
        </div>
    </section>
    
    <!--<div data-appear="fade-down" data-delay="10" style="text-align: center;margin: -60px auto;">-->
    <!--<img src="https://magicianopsharma.co.in/home/jupiter.jpg" alt="Team of Magician OP Sharma (Jr.)" class="jupiter-banner">-->
    <!--</div>-->
</body>

<script type="text/javascript">
    var scheduleUrl = "{{ route('book_ticket') }}";
    function redirect_to(id) {
            posthog.capture('Venue Selected');
            console.log('Venue Selected');
        window.location = scheduleUrl+"?event_id="+id;
    }
    </script>
</html>