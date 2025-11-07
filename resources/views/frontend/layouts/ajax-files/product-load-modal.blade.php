<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
    class="fal fa-times"></i></button>
    <form action="" id="modal_add_to_cart_form" >
        <input type="hidden" name="product_id" value="{{ $product->id }}">
<div class="fp__cart_popup_img">
<img src="{{ asset($product->thumb_image) }}" alt="{{ $product->name }}" class="img-fluid w-100">
</div>
<div class="fp__cart_popup_text">
<a href="{{ route('product.show', $product->slug) }}" class="title">{!! $product->name !!}</a>
@if ($product->reviews_avg_rating)
    <p class="rating">
        @for ($i = 1; $i <= $product->reviews_avg_rating; $i++)
        <i class="fas fa-star"></i>
        @endfor

        <span>({{ $product->reviews_count }})</span>
    </p>

    @endif
<h4 class="price">
    @if ($product->offer_price > 0)
    <input type="hidden" value="{{ $product->offer_price }}" name="base_price">
    {{ currencyPosition($product->offer_price) }}
    <del>{{ currencyPosition($product->price) }}</del>
    @else
    <input type="hidden" value="{{ $product->price }}" name="base_price">
    {{ currencyPosition($product->price) }}
    @endif

</h4>
@if ($product->productSizes()->exists())
<div class="details_size">
    <h5>select size</h5>
    @foreach ($product->productSizes as $productSize)

    <div class="form-check">
        <input class="form-check-input" type="radio" data-price="{{ $productSize->price }}" value="{{ $productSize->id }}" name="product_size"
            id="{{ $productSize->id }}" >
        <label class="form-check-label" for="{{ $productSize->id }}">
            {{ $productSize->name }} <span>+ {{ currencyPosition($productSize->price) }}</span>
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
        <input class="form-check-input" type="checkbox" name="product_option[]" data-price="{{ $productOption->price }}" value="{{ $productOption->id }}" id="{{ $productOption->id }}">
        <label class="form-check-label" for="{{ $productOption->id }}">
            {{ $productOption->name }} <span>+ {{ currencyPosition($productOption->price) }}</span>
        </label>
    </div>
    @endforeach

</div>
@endif


<div class="details_quentity">
    <h5>select quentity</h5>
    <div class="quentity_btn_area d-flex flex-wrapa align-items-center">
        <div class="quentity_btn">
            <button class="btn btn-danger decrement "><i class="fal fa-minus"></i></button>
            <input type="text" name="quantity" id="quantity" value="1" readonly>
            <button class="btn btn-success increment"><i class="fal fa-plus"></i></button>
        </div>

            @if ($product->offer_price > 0)
            <h3 id="total_price"> {{ currencyPosition($product->offer_price )}}</h3>
        @else
        <h3 id="total_price"> {{ currencyPosition($product->price )}}</h3>
            @endif

    </div>
</div>
<ul class="details_button_area d-flex flex-wrap">
    @if ($product->quantity === 0)
    <li><button type="submit" class="common_btn bg-danger">Stock Out</button></li>
    @else
    <li><button type="submit" class="common_btn modal_cart">add to cart</button></li>
    @endif

</ul>
</div>
    </form>
    <script>
        $(document).ready(function(){
            $('input[name="product_size"]').on('change',function(){
                updateProductPrice();
            });
            // increment and decrement function //
            $(document).ready(function(){
                $('input[name="product_option[]"]').on('change',function(){
                    updateProductPrice();
                });
                $('.increment').on('click',function(e){
                 e.preventDefault()
                 let quantity = $('#quantity');
                 let currentQuantity = parseFloat(quantity.val());
                 quantity.val(currentQuantity + 1);
                 updateProductPrice()

                })
                $('.decrement').on('click',function(e){
                    e.preventDefault()
                  let quantity = $('#quantity');
                  let currentQuantity = parseFloat(quantity.val());
                  if (currentQuantity > 1){
                  quantity.val(currentQuantity - 1);
                  updateProductPrice()
                  }
                })
            })
            //function to update Product Size on selected price//
   function updateProductPrice(){
    let basePrice = parseFloat($('input[name="base_price"]').val()) ;
    let productSizePrice = 0;
    let productOptionPrice = 0;
    let quantity = parseFloat($('#quantity').val()) ;

    // selected size price
    let sizePrice = $('input[name="product_size"]:checked');
    if(sizePrice.length > 0){
        productSizePrice = parseFloat(sizePrice.data("price")) ;
    }

    // selected option price (add all)
    let OptionPrice = $('input[name="product_option[]"]:checked');
    $(OptionPrice).each(function(){
        productOptionPrice += parseFloat($(this).data("price"));
    });

    // total price calculation
    let totalPrice = (basePrice + productSizePrice + productOptionPrice) * quantity;

    // fix floating number issue
    totalPrice = totalPrice.toFixed(2);

    // update HTML
    $('#total_price').text("{{ config('settings.site_default_currency_icon') }}" + totalPrice);
}

        $('#modal_add_to_cart_form').on('submit',function(e){
            e.preventDefault();

            //Validation
            let SizePrice = $("input[name='product_size']");
            if(SizePrice.length > 0){
                if($("input[name='product_size']:checked").val() === undefined){
                    toastr.error('Please Select Size');
                    console.log('Please Select Size');
                    return;

                }
            }

            let formData = $(this).serialize();
            $.ajax({
                method:'POST',
                url:'{{ route("add-to-cart") }}',
                data: formData,
                beforeSend : function(){
                    $('.modal_cart').attr('disable',true);
                    $('.modal_cart').html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> loading...')

                },
                success:function(response){
                    updateSidebarCart();
                    toastr.success(response.message);
                },
                error:function(xhr,status,error){
                  let errorMessage = xhr.responseJSON.message;
                   toastr.error(errorMessage);
                },
                complete : function(){
                    $('.modal_cart').html('Add to Cart');
                    $('.modal_cart').attr('disabled',false);
                }

         })
        })
        })
        </script>
