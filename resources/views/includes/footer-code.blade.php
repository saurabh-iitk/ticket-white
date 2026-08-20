<!--Global JS Script-->
   <script src="{{asset('assets/js/lib/jquery.min.js')}}"></script>
   <script src="{{asset('assets/js/lib/libs.js')}}"></script>
   <script src="{{asset('assets/js/contact_form.js')}}"></script>
   <script src="{{asset('assets/js/st-core.js')}}"></script>
   <script src="{{asset('assets/js/classes.js')}}"></script>
   <script src="{{asset('assets/js/main.js')}}"></script>
   <script src="{{asset('assets/js/jquery.marquee.js')}}"></script>

   <script>

    $(function(){
    $('.de-marquee-list').marquee({
        direction: 'left',
        duration: 50000,
        gap: 0,
        delayBeforeStart: 0,
        duplicated: true,
        startVisible: true
    });
    });
    </script>
<!--Global JS Script-->