@extends('layouts.app')
@section('style')
@include('includes.analytics')
 
<style>
    section.backlight-bottom,
section.backlight-both::after {
    background: radial-gradient( 100vw circle at 50vw 100%, #1f2225, transparent 30% );
}

.show_on_mobile
{
    display:none !important;
}

.backlight-top
{
    padding-top:50px;
    padding-bottom:50px;
}


@media screen and (max-width: 600px) {
    .show_on_mobile
    {
        display:block !important;
    }

    .hide_on_mobile
    {
        display:none !important;
    }

    .bringer-bento-grid-mobile
    {
        grid-auto-flow: row !important;
    }


}
</style>
@endsection

@section('main_content')
    <!-- Page Main -->
    <main id="bringer-main" style="background-color: black">
        <div class="stg-container">
            <section class="backlight-bottom">
                <div class="stg-row stg-bottom-gap-l py-4" style="border-radius:18px;">
                    <div class="stg-col-6 stg-offset-3 align-center">
                        <div class="bringer-cta-form-title" data-split-appear="fade-up" data-split-delay="200" data-split-by="line">
                            About Us
                        </div>
                        <Br>
                        <p class="bringer-large-text" data-appear="fade-up" data-delay="400" data-unload="fade-up">We are Prakash Magico, India's leading magic show organizer, having successfully hosted over 41,000 shows across multiple states nationwide.</p>
                    </div>
                </div>
            </section>

            <!-- Section: About Me -->
            <section class="backlight-top divider-bottom" style="margin-top:0px; padding-top:40px">
                <div class="stg-row stg-large-gap stg-m-normal-gap">

                    <div class="stg-col-6 stg-tp-bottom-gap-l stg-m-bottom-gap show_on_mobile" data-appear="fade-right" data-unload="fade-left">
                        <div class="">
                            <img class="bringer-lazy" src="{{asset('assets/img/null.png')}}" data-src="{{asset('assets/img/home/pose3.png')}}" alt="About Me" width="1200" height="1200">
                        </div>
                    </div>


                    <div class="stg-col-6 stg-vertical-space-between " data-appear="fade-left" data-unload="fade-right" style="margin-top:80px">
                        <div>
                            <h2 style="color:white">Magician OP Sharma (Jr.)</h2>
                          
                       




                          
                                <p style="color:white;  text-align:justify"> Magician O.P. Sharma Jr. is one of India’s most celebrated illusionists, known for blending traditional Indian magic with modern stage illusions to create unforgettable experiences for audiences. Born into the world of magic as the son of the legendary Magician O.P. Sharma, he inherited not just the art, but also the passion and dedication to keep the flame of wonder alive.
                                From a young age, O.P. Sharma Jr. was fascinated by the craft of illusion. Under the mentorship of his father, he learned the secrets of stagecraft, audience engagement, and showmanship. Over the years, he has developed his own signature style — combining grand illusions, comedy, drama, and storytelling to create a wholesome entertainment package suitable for all age groups.
                               

                            </p>
                            
                            
                              <p style="color:white;  text-align:justify">
                            O.P. Sharma Jr.’s performances are a perfect fusion of suspense, humour, and wonder. His acts often involve elaborate props, creative storytelling, and audience participation — making every spectator feel like a part of the magic. Whether it’s making a person vanish, reading minds, or performing dangerous escapes, his shows are packed with moments that leave audiences gasping in surprise.
                            Carrying forward the illustrious name of his father, O.P. Sharma Jr. has become a cultural icon in the world of Indian stage magic. Fondly known as “Shahenshah-e-Jadoo” (The Emperor of Magic), he continues to tour across cities, drawing massive crowds and inspiring a new generation to appreciate the art of illusion. For over three decades, Magician O.P. Sharma Jr. has proven that magic is not just tricks — it’s an experience, an emotion, and a moment of childlike wonder brought to life. His mission is simple yet powerful: to make people forget their worries for a while, and take them on a journey into the impossible.

                            </p>
                        </div>
                    </div>

                    <div class="stg-col-6 stg-tp-bottom-gap-l stg-m-bottom-gap hide_on_mobile" data-appear="fade-right" data-unload="fade-left" style="margin-top:30px">
                        <div class="">
                            <img class="bringer-lazy" src="{{asset('assets/img/null.png')}}" data-src="{{asset('assets/img/home/pose3.png')}}" alt="About Me" width="1200" height="1200">
                        </div>
                    </div>


                     
                </div>
            </section>



            <!-- Section: About Me -->
            <section class="backlight-top divider-bottom">
                <div class="stg-row stg-large-gap stg-m-normal-gap">
                    

                    <div class="stg-col-6 stg-tp-bottom-gap-l stg-m-bottom-gap " data-appear="fade-right" data-unload="fade-left">
                        <div class="">
                            <img class="bringer-lazy" src="{{asset('assets/img/null.png')}}" data-src="{{asset('assets/img/inner-pages/about-me-02.jpg')}}" alt="About Me" width="1200" height="1200">
                        </div>
                    </div>


                    <div class="stg-col-6 stg-vertical-space-between" data-appear="fade-left" data-unload="fade-right">
                        <div>
                            <h2 style="color: white;font-size:30px">Brief summary: O.P. Sharma (Jr.)</h2>
                            <p style="color: white;text-align:justify">Magician O.P. Sharma's son, Satya Prakash Sharma. Satya Prakash Sharma has been helping his father with magic since childhood. He continues to bring new life to magic tricks by being involved in all of his father's creative inventions. The credit for giving a professional form to the art of magic goes to Satya Prakash Sharma, i.e., O.P. Sharma Junior. He revitalized the art of magic, which was once considered dull and cumbersome, by incorporating modern lighting and digital sound.</p>
                            
                            <p style="color: white;text-align:justify">Magician O.P. Sharma Jr. has been active on the magic stage for more than 45 years and has been performing professionally for more than 30 years. Today, he is an inspiration for the youth. Seeing him, many young people have made magic their profession and are now climbing the stairs of success by following in his footsteps. Magician O.P. Sharma Jr.'s aim is to bring India's gift to the world, the art of magic, back to its glorious position. </p>
                            
                            
                            <p style="color: white;text-align:justify">The grandeur of Magician O.P. Sharma Jr.'s show can be gauged by the fact that more than 100 artists work in his team, including more than a dozen women. For the magic show, over 200 tonnes of equipment are transported in more than 10 trucks. O.P. Sharma Jr., who followed in his father's footsteps and enriched the magic, has been honoured with the Gold Medal and the title of "Magic Prince" by the Indian Magic Media Circle. Additionally, the Magic Book of Records awarded him the "Honorary Doctorate Award 2022" for his contribution to the field of Magic and Management. The Magic Education Institute has conferred upon him the "Jadu Shiromani Award," and the Magic Academy of India has given him the "Jadu Gaurav" title.</p>
                            
                            
                            
                            
                            
                            <p style="color: white;text-align:justify">Throughout five decades, Sharma drenched magic in fairs and exhibitions. His inexhaustible store of entertainment has spread its fragrance in many countries.</p>
                        </div>
                    </div>

                    
                </div>
            </section>



            <!-- Section: Page Title -->
            <section style="color: white; padding-top:20px; padding-bottom:20px; margin-bottom:0px">
                <div class="is-large show_on_mobile" data-appear="fade-left" data-delay="200" data-unload="fade-right">
                    <img class="bringer-lazy" src="{{asset('assets/img/null.png')}}" data-src="{{asset('assets/img/inner-pages/about-me-01.jpg')}}" alt="Cookie Dough" width="1200" height="1200">
                </div>

                <div class="bringer-bento-grid bringer-bento-grid-mobile">
                    <div class="is-medium bringer-block stg-vertical-space-between" data-appear="fade-right" data-unload="fade-left">
                        <div class="bringer-title-with-label ">
                            <span class="bringer-label">Who am I? I am</span>
                            <h2>Magician OP Sharma (Jr.)</h2>
                        </div> 
                        <p class="bringer-large-text" style="text-align:justify">A renowned Indian magician known for grand stage illusions, innovative tricks, and captivating live shows across the country.</p>
                    </div>
                    <div class="is-small" data-appear="zoom-out" data-delay="100" data-unload="zoom-out">
                        <img class="bringer-lazy" src="{{asset('assets/img/null.png')}}" data-src="{{asset('assets/img/portfolio/portfolio03.jpg')}}" alt="Portfolio" width="1200" height="1200">
                    </div>

                    <div class="is-small" data-appear="zoom-out" data-delay="100" data-unload="zoom-out">
                        <img class="bringer-lazy" src="{{asset('assets/img/null.png')}}" data-src="{{asset('assets/img/portfolio/portfolio04.jpg')}}" alt="Portfolio" width="1200" height="1200">
                    </div>
                  
                    <div class="is-large hide_on_mobile" data-appear="fade-left" data-delay="200" data-unload="fade-right">
                        <img class="bringer-lazy" src="{{asset('assets/img/null.png')}}" data-src="{{asset('assets/img/inner-pages/about-me-01.jpg')}}" alt="Cookie Dough" width="1200" height="1200">
                    </div>
                </div>
            </section>

           
        </div><!-- .stg-container -->
@endsection