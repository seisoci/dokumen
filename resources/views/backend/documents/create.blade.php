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
        <form id="formStore" action="{{ route('documents.store') }}">
          @csrf
          <div class="card-body">
            {!! $renderHtml !!}
            <div class="card-footer">
              <button type="submit" class="btn btn-primary mr-2">Submit</button>
              <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
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
          digits: 0,
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

      // $(".add").on('click', function () {
      //   let total_items = $(".items").length;
      //   let lastid = $(".items:last").attr("id");
      //   let split_id = lastid.split("_");
      //   let nextindex = Number(split_id[1]) + 1;
      //   let max = 100;
      //   if (total_items < max) {
      //     $(".items:last").after("<tr class='items' id='items_" + nextindex + "'></tr>");
      //     $("#items_" + nextindex).append(
      //       "<td><button type='button' id='items_" + nextindex + "' class='btn btn-block btn-danger rmItems'>-</button></td>" +
      //       '<td><input type="text" name="formoption[value][]" class="form-control"/></td>' +
      //       '<td><input type="text" name="formoption[text][]" class="form-control"/></td>' +
      //       '<td class="d-flex justify-content-center align-items-center">' +
      //       '<div class="form-control" style="border: none">' +
      //       '<input type="checkbox" name="formoption[selected][]" class="w-20px h-20px yes" value="1">' +
      //       '<input type="checkbox" name="formoption[selected][]" value="0" checked class="no" style="display: none">' +
      //       '</div>' +
      //       '</td>'
      //     );
      //   }
      //   // initSelected();
      // });

      // $('tbody').on('click', '.rmItems', function () {
      //   let id = this.id;
      //   let split_id = id.split("_");
      //   let deleteindex = split_id[1];
      //   $("#items_" + deleteindex).remove();
      // });

      $("#formStore").submit(function (e) {
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
