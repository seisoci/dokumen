<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {{ Metronic::printAttrs('html') }}
  {{ Metronic::printClasses('html') }}>

<head>
  <meta charset="utf-8" />

  {{-- Title Section --}}
  <title>{{ config('app.name') }} | @yield('title', $config['page_title'] ?? '')</title>

  {{-- Meta Data --}}
  <meta name="description" content="@yield('page_description', $page_description ?? '')" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  {{-- Favicon --}}
  <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />

  {{-- Fonts --}}
  {{ Metronic::getGoogleFontsInclude() }}

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

  {{-- Includable CSS --}}
  @yield('styles')
</head>

<body {{ Metronic::printAttrs('body') }} {{ Metronic::printClasses('body') }}>

  @if (config('layout.page-loader.type') != '')
  @include('layout.partials._page-loader')
  @endif

  @include('layout.base._layout')

  <script>
    let HOST_URL = "";
  </script>

  {{-- Global Config (global config for global JS scripts) --}}
  <script>
    let KTAppSettings = {!! json_encode(config('layout.js'), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) !!};
  </script>

  {{-- Global Theme JS Bundle (used by all pages)  --}}
  @foreach(config('layout.resources.js') as $script)
  <script src="{{ asset($script) }}" type="text/javascript"></script>
  @endforeach

  {{-- Includable JS --}}
  @yield('scripts')
  <script>
    $(document).ready(function () {
      $('#modalChangePassword').on('hidden.bs.modal', function (event) {
        $(this).find('.modal-body').find('input[name="old_password"]').val('');
        $(this).find('.modal-body').find('input[name="password"]').val('');
        $(this).find('.modal-body').find('input[name="password_confirmation"]').val('');
      });

      $("#formChangePassword").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let btnSubmit = form.find("[type='submit']");
        let btnSubmitHtml = btnSubmit.html();
        let url = form.attr("action");
        let data = new FormData(this);
        $.ajax({
          beforeSend: function () {
            btnSubmit.addClass("disabled").html("<i class='fa fa-spinner fa-pulse fa-fw'></i> Loading ...").prop("disabled", "disabled");
          },
          cache: false,
          processData: false,
          contentType: false,
          type: "POST",
          url: url,
          data: data,
          success: function (response) {
            btnSubmit.removeClass("disabled").html(btnSubmitHtml).removeAttr("disabled");
            if (response.status === "success") {
              toastr.success(response.message, 'Success !');
              $('#modalChangePassword').modal('hide');
              dataTable.draw();
            } else {
              $("[role='alert']").parent().removeAttr("style");
              $(".changePassword").html('');
              $.each(response.error, function (key, value) {
                $(".changePassword").append('<span style="display: block">' + value + '</span>');
              });
              toastr.error("Please complete your form", 'Failed !');
            }
          },
          error: function (response) {
            btnSubmit.removeClass("disabled").html(btnSubmitHtml).removeAttr("disabled");
            toastr.error(response.responseJSON.message, 'Failed !');
          }
        });
      });
    });
  </script>
</body>

</html>
