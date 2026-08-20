<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="https://demo.shadow-themes.com/html/bringer/css/config.css">
    <!-- Libraries -->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/libs.css')}}">
    <!-- Template Styles -->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <!-- Responsive -->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.3.0-beta.4/css/lightgallery-bundle.min.css">

<style>

    .hide_on_laptop
    {
        display: none !important
    }

    .hide_on_mobile
    {
        display: block !important
    }

    @media screen and (max-width: 600px) {
        .bringer-slider-media img 
        {
            height: 50% !important;
            margin-top:40%
        }


        .hide_on_laptop
        {
            display: block !important
        }

        .hide_on_mobile
        {
            display: none !important
        }

        body.bringer-fullscreen-page
        {
            overflow-y:scroll !important;
        }

    }


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
  
    </style>
@include('includes.analytics')
</head>
<body class="bringer-fullscreen-page no-header-border no-footer-border disable-smooth-scroll">

     <!-- Header -->
     <header id="bringer-header" class="is-frosted is-sticky" data-appear="fade-down" data-unload="fade-up">
        <!-- Desktop Header -->
        <div class="bringer-header-inner">
            <!-- Header Logo -->
            <div class="bringer-header-lp">
                <a href="index.php" class="bringer-logo">
                    <img src="{{asset('assets/image/icon/logo.PNG')}}" alt="Logo" width="88" height="24">
                </a>
            </div>
            <!-- Main Menu -->
            <div class="bringer-header-mp">
                <nav class="bringer-nav">
                    <ul class="main-menu" data-stagger-appear="fade-down" data-stagger-delay="75">
                        <li class="current-menu-parent">
                            <a href="{{route('index')}}">Home</a>
                        </li>
                        <li>
                            <a href="{{route('about')}}">About Us</a>
                        </li>
                        <!-- <li>
                            <a href="events.php">Past Events</a>
                        </li> -->

                        <li>
                            <a href="{{route('showcase')}}">Showcase</a>
                        </li>
                        <li >
                            <a href="#">Gallery</a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="{{route('photo_gallery')}}">Photo Gallery</a>
                                </li>
                                <li>
                                    <a href="{{route('video_gallery')}}">Video Gallery</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{route('contact')}}">Contact us</a>
                        </li>

                        {{-- <li class="hide_on_desktop " >
                            <a href="events.php" class="bringer-button">Book Ticket</a>
                        </li> --}}
                    </ul>
                </nav>
            </div>
            <!-- Header Button -->
            <div class="bringer-header-rp">
                <a href="events.php" class="bringer-button">Book Ticket</a>
            </div>
            
        </div>
        

            <!-- Mobile Header -->
        <div class="bringer-mobile-header-inner">
            <a href="index.php" class="bringer-logo">
                <img src="assets/image/icon/logo.PNG" alt="bringer." width="88" height="24">
            </a>

             <a href="events.php" class="bringer-button " style="font-size:18px; padding:12px; font-weight:600">Book Ticket</a>

            <a href="#" class="bringer-mobile-menu-toggler">
                <i class="bringer-menu-toggler-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </i>
            </a>
        </div>
    </header>


