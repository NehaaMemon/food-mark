<div class="tab-pane fade show" id="jazzcash-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.jazzcash-setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')

                {{-- Status --}}
                <div class="form-group">
                    <label for="">JazzCash Status</label>
                    <select name="jazzcash_status" class="select3 form-control">
                        <option @selected(@$paymentSetting['jazzcash_status'] == 1) value="1">Active</option>
                        <option @selected(@$paymentSetting['jazzcash_status'] == 0) value="0">Inactive</option>
                    </select>
                </div>

                {{-- Account Mode --}}
                {{-- u6z65ct9vz salt
                ahv355b414 password
                MC222933 merchant --}}
                <div class="form-group">
                    <label for="">JazzCash Account Mode</label>
                    <select name="jazzcash_account_mode" class="select3 form-control">
                        <option @selected(@$paymentSetting['jazzcash_account_mode'] === 'sandbox') value="sandbox">Sandbox</option>
                        <option @selected(@$paymentSetting['jazzcash_account_mode'] === 'live') value="live">Live</option>
                    </select>
                </div>

                {{-- Country (fixed PK) --}}
                <div class="form-group">
                    <label for="">JazzCash Country</label>
                    <input type="text" name="jazzcash_country" class="form-control"
                           value="Pakistan" readonly>
                </div>

                {{-- Currency (fixed PKR) --}}
                <div class="form-group">
                    <label for="">JazzCash Currency</label>
                    <input type="text" name="jazzcash_currency_name" class="form-control"
                           value="PKR" readonly>
                </div>

                {{-- Currency Rate (per default currency) --}}
                <div class="form-group">
                    <label for="">Currency Rate (Per {{ config('settings.site_default_currency') }})</label>
                    <input type="text" name="jazzcash_rate" class="form-control"
                           value="{{ @$paymentSetting['jazzcash_rate'] }}">
                </div>

                {{-- Merchant ID --}}
                <div class="form-group">
                    <label for="">JazzCash Merchant ID</label>
                    <input type="text" name="jazzcash_merchant_id" class="form-control"
                           value="{{ @$paymentSetting['jazzcash_merchant_id'] }}">
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label for="">JazzCash Password</label>
                    <input type="text" name="jazzcash_password" class="form-control"
                           value="{{ @$paymentSetting['jazzcash_password'] }}">
                </div>

                {{-- Integrity Salt --}}
                <div class="form-group">
                    <label for="">JazzCash Integrity Salt</label>
                    <input type="text" name="jazzcash_integerity_salt" class="form-control"
                           value="{{ @$paymentSetting['jazzcash_integerity_salt'] }}">
                </div>

                {{-- Logo --}}
                <div class="form-group">
                    <label>JazzCash Logo</label>
                    <div id="image-preview-3" class="image-preview jazzcash-preview">
                        <label for="image-upload" id="image-label">Choose File</label>
                        <input type="file" name="jazzcash_logo" id="image-upload-3" />
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $.uploadPreview({
        input_field: "#image-upload-3",
        preview_box: "#image-preview-3",
        label_field: "#image-label-3",
        label_default: "Choose File",
        label_selected: "Change File",
        no_label: false,
        success_callback: null
    });

    $(document).ready(function() {
        $('.jazzcash-preview').css({
            'background-image': 'url({{ asset(@$paymentSetting["jazzcash_logo"]) }})',
            'background-size': 'cover',
            'background-position': 'center center'
        });

        if (jQuery().select2) {
            $(".select3").select2();
        }
    })
</script>
@endpush
