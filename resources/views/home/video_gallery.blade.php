@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.3.0-beta.4/css/lightgallery-bundle.min.css">
<Style>
    .bringer-portfolio-card-title h6 
    {
        font-size: 20px;
        color:white !important
    }


    .gallery-container a {
    width: 600px;
    justify-content: center;
    }

    .gallery-container a img {
    max-width: 100%;
    height: auto;
    }

    </style>
    <!-- Page Main -->
@endsection

@section('main_content')
    <main id="bringer-main" style="background-color: black; padding-bottom:0px">
        <div class="stg-container">
            <section class="backlight-bottom" style=" padding-bottom:20px">
                <div class="stg-row stg-bottom-gap-l py-4" style="border-radius:18px;">
                    <div class="stg-col-6 stg-offset-3 align-center">
                        <div class="bringer-cta-form-title" data-split-appear="fade-up" data-split-delay="200" data-split-by="line">
                            Video Gallery
                        </div>
                        <Br>
                        <p class="bringer-large-text" data-appear="fade-up" data-delay="400" data-unload="fade-up">Dive into a mesmerizing tapestry of moving wonders, where each video unveils the magic behind our extraordinary creations.</p>
                    </div>
                </div>
            </section>


        <section style="padding:40px 0px ; margin:40px 0px ">
            <div data-stagger-appear="fade-up" >
                <div class="bringer-grid-2cols align-center" id="gallery-container">
                    
                    @foreach($video_gallery as $single)
                    <a data-lg-size="1280-720"
                        data-src="https://www.youtube.com/watch?v={{$single->youtube_id}}?autoplay=1"
                        data-poster="https://img.youtube.com/vi/{{$single->youtube_id}}/maxresdefault.jpg"
                        data-sub-html="">
                        <img width="600" height="400" class="img-responsive" src="https://img.youtube.com/vi/{{$single->youtube_id}}/maxresdefault.jpg"/>
                    </a>
                    @endforeach
                    
                </div>
            </div>
        </section>
    </div>
@endsection


@section('js')
<script type="module">
    import lightGallery from "https://cdn.skypack.dev/lightgallery@2.3.0-beta.4";
    import lgVideo from "https://cdn.skypack.dev/lightgallery@2.3.0-beta.4/plugins/video";
    lightGallery(document.getElementById("gallery-container"), {
        speed: 500,
        plugins: [lgVideo]
    });
</script>
@endsection