<main id="bringer-main" style="background-color: black;min-height:600px;" class="hide_on_mobile">
    <!-- Slider Container -->
    <div class="bringer-slider-wrapper">
        <!-- Slider -->
        <div class="swiper bringer-slider" data-duration="800" data-effect="slide">
            <div class="swiper-wrapper">

                <!-- Slider Item 01 -->
                <div class="swiper-slide">
                    <img class="bringer-lazy" src="{{asset('assets/img/null.png')}}" data-src="{{asset('assets/img/ops_gallery/indrajal.jpg')}}" alt="" width="1920" height="1280">
                    <div class="bringer-slide-content">
                        <div class="bringer-slide-cRAJAontent-inner bringer-slide-post-title">
                            <span class="bringer-meta">SHOWCASE</span>
                            <h4>INDLRJAL</h4>
                        </div>
                    </div>
                </div>
                                    
                <div class="swiper-slide">
                    <img class="bringer-lazy" src="{{asset('assets/img/null.png')}}" data-src="{{asset('assets/img/ops_gallery/group.jpg')}}" alt="" width="1920" height="1280">
                    <div class="bringer-slide-content">
                        <div class="bringer-slide-content-inner bringer-slide-post-title">
                            <span class="bringer-meta">SHOWCASE</span>
                            <h4>GROUP</h4>
                        </div>
                    </div>
                </div>


                <div class="swiper-slide">
                    <img class="bringer-lazy" src="{{asset('assets/img/null.png')}}" data-src="{{asset('assets/img/ops_gallery/show3.jpg')}}" alt="" width="1920" height="1280">
                    <div class="bringer-slide-content">
                        <div class="bringer-slide-content-inner bringer-slide-post-title">
                            <span class="bringer-meta">SHOWCASE</span>
                            <h4>GROUP</h4>
                        </div>
                    </div>
                </div>


                <div class="swiper-slide">
                    <img class="bringer-lazy" src="{{asset('assets/img/null.png')}}" data-src="{{asset('assets/img/ops_gallery/show4.jpg')}}" alt="" width="1920" height="1280">
                    <div class="bringer-slide-content">
                        <div class="bringer-slide-content-inner bringer-slide-post-title">
                            <span class="bringer-meta">SHOWCASE</span>
                            <h4>GROUP</h4>
                        </div>
                    </div>
                </div>
                                    
            
             
              

            </div>
        </div><!-- .bringer-slider -->
        <!-- Slider Navigation -->
        <div class="bringer-slider-nav on-sides">
            <a href="#" class="bringer-slider-prev">
                <span class="bringer-icon bringer-icon-arrow-left"></span>
            </a>
            <a href="#" class="bringer-slider-next">
                <span class="bringer-icon bringer-icon-arrow-right"></span>
            </a>
        </div>
    </div>
</main>

 <main id="bringer-main2" style="background-color: black;" class="hide_on_laptop">
        <div class="stg-container">
             <section style=" padding-top:40px;">
                <div class="bringer-cta-form-title"  style="text-align:center; padding:40px 0px 40px 0px; font-size:38px " data-split-appear="fade-up" data-split-delay="200" data-split-by="line">Showcase</div>
                <div class="" >
                <div class="bringer-grid-4cols align-center" id="gallery-container">
                        <a href="{{asset('assets/img/ops_gallery/indrajal.jpg')}}">
                            <img src="{{asset('assets/img/ops_gallery/indrajal.jpg')}}" alt="Showcase 1">
                        </a>
                        <a href="{{asset('assets/img/ops_gallery/group.jpg')}}">
                            <img src="{{asset('assets/img/ops_gallery/group.jpg')}}" alt="Showcase 2">
                        </a>
                      
                        <a href="{{asset('assets/img/ops_gallery/show3.jpg')}}">
                            <img src="{{asset('assets/img/ops_gallery/show3.jpg')}}" alt="Showcase 3">
                        </a>

                        <a href="{{asset('assets/img/ops_gallery/show4.jpg')}}">
                            <img src="{{asset('assets/img/ops_gallery/show4.jpg')}}" alt="Showcase 4">
                        </a>

                        

                    </div>
                </div>
            </section>
        </div>
    </main>


<script src="https://demo.shadow-themes.com/html/bringer/js/lib/jquery.min.js"></script>
<script src="https://demo.shadow-themes.com/html/bringer/js/lib/libs.js"></script>
<script src="https://demo.shadow-themes.com/html/bringer/js/contact_form.js"></script>
<script src="https://demo.shadow-themes.com/html/bringer/js/st-core.js"></script>
<script src="https://demo.shadow-themes.com/html/bringer/js/classes.js"></script>
<script src="https://demo.shadow-themes.com/html/bringer/js/main.js"></script>

<script type="module">
    import lightGallery from "https://cdn.skypack.dev/lightgallery@2.3.0-beta.4";

    lightGallery(document.getElementById("gallery-container"), {
        speed: 500
    });
</script>


</body>
</html>
