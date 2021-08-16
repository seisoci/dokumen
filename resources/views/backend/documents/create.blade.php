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
        <form id="formStore" action="{{ route('documents.store', $idTemplate) }}">
          @csrf
          <div class="card-body">
            <div class="row">
              {!! $renderHtml !!}
            </div>
            <div class="card-footer d-flex justify-content-end">
              <button type="button" class="btn btn-secondary mr-2" onclick="window.history.back();">Cancel</button>
              <button type="submit" class="btn btn-primary btnSubmit">Submit</button>
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
  <link rel="stylesheet" href="{{ asset('css/backend/croppie/croppie.min.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/backend/datetimepicker/bootstrap-datetimepicker.css') }}" type="text/css">
  <style>
    .table td {
      position: relative !important;

    }
  </style>
@endsection

{{-- Scripts Section --}}
@section('scripts')
  {{-- vendors --}}
  <script src="{{ asset('js/backend/croppie/croppie.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/backend/datetimepicker/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
  {{-- page scripts --}}
  <script type="text/javascript">
    $(document).ready(function () {
      function initType() {
        $(".decimal").inputmask({
          mask: "9{1,}.99",
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
          format: 'dd M yyyy',
          todayHighlight: !0,
        });

        $('.datetimepicker').datetimepicker({
          format: 'DD MMM YYYY HH:mm:ss'
        });

        $('.time').timepicker();
      }

      initType();
      {!! $renderJs !!}

      //   let croopie = {};
      // $(".je_photo").on("change", function () {
      //   let photo = $(this);
      //   if (this.files && this.files[0]) {
      //     let reader = new FileReader();
      //     reader.onload = function (e) {
      //       photo.parent().parent().find(".croppie_image").empty().append("<img src=''>")
      //       photo.parent().parent().find(".croppie_image img").attr("src", e.target.result);
      //       let id = photo.attr('id');
      //         croopie[id] = new Croppie($(".croppie_image img")[0], {
      //         boundary: {width: 300, height: 150},
      //         viewport: {width: 270, height: 130, type: "square"},
      //         showZoomer: true,
      //         enableResize: true,
      //         mouseWheelZoom: "ctrl"
      //       });
      //     }
      //     reader.readAsDataURL(this.files[0]);
      //   }
      // });
      //
      // $(".btnSubmit").click(function () {
      //   console.log(croppieje_photo[1]);
      //   Object.keys(croppieje_photo).forEach(function(key){
      //     croppieje_photo[key].result({type: "base64", size: "original", circle: false})
      //       .then(function (dataImg) {
      //         $("input[name='pengalaman_kerja[1][je_photo]']").val(dataImg);
      //       });
      //   });
      // });

      $("#formStore").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let btnSubmit = form.find("[type='submit']");
        let btnSubmitHtml = btnSubmit.html();
        let url = form.attr("action");
        let formData = new FormData(this);
        $.ajax({
          beforeSend: function () {
            btnSubmit.addClass("disabled").html("<i class='fa fa-spinner fa-pulse fa-fw'></i> Loading ...").prop("disabled", "disabled");
          },
          cache: false,
          processData: false,
          contentType: false,
          type: "POST",
          url: url,
          data: formData,
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
          },
          error: function (response) {
            btnSubmit.removeClass("disabled").html(btnSubmitHtml).removeAttr("disabled");
            toastr.error(response.responseJSON.message, 'Failed !');
          }
        });
      });

    });
  </script>
@endsection
