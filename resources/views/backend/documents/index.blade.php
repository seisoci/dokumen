{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
  <!--begin::Card-->
  <div class="row">
    @foreach($data as $item)
      <div class="col-xl-3">
        <a href="{{ route('documents.show', $item->id) }}">
          <div class="card card-custom bgi-no-repeat card-stretch gutter-b"
               style="background-position: right top; background-size: 30% auto; background-image: url({{ asset('media/svg/shapes/abstract-7.svg') }})">
            <div class="card-body">
              <span class="svg-icon svg-icon-2x svg-icon-primary">
                <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Mail-opened.svg-->
                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                       height="24px"
                       viewBox="0 0 24 24" version="1.1">
                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                          <polygon points="0 0 24 0 24 24 0 24"/>
                          <path
                            d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z"
                            fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                          <rect fill="#000000" x="6" y="11" width="9" height="2" rx="1"/>
                          <rect fill="#000000" x="6" y="15" width="5" height="2" rx="1"/>
                      </g>
                  </svg>
                <!--end::Svg Icon-->
              </span>
              <span
                class="card-title font-weight-bold text-dark-75 font-size-h5 mb-0 mt-6 d-block">{{ $item->name }}</span>
            </div>
          </div>
        </a>
      </div>
    @endforeach
  </div>
  <div class="bg-white d-flex p-4 flex-column align-items-center rounded">
    <span>Halaman {{ $data->currentPage()}} dari {{ $data->lastPage() }}</span>
    {{ $data->links() }}
  </div>
@endsection

{{-- Styles Section --}}
@section('styles')
  <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

{{-- Scripts Section --}}
@section('scripts')
  {{-- vendors --}}
  <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

  {{-- page scripts --}}
  <script src="{{ asset('js/pages/crud/datatables/basic/basic.js') }}" type="text/javascript"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      let dataTable = $('#Datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        order: [[2, 'desc']],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        pageLength: 10,
        ajax: "{{ route('templates.index') }}",
        columns: [
          {data: 'name', name: 'name'},
          {data: 'doc', name: 'doc', orderable: false, className: 'dt-center'},
          {data: 'created_at', name: 'created_at'},
          {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
      });

      $('#modalCreate').on('hidden.bs.modal', function (event) {
        $(this).find('input[name="name"]').val('');
        $(this).find('.custom-file label').text('');
        $("[role='alert']").parent().css('display', 'none');
        $(".alert-text").html('');
        $.each(response.error, function (key, value) {
          $(".alert-text").append('<span style="display: block">' + value + '</span>');
        });
      });

      $('#modalEdit').on('show.bs.modal', function (event) {
        let id = $(event.relatedTarget).data('id');
        let name = $(event.relatedTarget).data('name');
        $(this).find('#formUpdate').attr('action', '{{ route("templates.index") }}/' + id)
        $(this).find('.modal-body').find('input[name="name"]').val(name);
      });

      $('#modalEdit').on('hidden.bs.modal', function (event) {
        $(this).find('input[name="name"]').val('');
        $(this).find('.custom-file label').text('');
        $("[role='alert']").parent().css('display', 'none');
        $(".alert-text").html('');
        $.each(response.error, function (key, value) {
          $(".alert-text").append('<span style="display: block">' + value + '</span>');
        });
      });

      $('#modalDelete').on('show.bs.modal', function (event) {
        let id = $(event.relatedTarget).data('id');
        $(this).find('.modal-body').find('a[name="id"]').attr('href', '{{ route("templates.index") }}/' + id);
      });

      $('#modalDelete').on('hidden.bs.modal', function (event) {
        $(this).find('.modal-body').find('a[name="id"]').attr('href', '');
      });

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
              $('#modalCreate').modal('hide');
              form[0].reset();
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
              $('#modalEdit').modal('hide');
              form[0].reset();
              dataTable.draw();
              $("[role='alert']").parent().css("display", "none");
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
            $('#modalEdit').modal('hide');
            $('#modalEdit').find('a[name="id"]').attr('href', '');
          }
        });
      });

      $("#formDelete").click(function (e) {
        e.preventDefault();
        let form = $(this);
        let url = $('#modalDelete').find('a[name="id"]').attr('href');
        let btnHtml = form.html();
        let spinner = $('<span role="status" class="spinner-border spinner-border-sm" aria-hidden="true"></span>');
        $.ajax({
          beforeSend: function () {
            form.text(' Loading. . .').prepend(spinner);
          },
          type: 'DELETE',
          url: url,
          dataType: 'json',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (response) {
            toastr.success(response.message, 'Success !');
            form.text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm").html(btnHtml);
            $('#modalDelete').modal('hide');
            dataTable.draw();
          },
          error: function (response) {
            toastr.error(response.responseJSON.message, 'Failed !');
            form.text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm").html(btnHtml);
            $('#modalDelete').modal('hide');
            $('#modalDelete').find('a[name="id"]').attr('href', '');
          }
        });
      });

    });
  </script>
@endsection
