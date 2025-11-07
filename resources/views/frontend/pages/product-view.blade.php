@extends('frontend.layouts.master')
@section('content')
    <!--=============================
                    BREADCRUMB START
                ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset('frontend/images/counter_bg.jpg') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>menu Details</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">home</a></li>
                        <li style="color: #F86F03"><a href="javascript;:">menu Details</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
                    BREADCRUMB END
                ==============================-->


    <!--=============================
                    MENU DETAILS START
                ==============================-->
    <section class="fp__menu_details mt_115 xs_mt_85 mb_95 xs_mb_65">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-9 wow fadeInUp" data-wow-duration="1s">
                    <div class="exzoom hidden" id="exzoom">
                        <div class="exzoom_img_box fp__menu_details_images">
                            <ul class='exzoom_img_ul'>
                                <li><img class="zoom ing-fluid w-100" src="{{ $product->thumb_image }}" alt="product"></li>
                                @foreach ($product->ProductImages as $images)
                                    <li><img class="zoom ing-fluid w-100" src="{{ $images->image }}" alt="product"></li>
                                @endforeach


                            </ul>
                        </div>
                        <div class="exzoom_nav"></div>
                        <p class="exzoom_btn">
                            <a href="javascript:void(0);" class="exzoom_prev_btn"> <i class="far fa-chevron-left"></i>
                            </a>
                            <a href="javascript:void(0);" class="exzoom_next_btn"> <i class="far fa-chevron-right"></i>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_details_text">
                        <h2>{!! $product->name !!}</h2>
                          @if ($product->reviews_avg_rating)
                        <p class="rating">
                            @for ($i = 1; $i <= $product->reviews_avg_rating; $i++)
                            <i class="fas fa-star"></i>
                            @endfor

                            <span>({{ $product->reviews_count }})</span>
                        </p>

                        @endif
                        <h3 class="price">
                            @if ($product->offer_price > 0)
                                {{ currencyPosition($product->offer_price) }}
                                <del>{{ currencyPosition($product->price) }}</del>
                            @else
                                {{ currencyPosition($product->price) }}
                            @endif


                        </h3>
                        <p class="short_description">{!! $product->short_description !!}</p>
                        <form method="" action="" id="v_add_to_cart_form">
                            @csrf
                            <input type="hidden" class="v_base_price"
                                value="{{ $product->offer_price > 0 ? $product->offer_price : $product->price }}">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            @if ($product->productSizes()->exists())
                                <div class="details_size">
                                    <h5>select size</h5>
                                    @foreach ($product->productSizes as $productSize)
                                        <div class="form-check">
                                            <input class="form-check-input v_product_size" type="radio"
                                                name="product_size" id="size-{{ $productSize->id }}"
                                                data-price="{{ $productSize->price }}" value="{{ $productSize->id }}">
                                            <label class="form-check-label" for="size-{{ $productSize->id }}">
                                                {{ $productSize->name }} <span>+
                                                    {{ currencyPosition($productSize->price) }}</span>
                                            </label>
                                        </div>
                                    @endforeach


                                </div>
                            @endif
                            @if ($product->productOptions()->exists())
                                <div class="details_extra_item">
                                    <h5>select option <span>(optional)</span></h5>
                                    @foreach ($product->productOptions as $productOption)
                                        <div class="form-check">
                                            <input class="form-check-input v_product_option" name="product_option[]"
                                                type="checkbox" value="{{ $productOption->id }}" id="option-{{ $productOption->id }}"
                                                data-price="{{ $productOption->price }}">
                                            <label class="form-check-label" for="option-{{ $productOption->id }}">
                                                {{ $productOption->name }} <span>+
                                                    {{ currencyPosition($productSize->price) }}</span>
                                            </label>
                                        </div>
                                    @endforeach

                                </div>
                            @endif


                            <div class="details_quentity">
                                <h5>select quentity</h5>
                                <div class="quentity_btn_area d-flex flex-wrapa align-items-center">
                                    <div class="quentity_btn">
                                        <button class="btn btn-danger v_decrement"><i class="fal fa-minus"></i></button>
                                        <input type="text" name="quantity" placeholder="1" value="1" readonly
                                            id="v_quantity">
                                        <button class="btn btn-success v_increment"><i class="fal fa-plus"></i></button>
                                    </div>
                                    <h3 id="v_total_price">
                                        {{ $product->offer_price > 0 ? currencyPosition($product->offer_price) : currencyPosition($product->price) }}
                                    </h3>
                                </div>
                            </div>
                        </form>
                        <ul class="details_button_area d-flex flex-wrap">
                            @if ($product->quantity === 0)
                            <li><a class="common_btn bg-danger" href="javascript:;">Stock Out</a></li>
                            @else
                            <li><a class="common_btn v_submit_button" href="#">add to cart</a></li>
                            @endif
                            <li><a class="wishlist" href="#"><i class="far fa-heart"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_description_area mt_100 xs_mt_70">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                    aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-contact" type="button" role="tab"
                                    aria-controls="pills-contact" aria-selected="false">Reviews</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab" tabindex="0">
                                <div class="menu_det_description">
                                    {!! $product->long_description !!}

                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab" tabindex="0">
                                <div class="fp__review_area">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h4> {{ count($reviews) }} Reviews</h4>
                                            <div class="fp__comment pt-0 mt_20">
                                                @foreach ($reviews as $review)
                                                <div class="fp__single_comment m-0 border-0">
                                                    <img src="{{ asset($review->user->avatar) }}" alt="review" class="img-fluid">
                                                    <div class="fp__single_comm_text">
                                                        <h3>{{ $review->user->name }} <span>{{ date('d m Y',strtotime($review->created_at)) }} </span></h3>
                                                        <span class="rating">
                                                            @for ($i = 1; $i<=$review->rating;$i++)
                                                            <i class="fas fa-star"></i>
                                                            @endfor
                                                        </span>
                                                        <p>{{ $review->review }}</p>
                                                    </div>
                                                </div>
                                                @endforeach
                                                @if ($reviews->hasPages())
                                                <div class="fp__pagination mt_60">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            {{ $reviews->links() }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @if (count($reviews) === 0)

                                                <div class="alert alert-warning mt-5">No review found</div>
                                                @endif
                                            </div>
                                        </div>
                                        @auth
                                        <div class="col-lg-5">
                                            <div class="fp__post_review">
                                                <h4>write a Review</h4>
                                                <form method="POST" action="{{ route('product-review.store') }}">
                                                    @csrf
                                                    <div class="row">

                                                        <div class="col-xl-12">
                                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                            <p class="rating">
                                                                <span>select your rating : </span>
                                                                <div class="rating" data-rating="0">
                                                                    <i class="far fa-star" data-value="1"></i>
                                                                    <i class="far fa-star" data-value="2"></i>
                                                                    <i class="far fa-star" data-value="3"></i>
                                                                    <i class="far fa-star" data-value="4"></i>
                                                                    <i class="far fa-star" data-value="5"></i>
                                                                </div>


                                                                <input type="hidden" name="rating" id="rating-value" value="0">
                                                            </p>

                                                        </div>
                                                        <div class="col-xl-12">
                                                            <textarea rows="3" placeholder="Write your review" name="review"></textarea>
                                                        </div>
                                                        <div class="col-12">
                                                            <button class="common_btn" type="submit">submit
                                                                review</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                       @else
                                        <div class="col-lg-4">
                                            <div class="alert alert-warning mt-5">
                                             Please Login for submit your review
                                            </div>
                                        </div>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (count($relatedProducts) > 0)
                <div class="fp__related_menu mt_90 xs_mt_60">
                    <h2>related item</h2>
                    <div class="row related_product_slider">
                        @foreach ($relatedProducts as $relatedproduct)
                            <div class="col-xl-3 wow fadeInUp" data-wow-duration="1s">
                                <div class="fp__menu_item">
                                    <div class="fp__menu_item_img">
                                        <img src="{{ $relatedproduct->thumb_image }}" alt="{{ $relatedproduct->name }}"
                                            class="img-fluid w-100">
                                        <a class="category" href="#">{{ @$relatedproduct->name }}</a>
                                    </div>
                                    <div class="fp__menu_item_text">
                                       @if ($relatedproduct->reviews_avg_rating)
                                        <p class="rating">
                                            @for ($i = 1; $i <= $relatedproduct->reviews_avg_rating; $i++)
                                            <i class="fas fa-star"></i>
                                            @endfor

                                            <span>({{ $relatedproduct->reviews_count }})</span>
                                        </p>

                                        @endif
                                        <a class="title"
                                            href="{{ route('product.show', $relatedproduct->slug) }}">{!! $relatedproduct->name !!}</a>
                                        <h5 class="price">
                                            @if ($relatedproduct->offer_price > 0)
                                                {{ currencyPosition($relatedproduct->offer_price) }}
                                                <del>{{ currencyPosition($relatedproduct->price) }}</del>
                                            @else
                                                {{ currencyPosition($relatedproduct->price) }}
                                            @endif


                                        </h5>
                                        <ul class="d-flex flex-wrap justify-content-center">
                                            <li><a href="javascript:;" onclick="loadProductModal('{{$relatedproduct->id }}')"><i
                                                class="fas fa-shopping-basket"></i></a></li>
                                            <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                            <li><a href="#"><i class="far fa-eye"></i></a></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>



    <!--=============================
                    MENU DETAILS END
                ==============================-->
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.v_product_size').prop('checked', false);
            $('.v_product_option').prop('checked', false);
            $('#v_quantity').val(1);
            $('.v_product_size').on('change', function() {
                v_updateProductPrice();

            });
            $('.v_product_option').on('change', function() {
                v_updateProductPrice()
            });

            // increment and decrement function //
            $('.v_increment').on('click', function(e) {
                e.preventDefault()
                let quantity = $('#v_quantity');
                let currentQuantity = parseFloat(quantity.val());
                quantity.val(currentQuantity + 1);
                v_updateProductPrice()

            })
            $('.v_decrement').on('click', function(e) {
                e.preventDefault()
                let quantity = $('#v_quantity');
                let currentQuantity = parseFloat(quantity.val());
                if (currentQuantity > 1) {
                    quantity.val(currentQuantity - 1);
                    v_updateProductPrice()
                }
            })
            //function to update Product Size on selected price//
            function v_updateProductPrice() {
                let basePrice = parseFloat($('.v_base_price').val());
                let productSizePrice = 0;
                let productOptionPrice = 0;
                let quantity = parseFloat($('#v_quantity').val());

                //calculate selected price of product //
                let sizePrice = $('.v_product_size:checked');
                if (sizePrice.length > 0) {
                    productSizePrice = parseFloat(sizePrice.data("price"));
                }
                let OptionPrice = $('.v_product_option:checked');
                $(OptionPrice).each(function() {
                    productOptionPrice = parseFloat($(this).data("price"));
                })
                let totalPrice = (basePrice + productSizePrice + productOptionPrice) * quantity;
                totalPrice = totalPrice.toFixed(2);

                $('#v_total_price').text("{{ config('settings.site_default_currency_icon') }}" + totalPrice);
            }
            //Add to cart Function//
            $('.v_submit_button').on('click', function(e) {
                    e.preventDefault();
                    $('#v_add_to_cart_form').submit();
                })
                $('#v_add_to_cart_form').on('submit', function(e) {
                    e.preventDefault();



                //Validation
                let SizePrice = $(".v_product_size");
                if (SizePrice.length > 0) {
                    if ($(".v_product_size:checked").val() === undefined) {
                        toastr.error('Please Select Size');
                        console.log('Please Select Size');
                        return;

                    }
                }
                let formData = $(this).serialize();
                $.ajax({
                    method: 'POST',
                    url: '{{ route("add-to-cart") }}',
                    data: formData,
                    beforeSend: function() {
                        $('.v_submit_button').attr('disabled', true);
                        $('.v_submit_button').html(
                            '<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> loading...'
                            )

                    },
                    success: function(response) {
                        updateSidebarCart();
                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.responseJSON.message;
                        toastr.error(errorMessage);
                    },
                    complete: function() {
                        $('.v_submit_button').html('Add to Cart');
                        $('.v_submit_button').attr('disable', false);
                    }

                })
            })
            document.querySelectorAll('.rating i').forEach(star => {
    star.addEventListener('click', function() {
        const rating = this.getAttribute('data-value');
        document.getElementById('rating-value').value = rating;
        const stars = this.parentNode.querySelectorAll('i');

        stars.forEach(s => {
            if (s.getAttribute('data-value') <= rating) {
                s.classList.remove('far');
                s.classList.add('fas');
            } else {
                s.classList.remove('fas');
                s.classList.add('far');
            }
        });
    });
});

        })
    </script>
@endpush
