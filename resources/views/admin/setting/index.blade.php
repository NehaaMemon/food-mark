@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Setting</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>All Settings</h4>

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-2">
                      <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="" data-toggle="tab" href="#general-setting" role="tab" aria-controls="home" aria-selected="true">General Setting</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="" data-toggle="tab" href="#pusher-setting" role="tab" aria-controls="profile" aria-selected="false">Pusher Setting</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="" data-toggle="tab" href="#mail-setting" role="tab" aria-controls="contact" aria-selected="false">Mail Setting</a>
                        </li>
                            <li class="nav-item">
                          <a class="nav-link" id="" data-toggle="tab" href="#seo-setting" role="tab" aria-controls="contact" aria-selected="false">SEO Setting</a>
                        </li>
                      </ul>
                    </div>
                    <div class="col-12 col-sm-12 col-md-10">
                      <div class="tab-content no-padding" id="myTab2Content">

                         @include('admin.setting.section.general-setting')

                          @include('admin.setting.section.pusher-setting')

                          @include('admin.setting.section.mail-setting')

                          @include('admin.setting.section.seo-setting')


                      </div>
                    </div>
                  </div>
            </div>
        </div>

    </section>
@endsection
