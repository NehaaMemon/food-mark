<script>
    // show sweet alert
   $('body').on('click', '.delete-item', function(e) {
                e.preventDefault()
                let url = $(this).attr('href');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'DELETE',
                            url: url,
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    toastr.success(response.message)
                                    window.location.reload();
                                } else if (response.status === 'error') {
                                    toastr.error(response.message)
                                }
                            },
                            error: function(error) {
                                console.error(error);
                            }
                        })
                    }

                })
            })



    // show loader
        function showLoader(){
        $('.overlay-container').removeClass('d-none');
        $('.overlay').addClass('active');
    }
//    hide Loader
    function hideLoader(){
        $('.overlay').removeClass('active');
        $('.overlay-container').addClass('d-none');
    }
    function loadProductModal(productId){
     $.ajax
     ({
        method :'get',
        url : '{{ route("load-product-Modal", ":productId") }}'.replace(':productId',productId),
        beforeSend: function(){
            $('.overlay-container').removeClass('d-none');
            $('.overlay').addClass('active');
            },
        success : function(response)
        {
            $('.product_load_modal_body').html(response);
            $('#cartModal').modal('show');

        },
        error: function(xhr,status,error) {
            console.error(error);
        },
        complete: function(){
        $('.overlay').removeClass('active');
        $('.overlay-container').addClass('d-none');
    }
     })
    }
    //update sidebar cart //
    function updateSidebarCart(callback = null){
        $.ajax
     ({
        method :'get',
        url : '{{ route("cart-update-products") }}',
        success : function(response)
        {
            $('.card-content').html(response);
            let carttotal = $('#cart_total').val();
            let cartCount = $('#cart_product_count').val();
            $('.cartsubtotal').text("{{ currencyPosition(':carttotal') }}".replace(':carttotal',carttotal));
            $('.cart_count').text(cartCount);

            if(callback && typeof callback === 'function'){
                callback();
            }
        },
        error: function(xhr,status,error) {
            console.error(error);
        },

     })

    }
    // remove sidebar product //
    function removeProductFromSidebar($rowId){
        $.ajax({
            method : 'GET',
            url : '{{ route("cart-product-remove",":rowId") }}'.replace(":rowId",$rowId),
            beforeSend: function(){
            $('.overlay-container').removeClass('d-none');
            $('.overlay').addClass('active');
            },
            success : function(responce){
                if(responce.status === 'success'){
                    updateSidebarCart(function(){
                        toastr.success(responce.message);
                        $('.overlay').removeClass('active');
                        $('.overlay-container').addClass('d-none');
                    })
                }
            },
            error : function(xhr,status,error){
                let errorMessage = xhr.responseJSON.message;
                toastr.error(errorMessage);
            }

        })
    }

     // get cart total amount //
function getCartTotal(){
    return parseInt("{{ cartTotal() }}");

}
</script>
