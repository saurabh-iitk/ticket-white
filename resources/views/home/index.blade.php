@extends('layouts.app')
@section('style')
<style>
body
{
    background: black;
}
    /* marquee */
.d-flex {
  display: flex;
  white-space: nowrap;
}

.de-marquee-list {
  display: flex;
  align-items: top;
  -webkit-animation: loop 40s infinite linear;
  animation: loop 40s infinite linear;
}

.de-marquee-list .d-item-txt {
  font-size:120px;
  line-height:120px;
  font-style: normal;
  font-weight: bold;
  font-family: var(--marquee-font);
  user-select: none;
  text-transform:uppercase;
}

.de-marquee-list .d-item-txt:nth-child(even){
    -webkit-text-stroke: 1px #fff;
    -webkit-text-fill-color: #000;
}

.dark-scheme .de-marquee-list .d-item-txt:nth-child(even){
    -webkit-text-stroke: 1px #ffffff;
    -webkit-text-fill-color: #000000;
}

.de-marquee-list.s2 .d-item-txt{
   background: -webkit-linear-gradient(0deg,rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, .5) 100%);
  background: -moz-linear-gradient(0deg,rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, .5) 100%);
  background: linear-gradient(0deg,rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, .5) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  -webkit-text-stroke: 0;
}

.de-marquee-list .d-item-txt img{
  width: 80px;
  margin-top: -15px;
  margin-right: 20px;
}

.de-marquee-list .d-item-display {
  display: inline;
}

.de-marquee-list .d-item-block {
  margin: 0;x
  padding: 0px;
  border-radius: 50%;
  display: inline-block;
  transform: translateY(-20px);
  background: #ffffff;
  border-radius:30px;
  -moz-border-radius:30px;
  -webkit-border-radius:30px;
}


.de-marquee-list .d-item-circle {
  width: 30px;
  height: 30px;
  margin: 0 20px;
  margin-right: 30px;
  padding: 0px;
  border-radius: 50%;
  display: inline-block;
  transform: translateY(2px);
  background: var(--secondary-color);
  border-radius:30px;
  -moz-border-radius:30px;
  -webkit-border-radius:30px;
}


.de-marquee-list.s2 .d-item-block{
  height: 5px;
  background: -webkit-linear-gradient(90deg,rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, .5) 100%);
  background: -moz-linear-gradient(90deg,rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, .5) 100%);
  background: linear-gradient(90deg,rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, .5) 100%);
}

.de-marquee-list .d-item-block{
  border-radius: 0;
}

.text-light .de-marquee-list .d-item-dot {
  background: rgba(255, 255, 255, .3);
}

