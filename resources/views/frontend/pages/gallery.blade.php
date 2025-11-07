@extends('frontend.layouts.master')

@section('content')

<section class="fp__breadcrumb" style="background: url({{ asset('frontend/images/banner_fro.jpg') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>Gallery</h1>
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li style="color: #F86F03"><a href="javascript:;">gallery</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->

    <section class="fp__menu mt_95 xs_mt_45 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-sm-6 col-lg-4 burger pizza wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_item"  style="border-radius: 0;">
                        <div class="fp__menu_item_img">
                            <img src="{{ asset('frontend/images/slider_img_1.png') }}" alt="menu" class="img-fluid w-100">

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4 chicken dresserts wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_item"  style="border-radius: 0;">
                        <div class="fp__menu_item_img">
                            <img src="{{ asset('frontend/images/why_choose_img.jpg') }}" alt="menu" class="img-fluid w-100">

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4 chicken dresserts wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_item"  style="border-radius: 0;">
                        <div class="fp__menu_item_img">
                            <img src="{{ asset('frontend/images/galleryThumb2_10.jpg') }}" alt="menu" class="img-fluid w-100">
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4 burger pizza wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_item"  style="border-radius: 0;">
                        <div class="fp__menu_item_img">
                            <img src="{{ asset('frontend/images/why_choose_img2.jpg') }}" alt="menu" class="img-fluid w-100">

                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 col-lg-4 chicken dresserts wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_item"  style="border-radius: 0;">
                        <div class="fp__menu_item_img">
                            <img src="{{ asset('frontend/images/galleryThumb2_11.jpg') }}" alt="menu" class="img-fluid w-100">
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4 burger pizza wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_item"  style="border-radius: 0;">
                        <div class="fp__menu_item_img">
                            <img src="{{ asset('frontend/images/galleryThumb2_8.jpg') }}" alt="menu" class="img-fluid w-100">

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4 chicken dresserts wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_item"  style="border-radius: 0;">
                        <div class="fp__menu_item_img">
                            <img src="{{ asset('frontend/images/galleryThumb2_7.jpg') }}" alt="menu" class="img-fluid w-100">

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4 burger pizza wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_item"  style="border-radius: 0;">
                        <div class="fp__menu_item_img">
                            <img src="{{ asset('frontend/images/galleryThumb2_6.jpg') }}" alt="menu" class="img-fluid w-100">

                        </div>

                    </div>
                </div>
            </div>
            {{-- <div class="fp__pagination mt_35">
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="...">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#"><i class="fas fa-long-arrow-alt-left"></i></a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#"><i class="fas fa-long-arrow-alt-right"></i></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>


@endsection
