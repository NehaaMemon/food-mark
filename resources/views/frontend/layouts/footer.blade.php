  <footer>
        <div class="fp__footer_overlay pt_100 xs_pt_70 pb_100 xs_pb_70">
            <div class="container wow fadeInUp" data-wow-duration="1s">
                <div class="row justify-content-between">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="fp__footer_content">
                            <a class="footer_logo" href="index.html">
                                <img src="{{ asset('frontend/images/footer_logo.png') }}" alt="FoodPark" class="img-fluid">
                            </a>
                            <span>There are many variations of Lorem Ipsum available, but the majority have suffered alteration in some form.</span>
                            <p class="info"><i class="far fa-map-marker-alt"></i> 7232 Broadway Suite 308, Jackson Heights, 11372, NY, United States</p>
                            <a class="info" href="callto:1234567890123"><i class="fas fa-phone-alt"></i> +1347-430-9510</a>
                            <a class="info" href="mailto:websolutionus1@gmail.com"><i class="fas fa-envelope"></i> websolutionus1@gmail.com</a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-12">
                        <div class="fp__footer_content">
                            <h3>Short Link</h3>
                            <ul>
                                <li><a href="#">Home</a></li>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">Our Service</a></li>
                                <li><a href="#">Gallery</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="fp__footer_content">
                            <h3>Subscribe</h3>
                            <form class="subscribe_form">
                                @csrf
                                <input type="email" placeholder="Your Email" name="email">
                                <button style="background-color: #eb0029;" type="submit" class="subscribe_btn">Subscribe</button>
                            </form>
                            <div class="fp__footer_social_link">
                                <h5>Follow us:</h5>
                                <ul class="d-flex flex-wrap">
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-behance"></i></a></li>
                                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="fp__animated_image_column">
                            <img src="{{ asset('frontend/images/popularDishesShape1.png') }}" alt="Animated Element" class="animated-element img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fp__footer_bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="fp__footer_bottom_text">
                            <p>Copyright 2022 <b>FoodPark</b> All Rights Reserved.</p>
                            <ul>
                                <li><a href="#">FAQs</a></li>
                                <li><a href="#">Payment</a></li>
                                <li><a href="#">Settings</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @push('scripts')
    <script>
        $(document).ready(function(){
            $('.subscribe_form').on('submit',function(e){
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    method : 'POST',
                    url : '{{ route("subscribe-newsletter") }}',
                    data: formData,
                    beforeSend:function(){
                         $('.subscribe_btn').attr('disabled',true)
                        $('.subscribe_btn').html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
                    },
                    success : function(response){
                        $('.subscribe_form').trigger("reset");
                        $('.subscribe_btn').attr('disabled',false)
                       $('.subscribe_btn').html('Subscribe')
                        toastr.success(response.message);
                    },
                    error :function(xhr,status,error){
                        let errors = xhr.responseJSON.errors;
                        $.each(errors,function(index,value){
                            toastr.error(value);
                        })
                        console.log(errors);

                       $('.subscribe_btn').attr('disabled',true)
                        $('.subscribe_btn').html(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')

                    },
                    complete: function(){
                        $('.subscribe_btn').attr('disabled',false)
                        $('.subscribe_btn').html('Subscribe')
                    }
                })
            })
        })
        </script>

    @endpush
