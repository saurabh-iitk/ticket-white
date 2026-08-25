@extends('layouts.dashboard')

@section('title', 'Edit/Setting')

@section('css')
<style>
/* Enforce Blue Theme on Settings Page vertical tabs */
.user .user-tabs .nav-link {
    border: none !important;
    border-left: 3px solid transparent !important;
    padding: 12px 18px !important;
    font-size: 14.5px !important;
    font-weight: 500 !important;
    color: #475569 !important;
    border-radius: 0 !important;
    background: transparent !important;
    transition: all 0.2s ease;
}

.user .user-tabs .nav-link:hover {
    background-color: #f8fafc !important;
    color: #0f172a !important;
    border-left-color: #cbd5e1 !important;
}

.user .user-tabs .nav-link.active {
    background-color: #eff6ff !important;
    color: #2563eb !important;
    border-left-color: #2563eb !important;
    font-weight: 600 !important;
}

.user .tile {
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
    border-radius: 12px !important;
    overflow: hidden !important;
}
</style>
@endsection

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-cog"></i> Edit Setting </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item active"><a href="{{ route('setting.index') }}">Settings</a></li>
            </ul>
        </div>
        <!-- include message -->
        @include('../../partials/message')
        <!-- include message -->
        <div class="row user">

            <div class="col-md-3">
                <div class="tile p-0">
                    <ul class="nav flex-column nav-tabs user-tabs">
                        <li class="nav-item"><a
                                class="nav-link {{ Request::get('tab') == 'contact-setting' || Request::get('tab') == 'social-media-setting' || Request::get('tab') == 'email-setting' ? '' : 'active' }}"
                                href="#general-setting" data-toggle="tab">General Setting</a></li>
                        <li class="nav-item"><a
                                class="nav-link {{ Request::get('tab') == 'contact-setting' ? 'active' : '' }}"
                                href="#contact-setting" data-toggle="tab">Contact Setting</a></li>
                        <li class="nav-item"><a
                                class="nav-link {{ Request::get('tab') == 'social-media-setting' ? 'active' : '' }}"
                                href="#social-media-setting" data-toggle="tab">Social Media Setting</a></li>
                        <li class="nav-item"><a
                                class="nav-link {{ Request::get('tab') == 'email-setting' ? 'active' : '' }}"
                                href="#email-setting" data-toggle="tab">Email Setting</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content">

                    <div class="tab-pane {{ Request::get('tab') == 'contact-setting' || Request::get('tab') == 'social-media-setting' || Request::get('tab') == 'email-setting' ? '' : 'active' }}"
                        id="general-setting">
                        <div class="tile user-settings">
                            <h4 class="line-head">General Setting</h4>
                            <form action="setting/{{ $setting->id }}" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="PUT">
                            @csrf
                            <div class="row">
                                <div class="col-md-8 mb-4">
                                    <label>Site Title</label>
                                    <input class="form-control" type="text" value="{{ $setting->site_title }}"
                                        name="site_title" placeholder="Site Title">
                                </div>
                                <div class="col-md-8 mb-4">
                                    <label>Home Title</label>
                                    <input class="form-control" type="text" value="{{ $setting->home_title }}"
                                        name="home_title" placeholder="Home Title">
                                </div>
                                <div class="col-md-8 mb-4">
                                    <label>Copyright</label>
                                    <textarea class="form-control" name="copyright" rows="2" placeholder="Copyright">{{ $setting->copyright }}</textarea>
                                </div>

                                <div class="col-md-8 mb-4">
                                    <label>Mobile No Mandatory Lock in Booking</label>
                                    <select name="mobile_mandatory" class="form-control">
                                        <option value="YES" @if ($setting->mobile_mandatory == 'YES') {{ 'selected' }} @endif>
                                            YES</option>
                                        <option value="NO"
                                            @if ($setting->mobile_mandatory == 'NO') {{ 'selected' }} @endif>NO</option>
                                    </select>
                                </div>
           
                                
                                 <div class="col-md-8 mb-4">
                                    <label>Main Banner</label>
                                    <input  type="file" name="main_banner" placeholder="Main Banner">
                                </div>
                                
                                
                                <div class="col-md-8 mb-4">
                                    <label>Ticket Logo</label>
                                    <input  type="file"  name="ticket_logo" placeholder="Ticket Logo">
                                    
                                </div>

                                <div class="col-md-12">
                                    <input type="hidden" name="general_setting" value="general_setting">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="fa fa-fw fa-lg fa-check-circle"></i> Save</button>

                                    <a href="{{ route('setting.index') }}" class="btn btn-danger pl-4 pr-4">Back</a>

                                </div>
                            
                            </div>
                            </form>
                        </div>
                    </div>

                        <div class="tab-pane fade {{ Request::get('tab') == 'contact-setting' ? 'active show' : '' }}"
                            id="contact-setting">
                            <div class="tile user-settings">
                                <h4 class="line-head">Contact Setting</h4>
                                <form action="setting/{{ $setting->id }}" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="PUT">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8 mb-4">
                                        <label>Address</label>
                                        <input class="form-control" type="text" value="{{ $setting->contact_address }}"
                                            name="contact_address" placeholder="Address">
                                    </div>
                                    <div class="col-md-8 mb-4">
                                        <label>Email</label>
                                        <input class="form-control" type="text" value="{{ $setting->contact_email }}"
                                            name="contact_email" placeholder="Email">
                                    </div>
                                    <div class="col-md-8 mb-4">
                                        <label>Phone</label>
                                        <input class="form-control" type="text" value="{{ $setting->contact_phone }}"
                                            name="contact_phone" placeholder="Phone">
                                    </div>
                                </div>

                                <div class="row mb-10">
                                    <div class="col-md-12">
                                        <input type="hidden" name="contact_setting" value="contact_setting">
                                        <a href="{{ route('setting.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                                        <button class="btn btn-primary" type="submit"><i
                                                class="fa fa-fw fa-lg fa-check-circle"></i> Save</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane fade {{ Request::get('tab') == 'social-media-setting' ? 'active show' : '' }}"
                            id="social-media-setting">
                            <div class="tile user-settings">
                                <h4 class="line-head">Social Media Setting</h4>
                                <form action="{{ url('setting/' . $setting->id)}}" method="POST">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-md-8 mb-4">
                                        <label>Facebook Url</label>
                                        <input class="form-control" type="text" value="{{ $setting->facebook_url }}"
                                            name="facebook_url" placeholder="Facebook Url">
                                    </div>
                                    <div class="col-md-8 mb-4">
                                        <label>Twitter Url</label>
                                        <input class="form-control" type="text" value="{{ $setting->twitter_url }}"
                                            name="twitter_url" placeholder="Twitter Url">
                                    </div>
                                    <div class="col-md-8 mb-4">
                                        <label>Google Url</label>
                                        <input class="form-control" type="text" value="{{ $setting->google_url }}"
                                            name="google_url" placeholder="Google Url">
                                    </div>
                                    <div class="col-md-8 mb-4">
                                        <label>Instagram Url</label>
                                        <input class="form-control" type="text" value="{{ $setting->instagram_url }}"
                                            name="instagram_url" placeholder="Instagram Url">
                                    </div>
                                    <div class="col-md-8 mb-4">
                                        <label>Pinterest Url</label>
                                        <input class="form-control" type="text" value="{{ $setting->pinterest_url }}"
                                            name="pinterest_url" placeholder="Pinterest Url">
                                    </div>
                                    <div class="col-md-8 mb-4">
                                        <label>LinkedIn Url</label>
                                        <input class="form-control" type="text" value="{{ $setting->linkedin_url }}"
                                            name="linkedin_url" placeholder="LinkedIn Url">
                                    </div>
                                    <div class="col-md-8 mb-4">
                                        <label>VK Url</label>
                                        <input class="form-control" type="text" value="{{ $setting->vk_url }}"
                                            name="vk_url" placeholder="VK Url">
                                    </div>
                                    <div class="col-md-8 mb-4">
                                        <label>Youtube Url</label>
                                        <input class="form-control" type="text" value="{{ $setting->youtube_url }}"
                                            name="youtube_url" placeholder="Youtube Url">
                                    </div>
                                </div>

                                <div class="row mb-10">
                                    <div class="col-md-12">
                                        <input type="hidden" name="social_media_setting" value="social_media_setting">
                                        <a href="{{ route('setting.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                                        <button class="btn btn-primary" type="submit"><i
                                                class="fa fa-fw fa-lg fa-check-circle"></i> Save</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane fade {{ Request::get('tab') == 'email-setting' ? 'active show' : '' }}"
                            id="email-setting">
                            <div class="tile user-settings">
                                <h4 class="line-head">Email Setting</h4>
                                <form action="{{ url('setting/' . $setting->id)}}" method="POST">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-md-8 mb-4">
                                        <label>Mail Protocol</label>
                                        <select class="form-control" name="mail_protocol">
                                            <option value="smtp" <?php if ($setting->mail_protocol == 'smtp') {
                                                echo 'selected';
                                            } ?>>SMTP</option>
                                            <option value="mail" <?php if ($setting->mail_protocol == 'mail') {
                                                echo 'selected';
                                            } ?>>Mail</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8 mb-4">
                                        <label>Mail Title</label>
                                        <input class="form-control" type="text" value="{{ $setting->mail_title }}"
                                            name="mail_title" placeholder="Mail Title">
                                    </div>
                                    <div class="col-md-8 mb-4">
                                        <label>Mail Host</label>
                                        <input class="form-control" type="text" value="{{ $setting->mail_host }}"
                                            name="mail_host" placeholder="Mail Host">
                                    </div>
                                    <div class="col-md-8 mb-4">
                                        <label>Mail Port</label>
                                        <input class="form-control" type="text" value="{{ $setting->mail_port }}"
                                            name="mail_port" placeholder="Mail Port">
                                    </div>
                                    <div class="col-md-8 mb-4">
                                        <label>Mail Username</label>
                                        <input class="form-control" type="text" value="{{ $setting->mail_username }}"
                                            name="mail_username" placeholder="Mail Username">
                                    </div>
                                    <div class="col-md-8 mb-4">
                                        <label>Mail Password</label>
                                        <input class="form-control" type="text" value="{{ $setting->mail_password }}"
                                            name="mail_password" placeholder="Mail Password">
                                    </div>
                                </div>

                                <div class="row mb-10">
                                    <div class="col-md-12">
                                        <input type="hidden" name="email_setting" value="email_setting">
                                        <a href="{{ route('setting.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                                        <button class="btn btn-primary" type="submit"><i
                                                class="fa fa-fw fa-lg fa-check-circle"></i> Save</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </main>
@endsection