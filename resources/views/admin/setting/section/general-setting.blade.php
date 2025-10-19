  <div class="tab-pane fade show active" id="general-setting" role="tabpanel" aria-labelledby="home-tab4">
                          <div class="card">
                            <div class="card-body border">
                                <form action="{{ route('admin.general-setting.update') }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="form-group">
                                        <label for="">Site name</label>
                                        <input type="text" name="site_name" class="form-control" value="{{ config('settings.site_name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Default Currency</label>
                                        <select name="site_default_currency" id="" class="select2 form-control ">
                                            <option value="">Select</option>
                                            @foreach (config('currencys.currency_list') as $currency)
                                            <option @selected(config('settings.site_default_currency') === $currency ) value="{{ $currency }}">{{ $currency }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Currency icon</label>
                                            <input type="text" name="site_default_currency_icon" class="form-control" value="{{ config('settings.site_default_currency_icon') }}">
                                        </div>
                                      </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Currency icon position</label>
                                                    <select name="site_default_currency_position" id="" class=" form-control">
                                                        <option @selected(config('settings.site_default_currency_position') === 'right') value="right">Right</option>
                                                        <option @selected(config('settings.site_default_currency_position') === 'left')  value="left">Left</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                          </div>
                        </div>
