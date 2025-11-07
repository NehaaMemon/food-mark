  @extends('frontend.layouts.master')


    @section('content')
 <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset('frontend/images/banner_fro.jpg') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>contact with us</h1>
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li style="color: #f86f03"><a href="#">contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


    <!--=============================
        CONTACT PAGE START
    ==============================-->
    <section class="fp__contact mt_100 xs_mt_70 mb_100 xs_mb_70">
        <div class="container">
          <div class="row">
    <div class="col-xl-3 col-md-6 col-lg-3 mb-4 wow fadeInUp" data-wow-duration="1s">
        <div class="fp__contact_info">
            <span><i class="fas fa-map-marker-alt"></i></span>
            <div class="text">
                <h3>Our Address</h3>
                <p>4517 Washington Ave. Manchester,</p>
                <p>Kentucky 39495</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-lg-3 mb-4 wow fadeInUp" data-wow-duration="1s">
        <div class="fp__contact_info">
            <span><i class="fal fa-envelope"></i></span>
            <div class="text">
                <h3>Info@Exmple.Com</h3>
                <p>Email us anytime for any kind</p>
                <p>of quety.</p>
            </div>
        </div>
    </div>
  <div class="col-xl-3 col-md-6 col-lg-3 mb-4 wow fadeInUp" data-wow-duration="1s">
        <div class="fp__contact_info">
            <span><i class="fas fa-phone-alt"></i></span>
            <div class="text">
                <h3>Hot: +208-666-01112</h3>
                <p>24/7/365 priority Live Chat and</p>
                <p>ticketing support.</p>
            </div>
        </div>
    </div>
<div class="col-xl-3 col-md-6 col-lg-3 mb-4 wow fadeInUp" data-wow-duration="1s">
        <div class="fp__contact_info">
            <span><i class="fal fa-clock"></i></span>
            <div class="text">
                <h3>Opening Hour</h3>
                <p>Sunday-Fri: 9 AM — 6 PM Saturday:</p>
                <p>9 AM — 4 PM</p>
            </div>
        </div>
    </div>
</div>
            <div class="fp__contact_form_area mt_100 xs_mt_70">
                <div class="row">
                    <div class="col-xl-6 wow fadeInUp" data-wow-duration="1s">
                        <div class="contact-form-thumb" style="margin-left: -180px;">
                            <img src="{{ asset('frontend/images/contactThumb2_1.png') }}" alt="thumb">
                        </div>
                    </div>
                     <div class="col-xl-6 wow mt-2 fadeInUp" data-wow-duration="1s">
                        <form class="fp__contact_form">
                            <h3>get in touch</h3>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6">
                                    <div class="fp__contact_form_input">
                                        <span><i class="fal fa-user-alt"></i></span>
                                        <input type="text" placeholder="Name" name="name">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="fp__contact_form_input">
                                        <span><i class="fal fa-envelope"></i></span>
                                        <input type="email" placeholder="Email" name="email">
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="fp__contact_form_input textarea">
                                        <span><i class="fal fa-book"></i></span>
                                        <textarea rows="8" placeholder="Message" name="message"></textarea>
                                    </div>
                                    <button type="submit" class="submit-btn">send message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt_100 xs_mt_70">
                    <div class="col-xl-12 wow fadeInUp" data-wow-duration="1s">
                        <div class="fp__contact_map">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29199.78758207035!2d90.43684581929195!3d23.819543211524437!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c62fce7d991f%3A0xacfaf1ac8e944c05!2sBasundhara%20Residential%20Area%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1667021568123!5m2!1sen!2sbd"
                                style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        CONTACT PAGE END
    ==============================-->
@push('scripts')
<script>
    $(document).ready(function(){
        $('.fp__contact_form').on('submit',function(e){
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                method : 'POST',
                url : '{{ route("contact.send-message") }}',
                data : formData,
                beforeSend : function(){
                     $('.submit-btn').attr('disabled',true)
                    $('.submit-btn').html(`
                        <span class="spinner-border spinner-border-sm"></span>Sending..

                        `)
                },
                success : function(response){
                      toastr.success(response.message);
                      $('.fp__contact_form').trigger('reset')
                      $('.submit-btn').attr('disabled',false)
                      $('.submit-btn').html(`Send Message`)
                },
                error : function(xhr,status,error){
                    let errors = xhr.responseJSON.errors;
                    $.each(errors ,function(index,value){
                        toastr.error(value)
                    }),
                     $('.submit-btn').attr('disabled',false)
                     $('.submit-btn').html(`Send Message`)
                }

            })
        })
    })
    </script>

@endpush

    @endsection