.de-marquee-list.style-2 .d-item-txt {
  font-size: 160px;
  background: rgba(255, 255, 255, .2);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.de-marquee-list.style-2 .d-item-dot {
  transform: translateY(-0px);
  background: rgba(255, 255, 255, .2);
}

.de-marquee-list span {
    line-height: 1.1em !important;
    font-size: 60px;
    font-weight: 900px;
    background: linear-gradient(270deg, blue, purple, pink);
    background-size: 400% 400%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    -webkit-animation: blockbusteranimation 11s ease infinite;
    -moz-animation: blockbusteranimation 11s ease infinite;
    -o-animation: blockbusteranimation 11s ease infinite;
    animation: blockbusteranimation 11s ease infinite;
  }

  .bringer-large-text {
    font-size: var(--bringer-t-large-fs);
    line-height: var(--bringer-t-content-lh);
    color: var(--bringer-s-heading);
}

h3 {
    font-size: var(--bringer-t-h3-fs);
    letter-spacing: var(--bringer-t-h3-ls);
    line-height: var(--bringer-t-h3-lh);
    margin: var(--bringer-t-h3-margin);
}


.bringer-block::before,
.bringer-block::after {
    content: '';
    border-radius: inherit;
    position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
}
.bringer-block::before {
    inset: 0px;
    padding: 1px;
    background: radial-gradient( 800px circle at var(--mouse-x) var(--mouse-y), var(--bringer-s-border-highlight), var(--bringer-s-border-mute) 40% );
    mask: var(--bringer-border-mask);
    -webkit-mask: var(--bringer-border-mask);
    mask-composite: exclude;
    -webkit-mask-composite: xor;
    transition: opacity 0.4s;
    will-change: opacity;
    opacity: 0.75;
}

.bringer-tetimonials-card-descr
{
  font-family: var(--bringer-t-content-ff);
    font-size: var(--bringer-t-content-fs);
    line-height: var(--bringer-t-content-lh);
    letter-spacing: var(--bringer-t-content-ls);
    font-weight: var(--bringer-t-content-fw);
    color: var(--bringer-s-text);
}
h6{
  font-size: var(--bringer-t-h6-fs);
    letter-spacing: var(--bringer-t-h6-ls);
    line-height: var(--bringer-t-h6-lh);
    margin: var(--bringer-t-h6-margin);
  color: white !important
}

.bringer-tetimonials-card {
    display: grid;
    grid-template-rows: subgrid;
    grid-row: span 2;
    row-gap: var(--stg-gap);
}
.bringer-tetimonials-card-descr {
    margin-top: -4px;
}
.bringer-tetimonials-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: -4px;
}
.bringer-tetimonials-card-name h6 {
    margin: 0;
}
[class*='bringer-tetimonials-stars'] {
    display: block;
    position: relative;
    width: 76px;
    height: 12px;
    opacity: 0.5;
    margin-bottom: 8px;
}
[class*='bringer-tetimonials-stars']::before,
[class*='bringer-tetimonials-stars']::after {
    content: '';
    height: 12px;
    background: var(--bringer-s-heading);
    -webkit-mask-repeat: repeat-x;
    -webkit-mask-size: contain;
    -webkit-mask-position: left;
    mask-repeat: repeat-x;
    mask-size: contain;
    mask-position: left;
    position: absolute;
    left: 0;
    top: 0;
}
[class*='bringer-tetimonials-stars']::before {
    -webkit-mask-image: var(--icon-star-empty);
    mask-image: var(--icon-star-empty);
    z-index: 1;
    width: 100%;
}
[class*='bringer-tetimonials-stars']::after {
    -webkit-mask-image: var(--icon-star-full);
    mask-image: var(--icon-star-full);
    z-index: 3;
}
.bringer-tetimonials-stars1::after {
    width: 20%;
}
.bringer-tetimonials-stars2::after {
    width: 40%;
}
.bringer-tetimonials-stars3::after {
    width: 60%;
}
.bringer-tetimonials-stars4::after {
    width: 80%;
}
.bringer-tetimonials-stars5::after {
    width: 100%;
}

.bringer-block::before {
    inset: 0px;
    padding: 1px;
    background: radial-gradient( 800px circle at var(--mouse-x) var(--mouse-y), var(--bringer-s-border-highlight), var(--bringer-s-border-mute) 40% );
    mask: var(--bringer-border-mask);
    -webkit-mask: var(--bringer-border-mask);
    mask-composite: exclude;
    -webkit-mask-composite: xor;
    transition: opacity 0.4s;
    will-change: opacity;
    opacity: 0.75;
}
.counter_box .bringer-block
{
    background:  none;
    /* border-color: red; */
}
.bringer-partners .bringer-block 
{
width: 140px;
}
.bringer-counter-label
{
color:white;
font-size:19px
}

.bringer-partners .bringer-block {
    padding: 0;
    border-radius: 0 !important;
    border: none black;
    background-color: black;
    align-items: center;
    margin: 0 auto;
}

.bringer-partners .bringer-block img {
    border-radius: 0 !important;
}


  @media only screen and (max-width: 600px) {
        #slider
        {
            padding-bottom:0px !important
        }
    }

    .bringer-header-rp .bringer-button:hover{
        color:white !important;
        text-decoration:none !important;
    }
    section {
        width:100%;
    }
    
    
    .brand_banner
    {
        margin-top: 20px;
         background: black;
    }
    
    .brand_banner2
    {
       display:none;
        background: black !important;
    }

    #slider{
        padding-top:70px;
    }
     @media only screen and (max-width: 768px)
     {
       .brand_banner
        {
           display:none;
        }
        
        .brand_banner2
        {
           display: block;
            padding-top: 68px;
            background: black !important;
        }
        
        #slider{
        padding-top:0px;
         background: black;
    }
        
    }
