<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('settings.seo') }}</title>
    <meta name="seo_description" content="{{ config('settings.seo_description') }}"/>

     <meta name="seo_keywords" content="{{ config('settings.seo_keywords') }}"/>

    <link rel="icon" type="image/png" href="images/favicon.png">
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/venobox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.exzoom.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">


    <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
/>
    <!-- <link rel="stylesheet" href="css/rtl.css"> -->
</head>

<body>
      <!--=============================
       Cart Popup start
    ==============================-->
    <div class="fp__cart_popup">
        <div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body product_load_modal_body">

                    </div>
                </div>
            </div>
        </div>
    </div>
  <!--=============================
         Cart Popup end
    ==============================-->
    {{-- @dd(Cart::content()); --}}
    <!--=============================
        TOPBAR START
    ==============================-->
    @include('frontend.layouts.menu')
    <!--=============================
        TOPBAR END
    ==============================-->


    <!--=============================
        MENU START
    ==============================-->



    <!--=============================
        MENU END
    ==============================-->


    @yield('content')

    <!--=============================
        FOOTER START
    ==============================-->
    @include('frontend.layouts.footer')
    <!--=============================
        FOOTER END
    ==============================-->






    <!--jquery library js-->
    <script src="{{ asset('frontend/js/jquery-3.6.0.min.js') }}"></script>
    <!--bootstrap js-->
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <!--font-awesome js-->
    <script src="{{ asset('frontend/js/Font-Awesome.js') }}"></script>
    <!-- slick slider -->
    <script src="{{ asset('frontend/js/slick.min.js') }}"></script>
    <!-- isotop js -->
    <script src="{{ asset('frontend/js/isotope.pkgd.min.js') }}"></script>
    <!-- simplyCountdownjs -->
    <script src="{{ asset('frontend/js/simplyCountdown.js') }}"></script>
    <!-- counter up js -->
    <script src="{{ asset('frontend/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.countup.min.js') }}"></script>
    <!-- nice select js -->
    <script src="{{ asset('frontend/js/jquery.nice-select.min.js') }}"></script>
    <!-- venobox js -->
    <script src="{{ asset('frontend/js/venobox.min.js') }}"></script>
    <!-- sticky sidebar js -->
    <script src="{{ asset('frontend/js/sticky_sidebar.js') }}"></script>
    <!-- wow js -->
    <script src="{{ asset('frontend/js/wow.min.js') }}"></script>
    <!-- ex zoom js -->
    <script src="{{ asset('frontend/js/jquery.exzoom.js') }}"></script>
    <script src="{{ asset('frontend/js/toastr.min.js') }}"></script>
    <!--main/custom js-->
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    {{-- Sweet alert --}}
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        toastr.options.progressBar = true;
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}")
            @endforeach
        @endif

        //add csrf at ajax header//
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
         $('.testi_slider').slick({
        slidesToShow: 1,      // Ek waqt me ek slide dikhaye
        slidesToScroll: 1,    // Ek baar me ek slide aage badhaye
        autoplay: true,
        autoplaySpeed: 4000,
        dots: false,
        arrows: true,
        fade: true,           // Yeh fade effect dega
        prevArrow: '.ts_prev',  // Aapke custom previous button ka class
        nextArrow: '.ts_next',  // Aapke custom next button ka class
    });

    </script>
    @include('frontend.layouts.global_script')
    @stack('scripts')






</body>

</html>
