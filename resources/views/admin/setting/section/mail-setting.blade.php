  <div class="tab-pane fade show " id="mail-setting" role="tabpanel"
  aria-labelledby="home-tab4">
      <div class="card">
          <div class="card-body border">
              <form action="{{ route('admin.mail-setting.update') }}" method="POST">
                  @csrf
                  @method('put')
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="">Mail Driver</label>
                              <input type="text" name="mail_driver"
                              class="form-control" value="{{ config('settings.mail_driver') }}">
                          </div>
                      </div>

                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="">Mail Host</label>
                              <input type="text" name="mail_host"
                               class="form-control" value="{{ config('settings.mail_host') }}">
                          </div>
                      </div>

                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="">Mail Port</label>
                              <input type="text" name="mail_port"
                              class="form-control" value="{{ config('settings.mail_port') }}">
                          </div>
                      </div>

                  </div>

                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="">Mail UserName</label>
                              <input type="text" name="mail_username"
                              class="form-control" value="{{ config('settings.mail_username') }}">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="">Mail Password</label>
                              <input type="text" name="mail_password"
                              class="form-control" value="{{ config('settings.mail_password') }}">
                          </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="">Mail Encryption</label>
                              <input type="text" name="mail_encryption"
                               class="form-control" value="{{ config('settings.mail_encryption') }}">
                          </div>
                      </div>

                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="">Mail Form Address</label>
                              <input type="text" name="mail_form_address" class="form-control"
                              value="{{ config('settings.mail_form_address') }}">
                          </div>
                      </div>

                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="">Mail Receive Address</label>
                              <input type="text" name="mail_receive_address"
                              class="form-control" value="{{ config('settings.mail_receive_address') }}">
                          </div>
                      </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Save</button>
              </form>
          </div>
      </div>
  </div>
