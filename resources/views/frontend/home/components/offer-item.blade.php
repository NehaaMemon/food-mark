<section class="fp__offer_item mt_100 xs_mt_70 pt_95 xs_pt_65 pb_150 xs_pb_120">
    <div class="container">
        <div class="row wow fadeInUp" data-wow-duration="1s">
            <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                <div class="fp__section_heading mb_50">
                    <h4><i class="fas fa-utensils icon"></i> daily offer</h4>
                    <h2 style="color: black">up to 75% off for this day</h2>

                    <p>Objectively pontificate quality models before intuitive information. Dramatically
                        recaptiualize multifunctional materials.</p>
                </div>
            </div>
        </div>

        <div class="row offer_item_slider wow fadeInUp" data-wow-duration="1s">
            @foreach ($dailyOffer as $dailyOffers)

            <div class="col-xl-4">
                <div class="fp__offer_item_single">
                    <div class="img">
                        <img src="{{ asset($dailyOffers->product->thumb_image) }}" alt="offer" class="img-fluid w-100">
                    </div>
                    <div class="text">
                        <span>
                           @if ($dailyOffers->product->offer_price > 0)
                         {{ discountInPercentage($dailyOffers->product->price,
                         $dailyOffers->product->offer_price) }}% Off

                            @endif
                        </span>
                        <a class="title" href="{{ route('product.show',$dailyOffers->product->slug) }}">{!! $dailyOffers->product->name !!}</a>
                        <p>{{ $dailyOffers->product->short_description }}</p>
                        <ul class="d-flex flex-wrap">
                            <li><a href="javascript:;" onclick="loadProductModal('{{ $dailyOffers->product->id }}')"><i
                                        class="fas fa-shopping-basket"></i></a></li>
                            <li><a href="#"><i class="fal fa-heart"></i></a></li>
                            <li><a href="{{ route('product.show',$dailyOffers->product->slug) }}"><i class="far fa-eye"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            @endforeach

        </div>
    </div>
     <img src="{{ asset('frontend/images/tree_6.png') }}" loading="lazy" alt="shape"
       class="shape tree-3 move-anim">
          <img src="{{ asset('frontend/images/shape-3.png') }}" loading="lazy" alt="shape"
       class="shape shape-3 move-anim">
</section>
