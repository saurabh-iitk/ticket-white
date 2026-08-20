
    <!-- Header -->
    <header id="bringer-header" class="is-frosted is-sticky" data-appear="fade-down" data-unload="fade-up">
        <!-- Desktop Header -->
        <div class="bringer-header-inner">
            <!-- Header Logo -->
            <div class="bringer-header-lp">
                <a href="{{route('index')}}" class="bringer-logo">
                    <img src="{{asset('assets/image/icon/logo.png')}}" alt="Magician OP Sharma." width="88" height="24">
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

                        <li class="hide_on_desktop " >
                            <a href="{{route('book_ticket')}}" class="bringer-button book-ticket-link">Book Ticket</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- Header Button -->
            <div class="bringer-header-rp">
                <a href="{{route('events')}}" class="bringer-button book-ticket-link"  >Book Ticket</a>
            </div>
            
        </div>
        

            <!-- Mobile Header -->
        <div class="bringer-mobile-header-inner">
            <a href="{{route('index')}}" class="bringer-logo">
                <img src="{{asset('assets/image/icon/logo.png')}}" alt="bringer." width="88" height="24">
            </a>

             <a href="{{route('events')}}" class="bringer-button book-ticket-link " style="font-size:18px; padding:12px; font-weight:600">Book Ticket</a>

            <a href="#" class="bringer-mobile-menu-toggler">
                <i class="bringer-menu-toggler-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </i>
            </a>
        </div>
    </header>