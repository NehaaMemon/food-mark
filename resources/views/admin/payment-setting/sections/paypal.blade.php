   <div class="tab-pane fade show active" id="paypal-setting" role="tabpanel" aria-labelledby="home-tab4">
       <div class="card">
           <div class="card-body border">
               <form action="{{ route('admin.paypal-setting.update') }}" method="POST" enctype="multipart/form-data">
                   @csrf
                   @method('put')

                   <div class="form-group">
                       <label for="">Paypal Status</label>
                       <select name="paypal_status" id="" class="select2 form-control" >
                           <option @selected(@$paymentSetting['paypal_status'] == 1) value="1">Active</option>
                           <option @selected(@$paymentSetting['paypal_status'] == 0) value="0">Inactive</option>
                       </select>
                   </div>
                   <div class="form-group">
                       <label for="">Paypal Account Mode</label>
                       <select name="paypal_account_mode" id="" class="select2 form-control ">
                           <option @selected(@$paymentSetting['paypal_account_mode'] === 'sandbox') value="sandbox">Sandbox</option>
                           <option @selected(@$paymentSetting['paypal_account_mode'] === 'live') value="live">Live</option>
                       </select>
                   </div>
                    <div class="form-group">
                       <label for="">Paypal Country Name</label>
                       <select name="paypal_country" id="" class="select2 form-control ">
                           <option value="">Select</option>
                           @foreach (config('country_name') as $key => $country)
                                 <option @selected(@$paymentSetting['paypal_country'] === $key) value="{{ $key }}">{{ $country }}</option>
                           @endforeach

                       </select>
                   </div>
                   <div class="form-group">
                       <label for="">Paypal Currency Name</label>
                       <select name="paypal_currency_name" id="" class="select2 form-control ">
                           <option value="">Select</option>
                           @foreach (config('currencys.currency_list') as $currency)
                               <option @selected(config('settings.site_default_currency') === $currency) value="{{ $currency }}">{{ $currency }}
                               </option>
                           @endforeach
                       </select>
                   </div>
                   <div class="form-group">
                       <label for="">Currency Rate ( Per {{ config('settings.site_default_currency') }})</label>
                       <input type="text" name="paypal_rate" class="form-control" value="{{ @$paymentSetting['paypal_rate'] }}">
                   </div>

                   <div class="form-group">
                       <label for="">Paypal Client Id</label>
                       <input type="text" name="paypal_api_key" class="form-control" value="{{ @$paymentSetting['paypal_api_key'] }}">
                   </div>

                   <div class="form-group">
                       <label for="">Paypal Secret key</label>
                       <input type="text" name="paypal_secret_key" class="form-control" value="{{ @$paymentSetting['paypal_secret_key'] }}">
                   </div>

                     <div class="form-group">
                       <label for="">Paypal App Id</label>
                       <input type="text" name="paypal_app_id" class="form-control" value="{{ @$paymentSetting['paypal_app_id'] }}">
                   </div>

                   <div class="form-group">
                       <label>Paypal Logo</label>
                       <div id="image-preview" class="image-preview paypal-preview">
                           <label for="image-upload" id="image-label">Choose File</label>
                           <input type="file" name="paypal_logo" id="image-upload" />
                       </div>
                   </div>
                       <button type="submit" class="btn btn-primary">Save</button>
               </form>
           </div>
       </div>
   </div>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.paypal-preview').css({
                'background-image': 'url({{ asset(@$paymentSetting["paypal_logo"]) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            })
        })
    </script>
@endpush