</style>
@endsection

@section('main_content')

        <!--<div class="swiper-slide brand_banner2"   data-appear="fade-down" data-delay="10">-->
        <!--    <img src="{{ asset('home/jupiter.jpg') }}" alt="Team of Magician OP Sharma (Jr.)" width="1920" height="1080" style="text-align:center; margin: 0 auto;  ">-->
        <!--</div>-->
        
    <section style="background:black;" id="slider">
        <iframe src="{{asset('slider/index.html')}}" scrolling="no"></iframe>
        <!--<div class="swiper-slide brand_banner" >-->
        <!--    <img src="{{ asset('home/jupiter.jpg') }}" alt="Team of Magician OP Sharma (Jr.)" width="1920" height="1080" style="text-align:center; margin: 0 auto;  ">-->
        <!--</div>-->
    </section>


 
    <section class="backlight-bottom" style="background-color: black; padding:1px 20px 10px 20px; margin-top:-80px ">
        <div class="stg-row stg-bottom-gap-l" style="border-radius:18px;">
            <div class="stg-col-8 stg-offset-2 align-center" style="text-align: center;justify-content:center;align-items: center;">
                <div class="bringer-cta-form-title" data-split-appear="fade-up" data-split-delay="200" data-split-by="line">
                Welcome to
                </div>

                <div class="bringer-cta-form-title" data-split-appear="fade-up" data-split-delay="5000" data-split-by="line">
                Magician OP Sharma (Jr.)
                </div>
                <Br>
                <p class="bringer-large-text" data-appear="fade-up" data-delay="400" data-unload="fade-up">We are Prakash Magico, India's leading magic show organizer, having successfully hosted over 40,000 shows across multiple states nationwide.</p>
            </div>
        </div>
    </section>

    <section class="backlight-bottom" style="background-color: black; padding:00px 20px 20px 20px  ">
        
        
            <!-- Slider -->
        <div class="bringer-slider-wrapper stg-bottom-gap" data-appear="fade-up" data-delay="200" data-unload="fade-up">
            <div class="swiper bringer-slider" data-autoplay="2000" data-duration="800" data-effect="slide">
                <div class="swiper-wrapper">
                    <!-- Slider Item -->
                    <div class="swiper-slide">
                        <img src="{{ asset('assets/img/home/home.jpg') }}" alt="Team of Magician OP Sharma (Jr.)" width="1920" height="1080" style="text-align:center; margin: 0 auto;  ">
                    </div>
                    
                    
                   
                    
                </div>
            </div>
            <!-- .bringer-slider -->
        </div>
        
        
    </section>
   
    <section class="text-light no-top" style="background:black ; padding-top:30px;padding-bottom:30px; overflow-x:hidden">
        <div class="wow fadeInRight d-flex" style="overflow:hidden">
            <div class="de-marquee-list wow">
                <div class="d-item">
                    <span class="d-item-txt"> FAMOUS INDRAJAL </span>
                    <span class="d-item-txt"> DIANSOURS </span>
                    <span class="d-item-txt"> STATUE OF LIBERTY </span>
                    <span class="d-item-txt"> THE MUMMY </span>
                    <span class="d-item-txt"> MAGICAL FACE </span>
                    <span class="d-item-txt"> ILLUSION </span>
                </div>
            </div>
        </div>
    </section>

    <section data-padding="bottom" class="backlight-bottom" style="background-color: black; padding:00px 20px 60px 20px  ">
        <div class="bringer-cta-form-title pt-2 pb-5" data-split-appear="fade-up" data-split-delay="200" data-split-by="line" style="text-align:center">
        Magic Numbers
        </div>

        <div class="counter_box  bringer-grid-4cols bringer-tp-grid-2cols bringer-m-grid-2cols stg-m-small-gap" data-stagger-appear="zoom-in" data-stagger-unload="zoom-out">
            <!-- Counter Item -->
            <div class="bringer-counter bringer-block " data-delay="3000">
                <div class="bringer-counter-number" data-suffix="+">200</div>
                <div class="bringer-counter-label">Cities</div>
            </div><!-- .bringer-counter -->
            <!-- Counter Item -->
            <div class="bringer-counter bringer-block " data-delay="3000">
                <div class="bringer-counter-number" data-suffix="">32</div>
                <div class="bringer-counter-label">Awards Won</div>
            </div>
            
            <!-- .bringer-counter -->
            <!-- Counter Item -->
            <div class="bringer-counter bringer-block" data-delay="3000">
                <div class="bringer-counter-number" data-suffix="+">47</div>
                <div class="bringer-counter-label">Years of Performance</div>
            </div><!-- .bringer-counter -->

                <!-- Counter Item -->
                <div class="bringer-counter bringer-block " data-delay="3000">
                <div class="bringer-counter-number" data-suffix="+">41500</div>
                <div class="bringer-counter-label">HouseFull Shows</div>
            </div><!-- .bringer-counter -->
        </div><!-- .bringer-grid -->
    </section>

    <section class="backlight-bottom" style="background-color: black; padding:60px 20px 60px 20px; text-align:center;">
        <div class="container  bringer-hero-block bringer-hero-type08" >
        <div class="bringer-cta-form-title mb-5" data-split-appear="fade-up" data-split-delay="200" data-split-by="line" style="text-align: center;">In News</div>
            <div class="bringer-partners" style="overflow-x:scroll;  scrollbar-width: none;  -ms-overflow-style: none">
                <div class="bringer-grid-6cols bringer-tp-grid-3cols bringer-m-grid-2cols stg-top-gap-s" data-stagger-appear="fade-up" data-stagger-unload="fade-up" data-stagger-delay="100" data-delay="100">
                    <div class="bringer-block">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRLiC9EXQC5eVAnt8zFe21luP_irASzlXme5Q&s" alt="Partner Logo">
                    </div>
                    <div class="bringer-block">
                        <img src="{{asset('assets/img/home/media/jagran.png')}}" alt="Partner Logo">
                    </div>
                    <div class="bringer-block">
                        <img src="{{asset('assets/img/home/media/punjab.png')}}" alt="Partner Logo">
                    </div>
                    <div class="bringer-block">
                        <img src="{{asset('assets/img/home/media/indian.png')}}" alt="Partner Logo">
                    </div>
                    <div class="bringer-block">
                        <img src="{{asset('assets/img/home/media/indiatimes.png')}}" alt="Partner Logo">
                    </div>
                    <div class="bringer-block">
                        <img src="{{asset('assets/img/home/media/toi.png')}}" alt="Partner Logo">
                    </div>
                    <!--<div class="bringer-block">-->
                    <!--    <img src="{{asset('assets/img/home/media/indiatimes.png')}}" alt="Partner Logo">-->
                    <!--</div>-->
                    <!--<div class="bringer-block">-->
                    <!--    <img src="{{asset('assets/img/home/media/toi.png')}}" alt="Partner Logo">-->
                    <!--</div>-->
                    <!--<div class="bringer-block">-->
                    <!--    <img src="{{asset('assets/img/home/media/toi.png')}}" alt="Partner Logo">-->
                    <!--</div>-->
                    <!--<div class="bringer-block">-->
                    <!--    <img src="{{asset('assets/img/home/media/indiatimes.png')}}" alt="Partner Logo">-->
                    <!--</div>-->
                    <!--<div class="bringer-block">-->
                    <!--    <img src="{{asset('assets/img/home/media/toi.png')}}" alt="Partner Logo">-->
                    <!--</div>-->
                    <!--<div class="bringer-block">-->
                    <!--    <img src="{{asset('assets/img/home/media/toi.png')}}" alt="Partner Logo">-->
                    <!--</div>-->
                </div>
            </div>
        </div><!-- .bringer-hero-block -->
    </section>
@endsection
