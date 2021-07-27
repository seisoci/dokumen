{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card card-custom">
        <div class="card-header">
          <h3 class="card-title">
            {{ $config['page_title'] }}
          </h3>
        </div>
        <!--begin::Form-->
        <form id="formUpdate" action="{{ route('documents.update', Request::segment(2)) }}">
          <meta name="csrf-token" content="{{ csrf_token() }}">
          @method('PUT')
          <div class="card-body">
            <div class="row">
              <input type="hidden" name="templateDataId" value="{{ $templateDataId }}">
              {!! $renderHtml !!}
            </div>
            <div class="card-footer d-flex justify-content-end">
              <button type="button" class="btn btn-secondary mr-2" onclick="window.history.back();">Cancel</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
        <!--end::Form-->
      </div>
    </div>
  </div>
@endsection

{{-- Styles Section --}}
@section('styles')
  <link rel="stylesheet" href="{{ asset('css/backend/datetimepicker/bootstrap-datetimepicker.css') }}" type="text/css">
  <style>
    .table-responsive {
      overflow-x: inherit;
    }

    .table td {
      position: relative !important;

    }
  </style>
@endsection

{{-- Scripts Section --}}
@section('scripts')
  {{-- vendors --}}
  <script src="{{ asset('js/backend/datetimepicker/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>

  {{-- page scripts --}}
  <script type="text/javascript">
    $(document).ready(function () {
      function initType() {
        $(".decimal").inputmask('decimal', {
          groupSeparator: '.',
          digits: 2,
          rightAlign: true,
          autoUnmask: true,
          allowMinus: false,
          removeMaskOnSubmit: true
        });

        $(".currency").inputmask('decimal', {
          groupSeparator: '.',
          digits: 2,
          rightAlign: true,
          autoUnmask: true,
          allowMinus: false,
          removeMaskOnSubmit: true
        });

        $('.date').datepicker({
          format: 'yyyy-mm-dd',
          todayHighlight: !0,
        });

        $('.datetimepicker').datetimepicker();

        $('.time').timepicker();
      }

      initType();
      {!! $renderJs !!}

      $("#formUpdate").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let btnSubmit = form.find("[type='submit']");
        let btnSubmitHtml = btnSubmit.html();
        let spinner = $('<span role="status" class="spinner-border spinner-border-sm" aria-hidden="true"></span>');
        let url = form.attr("action");
        let data = new FormData(this);
        $.ajax({
          beforeSend: function () {
            btnSubmit.addClass("disabled").html("<i class='fa fa-spinner fa-pulse fa-fw'></i> Loading...").prop("disabled", "disabled");
          },
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
              setTimeout(function () {
                if (response.redirect === "" || response.redirect === "reload") {
                  location.reload();
                } else {
                  location.href = response.redirect;
                }
              }, 1000);
            } else {
              $("[role='alert']").parent().removeAttr("style");
              $(".alert-text").html('');
              $.each(response.error, function (key, value) {
                $(".alert-text").append('<span style="display: block">' + value + '</span>');
              });
              toastr.error("Please complete your form", 'Failed !');
            }
          }, error: function (response) {
            btnSubmit.removeClass("disabled").html(btnSubmitHtml).removeAttr("disabled");
            toastr.error(response.responseJSON.message, 'Failed !');
          }
        });
      });

    });
  </script>
@endsection
