@extends('layouts.app')
@section('style') 

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.3.0-beta.4/css/lightgallery-bundle.min.css">

<Style>
    .bringer-portfolio-card-title h6 
    {
        font-size: 20px;
        color:white !important
    }

    .bringer-lightbox-link > .st-lazy-wrapper, .bringer-lightbox-link > img, .pswp--zoom-allowed .pswp__img
    {
        border-radius: 0 !important;
    }
    .bringer-cta-form-title
    {
        font-size: 50px;
    }
    .bringer-grid-4cols img , .lg-object, .lg-image
    {
        border-radius: 0px;
    }
    .lg-download
    {
        display: none !important;
    }
  
    </style>
    <!-- Page Main -->

@endsection

@section('main_content')
    <main id="bringer-main" style="background-color: black;">
        <div class="stg-container">
             <section style=" padding-top:40px;">
                <div class="bringer-cta-form-title"  style="text-align:center; padding:40px 0px 40px 0px " data-split-appear="fade-up" data-split-delay="200" data-split-by="line">{{$photo_gallery->name}}</div>
                    <div class="bringer-grid-4cols align-center" id="gallery-container">
                        @foreach($photo_content as $single)
                        <a href="{{ asset('images/' . $single->cover_img) }}">
                            <img src="{{ asset('images/' . $single->cover_img) }}" alt="{{$single->name}}">
                        </a>
                        @endforeach  
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection

@section('js')
<script type="module">
    import lightGallery from "https://cdn.skypack.dev/lightgallery@2.3.0-beta.4";
    lightGallery(document.getElementById("gallery-container"), {
        speed: 500
    });
</script>
@endsection