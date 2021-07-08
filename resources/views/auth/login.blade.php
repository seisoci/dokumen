{{-- @extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Login') }}</div>

<div class="card-body">
  <form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="form-group row">
      <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

      <div class="col-md-6">
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
          value="{{ old('email') }}" required autocomplete="email" autofocus>

        @error('email')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
    </div>

    <div class="form-group row">
      <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

      <div class="col-md-6">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
          name="password" required autocomplete="current-password">

        @error('password')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
    </div>

    <div class="form-group row">
      <div class="col-md-6 offset-md-4">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="remember" id="remember"
            {{ old('remember') ? 'checked' : '' }}>

          <label class="form-check-label" for="remember">
            {{ __('Remember Me') }}
          </label>
        </div>
      </div>
    </div>

    <div class="form-group row mb-0">
      <div class="col-md-8 offset-md-4">
        <button type="submit" class="btn btn-primary">
          {{ __('Login') }}
        </button>

        @if (Route::has('password.request'))
        <a class="btn btn-link" href="{{ route('password.request') }}">
          {{ __('Forgot Your Password?') }}
        </a>
        @endif
      </div>
    </div>
  </form>
</div>
</div>
</div>
</div>
</div>
@endsection --}}



<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
  <base href="../../../../">
  <meta charset="utf-8" />
  <title>Sign In</title>
  <meta name="description" content="Singin page example" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link href="{{ asset('css/pages/login/login-3.css') }}" rel="stylesheet" type="text/css" />
  {{-- Global Theme Styles (used by all pages) --}}
  @foreach(config('layout.resources.css') as $style)
  <link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($style)) : asset($style) }}" rel="stylesheet"
    type="text/css" />
  @endforeach

  {{-- Layout Themes (used by all pages) --}}
  @foreach (Metronic::initThemes() as $theme)
  <link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($theme)) : asset($theme) }}" rel="stylesheet"
    type="text/css" />
  @endforeach
  <!--end::Layout Themes-->
  <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body"
  class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
  <!--begin::Main-->
  <div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-3 wizard d-flex flex-column flex-lg-row flex-column-fluid">
      <!--begin::Aside-->
      <div class="login-aside d-flex flex-column flex-row-auto">
        <!--begin::Aside Top-->
        <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
          <!--begin::Aside Title-->
          <h3 class="font-weight-bolder text-center font-size-h4 text-dark-50 line-height-xl">User Experience &amp;
            Interface Design
            <br />Strategy SaaS Solutions</h3>
          <!--end::Aside Title-->
        </div>
        <!--end::Aside Top-->
        <!--begin::Aside Bottom-->
        <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-x-center"
          style="background-position-y: calc(100% + 5rem); background-image: url(/media/svg/illustrations/login-visual-5.svg)">
        </div>
        <!--end::Aside Bottom-->
      </div>
      <!--begin::Aside-->
      <!--begin::Content-->
      <div class="login-content flex-row-fluid d-flex flex-column p-10">
        <!--begin::Wrapper-->
        <div class="d-flex flex-row-fluid flex-center">
          <!--begin::Signin-->
          <div class="login-form">
            <!--begin::Form-->
            <form class="form" id="kt_login_singin_form" method="POST" action="{{ route('login') }}">
              @csrf
              <!--begin::Title-->
              <div class="pb-5 pb-lg-15">
                <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Sign In</h3>
              </div>
              <!--begin::Title-->
              <!--begin::Form group-->
              <div class="form-group">
                <label class="font-size-h6 font-weight-bolder text-dark">Your Username</label>


                <input id="username" type="text"
                  class="form-control h-auto py-7 px-6 rounded-lg border-0 @error('email') is-invalid @enderror"
                  name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                @error('username')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <!--end::Form group-->
              <!--begin::Form group-->
              <div class="form-group">
                <div class="d-flex justify-content-between mt-n5">
                  <label class="font-size-h6 font-weight-bolder text-dark pt-5">Your Password</label>

                </div>
                <input id="password" type="password"
                  class="form-control h-auto py-7 px-6 rounded-lg border-0 @error('password') is-invalid @enderror"
                  name="password" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <!--end::Form group-->
              <!--begin::Action-->
              <div class="pb-lg-0 pb-5">
                <button type="submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">
                  {{ __('Login') }}
                </button>
              </div>
              <!--end::Action-->
            </form>
            <!--end::Form-->
          </div>
          <!--end::Signin-->
        </div>
        <!--end::Wrapper-->
      </div>
      <!--end::Content-->
    </div>
    <!--end::Login-->
  </div>
  <!--end::Main-->
  <!--begin::Global Config(global config for global JS scripts)-->
  <script>
    var KTAppSettings = {!! json_encode(config('layout.js'), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) !!};
  </script>
  <!--end::Global Config-->
  <!--begin::Global Theme Bundle(used by all pages)-->
  {{-- Global Theme JS Bundle (used by all pages)  --}}
  @foreach(config('layout.resources.js') as $script)
  <script src="{{ asset($script) }}" type="text/javascript"></script>
  @endforeach
  <!--end::Page Scripts-->
</body>
<!--end::Body-->

</html>
