@extends('frontend.layouts.master')

@section('content')
<section class="fp__breadcrumb" style="background: url({{ asset('frontend/images/banner_fro.jpg') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>Chef</h1>
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li style="color: #F86F03"><a href="javascript:;">chef</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->
<section class="chef-section position-relative py-5">
    <div class="chef-header text-center mb-5">
        <h4><i class="fas fa-utensils icon"></i> OUR CHEFE</h4>
        <h2>Meet Our Expert Chefe</h2>
    </div>

    <div class="container">
        <div class="row g-4 justify-content-center">

            <!-- Chef Card 1 -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="chef-card text-center">
                    <div class="chef-image-wrapper mb-3">
                        <img src="{{ asset('frontend/images/chefeThumb1.png') }}" alt="Ralph Edwards" class="img-fluid rounded">
                        <div class="chef-line mt-2"></div>
                    </div>
                    <h3>Ralph Edwards</h3>
                    <p>Chef Lead</p>
                </div>
            </div>

            <!-- Chef Card 2 -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="chef-card text-center">
                    <div class="chef-image-wrapper mb-3">
                        <img src="{{ asset('frontend/images/chefeThumb1_2.png') }}" alt="Leslie Alexander" class="img-fluid rounded">
                        <div class="chef-line mt-2"></div>
                    </div>
                    <h3>Leslie Alexander</h3>
                    <p>Chef Assistant</p>
                </div>
            </div>

            <!-- Chef Card 3 -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="chef-card text-center">
                    <div class="chef-image-wrapper mb-3">
                        <img src="{{ asset('frontend/images/chefeThumb1_3.png') }}" alt="Ronald Richards" class="img-fluid rounded">
                        <div class="chef-line mt-2"></div>
                    </div>
                    <h3>Ronald Richards</h3>
                    <p>Senior Chef</p>
                </div>
            </div>

            <!-- Additional Chef Cards -->
            {{-- @for ($i = 0; $i < 4; $i++) --}}
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="chef-card text-center">
                    <div class="chef-image-wrapper mb-3">
                        <img src="{{ asset('frontend/images/chefeThumb1_6.png') }}" alt="Ronald Richards" class="img-fluid rounded">
                        <div class="chef-line mt-2"></div>
                    </div>
                    <h3>Rijab Khan</h3>
                    <p>Junior Chef </p>
                </div>
            </div>
                     <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="chef-card text-center">
                    <div class="chef-image-wrapper mb-3">
                        <img src="{{ asset('frontend/images/chef_2.jpg') }}" alt="Ronald Richards" class="img-fluid rounded">
                        <div class="chef-line mt-2"></div>
                    </div>
                    <h3>Areeb Khan</h3>
                    <p>Chef Assistant</p>
                </div>
            </div>
                       <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="chef-card text-center">
                    <div class="chef-image-wrapper mb-3">
                        <img src="{{ asset('frontend/images/chefeThumb1_5.png') }}" alt="Ronald Richards" class="img-fluid rounded">
                        <div class="chef-line mt-2"></div>
                    </div>
                    <h3>Robert fox</h3>
                    <p>Chef Assistant</p>
                </div>
            </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="chef-card text-center">
                    <div class="chef-image-wrapper mb-3">
                        <img src="{{ asset('frontend/images/chef_1.jpg') }}" alt="Ronald Richards" class="img-fluid rounded">
                        <div class="chef-line mt-2"></div>
                    </div>
                    <h3>Seema Ahmed</h3>
                    <p>Chef Assistant</p>
                </div>
            </div>
            {{-- @endfor --}}

        </div>
    </div>

    <img src="{{ asset('frontend/images/pizzaShape1_2.png') }}"
         loading="lazy"
         alt="shape"
         class="shape burgers-shape move-anim position-absolute" style="top: 73%;left: 83%;height: 20% !important;">
</section>
@endsection
