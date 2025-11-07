<section class="fp__why_choose mt_100 xs_mt_70">
    <div class="container">
        <div class="row wow fadeInUp" data-wow-duration="1s">
            <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                <div class="fp__section_heading mb_25">
                    <h4><i class="fas fa-utensils icon"></i> {!! @$titleSection['why_choose_us_top_title'] !!}</h4>
                    <h2 style="color: black">{!! @$titleSection['why_choose_us_main_title'] !!}</h2>

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
     <img src="{{ asset('frontend/images/pizzaShape1_2.png') }}" loading="lazy" alt="shape"
       class="shape burger-shape move-anim">
          <img src="{{ asset('frontend/images/burgerShape1_1.png') }}" loading="lazy" alt="shape"
       class="shape pizza-shape move-anim">
</section>


