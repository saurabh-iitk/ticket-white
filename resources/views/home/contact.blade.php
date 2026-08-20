@extends('layouts.app')
@section('style')
@include('includes.analytics')
<style>
    section.backlight-bottom,
section.backlight-both::after {
    background: radial-gradient( 100vw circle at 50vw 100%, #1f2225, transparent 30% );
}

.contact_us h6 
{
    font-size: 16px;
}

.contact_us h5
{
    font-size: 20px;
}

.bb_img
{
    width: 70% !important
}

@media only screen and (max-width: 768px) {
            .bb_img
            {
                width: 100% !important
            }
        }
</style>

@endsection


@section('main_content')
    <!-- Page Main -->
    <main id="bringer-main" style="background-color: black; color: white;">
        <div class="stg-container">
            <!-- Section: Page Title -->
            <section class="backlight-bottom">
                <div class="stg-row stg-bottom-gap-l py-4" style="border-radius:18px;">
                    <div class="stg-col-6 stg-offset-3 align-center">
                        <div class="bringer-cta-form-title" data-split-appear="fade-up" data-split-delay="200" data-split-by="line">
                            Get in Touch
                        </div>
                        <Br>
                        <p class="bringer-large-text" data-appear="fade-up" data-delay="400" data-unload="fade-up">Feel warmly invited to reach out to us through any of the communication channels provided below for any queries, support, bulk booking, or sponsorship inquiries.</p>
                    </div>
                </div>
            </section>
            <!-- Map -->



              <!-- Section: CTA Form -->
            <section class="backlight-top is-fullwidth" style="padding-bottom:30px; padding-top:30px">
                <div class="stg-row stg-valign-middle stg-cta-with-image stg-tp-column-reverse">
                    <div class="stg-col-5" data-unload="fade-left">
                        <div class="bringer-offset-image" data-bg-src="img/cta/contact-section-bg.jpg" data-appear="fade-up" data-threshold="0.25"></div>
                        <form action="#" method="post" class="bringer-contact-form bringer-block" data-fill-error="Please, fill out the contact form." data-appear="fade-right" data-threshold="0.25">
                            <div class="bringer-form-content">
                                <!-- Field: Name -->
                                <label for="name">Your Name</label>
                                <input type="text" id="name" name="name" placeholder="Your Name" required>
                                <!-- Field: Email -->
                                <label for="email">Your Email</label>
                                <input type="email" id="email" name="email" placeholder="Your Email ID" required>  
                                
                                <label for="subject">Subject</label>
                                <input type="text" id="subject" name="subject" placeholder="Your Subject" required>  
                                <!-- Field: Message -->
                                <label for="message">Your Message</label>
                                <textarea id="message" name="message" style="height:120px" placeholder="Your Message" required></textarea>
                                <!-- Form Button -->
                                <button type="submit" value="Send Message">Submit Now</button>
                                <div class="bringer-contact-form__response"></div>
                            </div>
                            <span class="bringer-form-spinner"></span>
                        </form>
                    </div>
                    <div class="stg-col-6 stg-offset-1" data-unload="fade-right">
                        <div class="bringer-cta-form-content">
                            <div class="bringer-cta-form-title" data-split-appear="fade-up" data-split-delay="100" data-split-by="line">
                               Drop your query
                            </div>
                            <div class="bringer-cta-text" style="padding-top:50px;padding-bottom:50px;" >
                                <div class="stg-row stg-valign-top">
                                    <div class="stg-col-12 stg-tp-col-12 stg-m-col-12" data-appear="fade-left">
                                        <p class="bringer-large-text">Our Support Team will respond you within 2-4 working days.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bringer-cta-counters bringer-grid-3cols bringer-m-grid-3cols" data-stagger-appear="fade-up" data-stagger-delay="100">
                                <!-- Counter Item -->
                                <div class="bringer-counter bringer-small-counter" data-delay="3000">
                                    <div class="bringer-counter-number" data-suffix="K+">40</div>
                                    <div class="bringer-counter-label">Housefull Shows</div>
                                </div><!-- .bringer-counter -->
                                <!-- Counter Item -->
                                <div class="bringer-counter bringer-small-counter" data-delay="3000">
                                    <div class="bringer-counter-number" data-suffix="K+">100</div>
                                    <div class="bringer-counter-label">Happy Customers</div>
                                </div><!-- .bringer-counter -->
                                <!-- Counter Item -->
                                <div class="bringer-counter bringer-small-counter" data-delay="3000">
                                    <div class="bringer-counter-number" data-suffix="+">40</div>
                                    <div class="bringer-counter-label">Years in Work</div>
                                </div><!-- .bringer-counter -->
                                
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- Section: Page Title -->
            <section class="backlight-bottom" style="padding-top: 70px ; padding-bottom: 0px ; width:100% ; padding-left:0; padding-right:0;">
                <div  data-parallax-speed="20" data-appear="fade-up" data-delay="200" data-unload="fade-up" >
                    <img class="bringer-lazy bb_img" src="{{asset('assets/img/null.png')}}" data-src="{{asset('assets/img/inner-pages/bhoot-banglow.jpg')}}" alt="Bhoot Banglow"  style="margin: 0 auto;">
                </div><!-- .bringer-parallax-media -->
            </section>

            <section style="margin-top:-60px">
                <!-- Contacts Grid -->
                <div class="stg-row">
                    <div class="stg-col-4 stg-tp-col-6 stg-m-bottom-gap" data-appear="fade-right" data-delay="100" data-unload="fade-left">
                        <!-- Phone -->
                        <div class="contact_us bringer-block stg-aspect-square stg-vertical-space-between">
                            <div>
                            <h5>Address<span class="bringer-accent">.</span></h5>
                            <h6 >Bhoot Banglow, Barra-2, Kanpur,<br>Uttar Pradesh - 208027</h6>

                            <Br> 
                            <h5>Phone<span class="bringer-accent">.</span></h5>
                                <h6>+91-888-2546-585</h6>
                                <Br>

                                <h5>Email<span class="bringer-accent">.</span></h5>
                                <h6>info@magicianopsharma.com</h6>
                                <Br>
                                <h5>Social Media<span class="bringer-accent">.</span></h5>
                                <ul class="bringer-socials-list stg-small-gap" data-stagger-appear="fade-up" data-stagger-delay="75">
                                    <li>
                                        <a href="#" target="_blank" class="bringer-socials-facebook">
                                            <i></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank" class="bringer-socials-instagram">
                                            <i></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank" class="bringer-socials-x">
                                            <i></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank" class="bringer-socials-youtube">
                                            <i></i>
                                        </a>
                                    </li>
                                   
                                </ul>

                             
                            </div>
                        </div>
                    </div>


                    <div class="stg-col-8 stg-tp-col-6" data-appear="fade-left" data-delay="200" data-unload="fade-right">
                        <iframe  style="height:400px" class="bringer-google-map" loading="lazy"   src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d893.1513617748986!2d80.30432731357895!3d26.43246339627142!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMjbCsDI1JzU2LjkiTiA4MMKwMTgnMTguNyJF!5e0!3m2!1sen!2sin!4v1720351189543!5m2!1sen!2sin" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </section>

        </div><!-- .stg-container -->
@endsection