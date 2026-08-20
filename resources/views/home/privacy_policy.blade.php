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
                        <div class="bringer-cta-form-title" data-split-appear="fade-up" data-split-delay="200" data-split-by="line">Privacy Policy    </div>
                       
                    </div>
                </div>
            </section>

            <!-- Section: About Me -->
            <section class="backlight-top divider-bottom" style="margin-top:0px; padding-top:40px">
                <div class="row">
            <div class="col-lg-12">
                <div class="card-body d-flex flex-column h-100 px-0 text-white">
                    <h3>Privacy and Security</h3>
                    <p> At Prakash Magico, we are deeply committed to protecting your privacy. The information
                        we collect about you is the very minimum needed to process your orders and to provide
                        you with a more personalized, quick, and convenient shopping experience. There are
                        more details about your privacy at Prakash Magico below. What kinds of information do
                        we collect and how do we use it? To process your ticket purchase and to notify you
                        of your order status, we need to know your name, e-mail address, credit card number,
                        and expiration date. We make every effort to save you time and make your shopping
                        experience more convenient by using your orders and your stated preferences to make
                        recommendations about the items that might be of interest to you. We are also constantly
                        seeking to improve the layout and operation of Prakash Magico based on the areas people
                        visit, enjoy, and use most. We may occasionally wish to notify you about important
                        changes to Prakash Magico, new services, and special offers we think you might find valuable
                    </p>
                    </p>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card-body d-flex flex-column h-100 px-0 text-white">
                    <h3><a class="text-white mb-5" href="#">How does Prakash Magico protect the information we
                            collect?</a></h3>
                    <p> When you place orders, the information is sent via a secure connection which protects
                        all the information you send to us so that it cannot be read as it travels over
                        the Internet. Once your information arrives safely at Prakash Magico, it is carefully
                        stored and protected against unauthorized access
                    </p>
                    <p>For all our transactions, we employ reasonable and current Internet security methods
                        and technologies. Where appropriate, we password protect, use encryption techniques
                        and install firewalls. We strive to protect your privacy. We encourage our participating
                        service providers to adopt and honor their own consumer privacy policies. For all
                        our efforts to safeguard your privacy however, no system can be guaranteed. We cannot
                        ensure or warrant the security of any information that you transmit to us, or that
                        we transmit to you, or guarantee that it will be free from unauthorized access by
                        third parties. Once we receive your information, we use reasonable efforts to ensure
                        its security on our systems. At Prakash Magico we take great care and use the latest
                        technologies to ensure the security and safety of all your transactions with JP
                        Event. We use Secure Sockets Layer (SSL 40-bit to 128-bit based on your browsers
                        capabilities) encryption technology, the industry standard, to scramble and protect
                        your credit card information as it travels over the Internet. This encryption ensures
                        the safety and confidentiality of your information in transit</p>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card-body d-flex flex-column h-100 px-0 text-white">
                    <h3><a class=" mb-5" href="#"> What about "cookies"?</a></h3>
                    <p> Cookies are small pieces of information that are stored by your browser on your
                        computer. We added this optional feature to enable you to order more quickly. Cookies
                        are not required in order for you to purchase tickets at Prakash Magico, however they
                        do enhance the user experience by storing your ZIP Code information to expedite
                        the process of finding the events you want to see in your area. In addition, most
                        Web browsers can automatically store cookies on your computer, but you can usually
                        change your browser to prevent it. We guarantee that whatever you decide about cookies
                        and/or the convenience features we offer, you will always be able to browse and
                        order from Prakash Magico quickly and easily
                    </p>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card-body d-flex flex-column h-100 px-0 text-white">
                    <h3><a class=" mb-5" href="#"> Does Prakash Magico share the information it collects
                            with others?</a></h3>
                    <p> Prakash Magico do not sell, trade, or rent your personal information to outside parties.
                        If we were to decide to do so with reputable third parties in the future, we would
                        ask you first for your permission to do so. Our only motivation for sharing information
                        with reputable third parties would be to provide you with more and better services
                        and opportunities. Prakash Magico may provide combined, general statistics about our
                        customers, sales, usage patterns, and related information to reputable third parties,
                        but these statistics will include no personal identifying information
                    </p>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card-body d-flex flex-column h-100 px-0 text-white ">
                    <h3><a class=" mb-5" href="#"> Consent</a></h3>
                    <p> By purchasing tickets at Prakash Magico, you consent to the collection and use of this
                        information by Prakash Magico
                    </p>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card-body d-flex flex-column h-100 px-0 text-white">
                    <h3><a class=" mb-5" href="#"> Changes to this Privacy Policy</a></h3>
                    <p> Prakash Magico reserves the right to change or modify this Privacy Policy in its discretion
                        at any time without notice to the users of our site, except that Prakash Magico will
                        post the changed or modified Privacy Policy on our site as soon as practicable as
                        such changes or modifications are implemented
                    </p>

                </div>
            </div>
            <div class="col-lg-12">
                <div class="card-body d-flex flex-column h-100 px-0 text-white">
                    <h3><a class=" mb-5" href="#"> Accessing, changing or deleting your information</a></h3>
                    <p> As part of your use of our site, you are responsible for maintaining and updating,
                        as applicable, your account Registration Data with current, accurate and complete
                        information. You may view, update and/or edit the Registration Data you have provided
                        to Prakash Magico by logging in to your account and following the appropriate instructions
                    </p>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card-body d-flex flex-column h-100 px-0 text-white">
                    <h3><a class=" mb-5" href="#">Choices you have regarding the collection, use and
                            distribution of your information</a></h3>
                    <p> Upon registering on the site, you will be given an opportunity to "opt out" of the
                        Prakash Magico mailing list by "checking" a box in the registration form. If you submit
                        the registration form without the box checked, you thereby consent to being placed
                        on this mailing list. You may subsequently contact us to request to be removed from
                        this list. In every update that we send, we will include an option to discontinue
                        receipt of future updates. Prakash Magico reserves the right to limit any registrations
                        on our site to those who will accept our information and to those who will provide
                        the requested information
                    </p>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card-body d-flex flex-column h-100 px-0 text-white">
                    <h3><a class=" mb-5" href="#"> REFUND</a></h3>
                    <p> Once tickets are purchased on Prakash Magico, there are no refunds or changes available.
                        Please confirm your showtime carefully before purchasing your tickets. Because your
                        seat is guaranteed for the entire showing of a event, we are not able to offer
                        refunds. In the rare situations when a show is cancelled, you will be entitled to
                        a refund for the full purchase price of your tickets including any service charges.
                        In these situations please send an email to info@nilakshinfotech.in and include the
                        Venue, Date, showtime, email address and your confirmation number .
                    </p>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card-body d-flex flex-column h-100 px-0 text-white">
                    <h3><a class=" mb-5" href="#"> Can I cancel the tickets if wrongly booked?</a></h3>
                    <p> We suggest the customers to check the booking details before making the payment.
                        Once booked, it cannot be canceled or refunded. The booking is valid only for the
                        viewing of the event at a specified Audi for which it is booked. The booking
                        shall become valueless and non-refundable if not used on the date specified on its
                        face.
                    </p>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card-body d-flex flex-column h-100 px-0 text-white">
                    <h3><a class=" mb-5" href="#">Are there any circumstances in which tickets can be
                            canceled.</a></h3>
                    <p> The booking shall be deemed to be cancelled in the following circumstances:-
                    </p>
                    <ul style="list-style: disc;">
                        <li>If, in the opinion of a Event representative, the user is in breach of these Online
                            Booking Terms or is under the influence of drugs or alcohol, or that it is necessary
                            for the safety or comfort or security of other customers or for the protection of
                            property, the Event representative reserves the right to refuse the entry or request
                            the Customer to leave the Audi and may if necessary physically remove the Customer
                            from the Audi or physically restrain the Customer. </li>
                        <li>Prakash Magico is required to abide by and enforce the age restrictions as specified by
                            the Law for the time being in force. In the event that an authorized Event representative
                            is of the opinion that the user does not meet the minimum age requirement and the
                            user cannot provide photographic proof that they are of the required age, Prakash Magico
                            will not permit entry to that performance or event. </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card-body d-flex flex-column h-100 px-0 text-white">
                    <h3><a class=" mb-5" href="#"> What else you should know about your online privacy</a>
                    </h3>
                    <p> Prakash Magico may also contain links to other web sites and advertising. The privacy
                        policies of those web sites and advertisers may significantly differ from that of
                        our site, and Prakash Magico is not responsible for the privacy practices or the content
                        of such web sites or for the privacy policies and practices of other third parties.
                        It is your responsibility to contact such web site operator or advertiser directly
                        to determine their privacy policy
                    </p>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card-body d-flex flex-column h-100 px-0 text-white">
                    <h3><a class=" mb-5" href="#"> Changes to this Privacy Policy</a></h3>
                    <p> Prakash Magico reserves the right to change or modify this Privacy Policy in its discretion
                        at any time without notice to the users of our site, except that Prakash Magico will
                        post the changed or modified Privacy Policy on our site as soon as practicable as
                        such changes or modifications are implemented

                    </p>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card-body d-flex flex-column h-100 px-0 text-white">
                    <h3><a class=" mb-5" href="#"> Summary</a></h3>
                    <p> At Prakash Magico, we respect your privacy and are fundamentally committed to helping
                        to protect it. We use the information we collect responsibly, to make purchasing
                        tickets at Prakash Magico possible, and to improve your overall experience. We do not
                        sell, trade, or rent your personal information to others. We may choose to do so
                        in the future with trustworthy third parties, but only with your permission.
                    </p>
                </div>
            </div>
            
             
            <div class="col-lg-12">
                <div class="card-body d-flex flex-column h-100 px-0  text-white">
                    <h3><a class=" mb-5" href="#"> Data Deletion Request</a></h3>
                    <p>If you would like to permanently delete all personal data from our system, you can submit a request through the designated form available <a href="https://forms.gle/qUqbBrzZtFDhgFsn7" target="_blank"> here </a>. Upon receiving your request, we will remove your data within 2-4 business days.<Br>
                        Please ensure the information provided in the form is accurate to facilitate the deletion process. You will receive an email notification when the data deletion process begins.
                    </p>
                </div>
            </div>
            

        </div>
            </section>
        </div><!-- .stg-container -->
@endsection