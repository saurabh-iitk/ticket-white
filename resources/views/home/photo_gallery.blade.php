@extends('layouts.app')
@section('style')

<Style>
    .bringer-portfolio-card-title h6 
    {
        font-size: 20px;
        color:white !important
    }

    .bringer-portfolio-card-image {
    border-radius: 0px !important;
    padding: 0 !important;
    margin: 0 !important;
    height: auto;
}

    </style>
    <!-- Page Main -->

@endsection

@section('main_content')
    <main id="bringer-main" style="background-color: black;">
        <div class="stg-container">
            <section class="backlight-bottom" style=" padding-bottom:20px">
                <div class="stg-row stg-bottom-gap-l py-4" style="border-radius:18px;">
                    <div class="stg-col-6 stg-offset-3 align-center">
                        <div class="bringer-cta-form-title" data-split-appear="fade-up" data-split-delay="200" data-split-by="line">
                            Photo Gallery
                        </div>
                        <Br>
                        <p class="bringer-large-text" data-appear="fade-up" data-delay="400" data-unload="fade-up">Step into a spellbinding world where each image conjures wonder and mystery, capturing the magic of our extraordinary creations.</p>
                    </div>
                </div>
            </section>


         <!-- Section: Grid -->
         <section style="padding-top:0px">
                <!-- Portfolio Grid -->
                <div class="bringer-grid-3cols bringer-tp-grid-2cols bringer-tp-centered-last-item stg-normal-gap bringer-parallax-media" data-stagger-appear="fade-up" data-threshold="1" data-stagger-delay="150" data-stagger-unload="fade-up">
                    
                    @foreach($photo_gallery as $single)
                    <div class="bringer-block bringer-portfolio-card">
                        <div class="bringer-portfolio-card-image">
                            <img class="bringer-lazy" src="{{asset('assets/img/null.png')}}" data-src="{{ asset('images/' . $single->cover_img) }}"  alt="" width="1200" height="1200">
                        </div>
                        <div class="bringer-portfolio-card-footer">
                            <div class="bringer-portfolio-card-title">
                                <span class="bringer-meta">PHOTOS</span>
                                <h6>{{$single->name}}</h6>
                            </div>
                            <span class="bringer-icon bringer-icon-explore"></span>
                        </div>
                        <a href="{{ route('photo_gallery2', ['id' => $single->id]) }}"></a>
                    </div>
                    @endforeach         
                  
                   
                                        
                 

                </div><!-- .bringer-grid -->
            </section>
        </div>
        <!-- .stg-container -->
@endsection