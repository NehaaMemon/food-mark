<script>
    function loadProductModal(productId){
     $.ajax
     ({
        method :'get',
        url : '{{ route("load-product-Modal", ":productId") }}'.replace(':productId',productId),
        success : function(response)
        {
            $('.product-load-modal').html(response);
            $('#cartModal').modal('show');

        },
        error: function(xhr,status,error) {
            console.error(error);
        }
     })
    }
</script>
