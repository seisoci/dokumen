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
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>File Browser</label>
                  <div></div>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="avatar" accept=".jpg,.png,.jpeg">
                    <label class="custom-file-label" for="avatar">Choose file</label>
                  </div>
                </div>
              </div>

              <div class="col-md-12">
                <div id="croppie">
                </div>
                <input type="hidden" name="kuda" id="inputKuda" value="">
              </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
              <button type="button" class="btn btn-secondary mr-2" onclick="window.history.back();">Cancel</button>
              <button type="submit" class="btn btn-primary" id="btnSubmit">Submit</button>
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css"/>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.js" type="text/javascript"></script>
  {{-- page scripts --}}
  <script type="text/javascript">
    $(document).ready(function () {
      let croppie;
      $('#avatar').on('change', function () {
        if (this.files && this.files[0]) {
          let reader = new FileReader();
          reader.onload = function (e) {
            $('#croppie').empty().append('<img src="" alt="">');
            $('#croppie img').attr('src', e.target.result);
            croppie = new Croppie($('#croppie img')[0], {
              boundary: {width: 300, height: 200},
              viewport: {width: 250, height: 50, type: 'square'},
              showZoomer: true,
              enableResize: true,
              enableOrientation: true,
              mouseWheelZoom: 'ctrl'
            })
          }
          reader.readAsDataURL(this.files[0]);
        }
      })

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

      $('#btnSubmit').click(function () {
        croppie.result({type: 'base64', circle: false})
          .then(function (dataImg) {
            $('#inputKuda').val(dataImg);
          });
      });

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
