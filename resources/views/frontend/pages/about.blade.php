    @extends('frontend.layouts.master')

    @section('content')
<section class="fp__breadcrumb" style="background: url('{{ asset('frontend/images/banner_fro.jpg') }}');">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>about UniFood</h1>
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li style="color: #F86F03"><a href="javascript:;">about us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


    <!--=============================
        ABOUT PAGE START
    ==============================-->
    <section class="fp__about_us mt_120 xs_mt_90">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-5 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__about_us_img">
                            <div class="shape about-shape move-anim" >

                        <img src="{{ asset('frontend/images/about_6_1.png') }}" >
                    </div>
                    <div>

                        <img src="{{ asset('frontend/images/about_6_2.png') }}" alt="Shrimp and Rice Dish" class="img-fluid w-100">
                    </div>
                        {{-- <img src="images/about_chef.jpg" alt="about us" class="img-fluid w-100"> --}}
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__section_heading mb_40">
                        <h4>About Company</h4>
                        <h2 style="color: black">Healthy Foods Provider</h2>
                        <span>
                            <img src="images/heading_shapes.png" alt="shapes" class="img-fluid w-100">
                        </span>
                    </div>
                    <div class="fp__about_us_text">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Cupiditate aspernatur molestiae
                            minima pariatur consequatur voluptate sapiente deleniti soluta, animi ab necessitatibus
                            optio similique quasi fuga impedit corrupti obcaecati neque consequatur sequi.</p>
                        <ul>
                            <li>Delicious & Healthy Foods </li>
                            <li>Spacific Family & Kids Zone</li>
                            <li>Best Price & Offers</li>
                            <li>Made By Fresh Ingredients</li>
                            <li>Music & Other Facilities</li>
                            <li>Delicious & Healthy Foods </li>
                            <li>Spacific Family & Kids Zone</li>
                            <li>Best Price & Offers</li>
                            <li>Made By Fresh Ingredients</li>
                            <li>Delicious & Healthy Foods </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Why Choose us Section -->
    <section class="fp__why_choose mt_100 xs_mt_70">
    <div class="container">
        <div class="row wow fadeInUp" data-wow-duration="1s">
            <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                <div class="fp__section_heading mb_25">
                       <h4>why choose us</h4>
                        <h2 style="color: black;">why choose us</h2>

                    <p>{!! @$titleSection['why_choose_us_sub_title'] !!}</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($whyChooseUs as $item)
                <div class="col-xl-4 col-md-6 col-lg-4">
                    <div class="fp__choose_single">
                        <div class="icon icon_1">
                            <i class="{{ @$item->icon }}"></i>
                        </div>
                        <div class="text">
                            <h3>{!! @$item->title !!}</h3>
                            <p>{!! @$item->short_description !!} .</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</section>


        <!-- Experience Section -->
        <section class="experience-section mt_100 xs_mt_70">
            <div class="experience-content">
                <p class="subtitle" style="color: #eb0029">Get Healthy Foods</p>
                <h2>Experience the artistry of Flavor in every dish</h2>
                <p>Conveys the commitment of the restaurant to prioritize both quality And health in their food offerings. It implies that the recipe.</p>
                <button class="btn" style="color: #eb0029" >LEARN MORE <i class="fas fa-arrow-right"></i></button>
            </div>
            <div class="experience-badge">
                <div class="badge-circle">
                    <p style="color:#F86F03">We have</p>
                    <span class="years counter">25</span>
                    <p class="years-text">Years Experience</p>
                </div>
            </div>
        </section>

            <section class="chef-section">
        <!-- Decorative tomato and basil leaves -->
        <img src="{{ asset('frontend/images/chefeShape1.png') }}" alt="Tomato and Basil" class="shape decorative-tomato  move-anim">

        <div class="chef-header">
            <h4> OUR CHEFE</h4>
            <h2>Meet Our Expert Chefe</h2>
        </div>


        <div class="chef-cards-container">
            <!-- Chef Card 1 -->
            <div class="chef-card">
                <div class="chef-image-wrapper">
                    <img src="{{{ asset('frontend/images/chefeThumb1.png') }}}" alt="Ralph Edwards">
                    <!-- <div class="chef-share-button">
                        <i class="fas fa-share-alt"></i>
                    </div> -->
                    <div class="chef-line"></div>
                </div>
                <h3>Ralph Edwards</h3>
                <p>Chef Lead</p>
            </div>

            <!-- Chef Card 2 -->
            <div class="chef-card">
                <div class="chef-image-wrapper">
                    <img src="{{ asset("frontend/images/chefeThumb1_2.png") }}" alt="Leslie Alexander">
                    <!-- <div class="chef-share-button">
                        <i class="fas fa-share-alt"></i>
                    </div> -->
                    <div class="chef-line"></div>
                </div>
                <h3>Leslie Alexander</h3>
                <p>Chef Assistant</p>
            </div>

            <!-- Chef Card 3 -->
            <div class="chef-card">
                <div class="chef-image-wrapper">
                    <img src="{{ asset("frontend/images/chefeThumb1_3.png") }}" alt="Ronald Richards">
                    <!-- <div class="chef-share-button">
                        <i class="fas fa-share-alt"></i>
                    </div> -->
                    <div class="chef-line"></div>
                </div>
                <h3>Ronald Richards</h3>
                <p>Chef Assistant</p>
            </div>
        </div>
           <img src="{{ asset('frontend/images/burger-vector.png') }}" loading="lazy" alt="shape"
       class="shape burger-vector move-anim">
    </section>




    @endsection
