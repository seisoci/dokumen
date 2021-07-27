{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
  {{-- Dashboard 1 --}}
  <!--begin::Card-->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <div class="card card-custom">
    <div class="card-header flex-wrap py-3">
      <div class="card-title">
        <h3 class="card-label">{{ $config['page_title'] }}
          <span class="d-block text-muted pt-2 font-size-sm">{{ $config['page_description'] }}</span></h3>
      </div>
      <div class="card-toolbar">
        <!--begin::Button-->
        <a href="{{ route('documents.create', $id) }}" class="btn btn-primary font-weight-bolder">
        <span class="svg-icon svg-icon-md">
          <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
               viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
              <rect x="0" y="0" width="24" height="24"></rect>
              <circle fill="#000000" cx="9" cy="15" r="6"></circle>
              <path
                d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                fill="#000000" opacity="0.3"></path>
            </g>
          </svg>
          <!--end::Svg Icon-->
        </span>Tambah</a>
        <!--end::Button-->
      </div>
    </div>
    <div class="card-body">
      <div class="mb-10">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="search">Search</label>
              <input id="search" type="text" class="form-control input-sm">
            </div>
          </div>
          <div class="col-md-3 text-center offset-md-6 text-md-right">
            <a href="#" class="btn btn-success font-weight-bolder">
            <span class="svg-icon svg-icon-md">
              <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
               <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                      <rect x="0" y="0" width="24" height="24"/>
                      <path d="M2,13 C2,12.5 2.5,12 3,12 C3.5,12 4,12.5 4,13 C4,13.3333333 4,15 4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 C2,15 2,13.3333333 2,13 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                      <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 8.000000) rotate(-180.000000) translate(-12.000000, -8.000000) " x="11" y="1" width="2" height="14" rx="1"/>
                      <path d="M7.70710678,15.7071068 C7.31658249,16.0976311 6.68341751,16.0976311 6.29289322,15.7071068 C5.90236893,15.3165825 5.90236893,14.6834175 6.29289322,14.2928932 L11.2928932,9.29289322 C11.6689749,8.91681153 12.2736364,8.90091039 12.6689647,9.25670585 L17.6689647,13.7567059 C18.0794748,14.1261649 18.1127532,14.7584547 17.7432941,15.1689647 C17.3738351,15.5794748 16.7415453,15.6127532 16.3310353,15.2432941 L12.0362375,11.3779761 L7.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000004, 12.499999) rotate(-180.000000) translate(-12.000004, -12.499999) "/>
                  </g>
              </svg>
              <!--end::Svg Icon-->
            </span>Generate Batch</a>
          </div>
        </div>
        <!--begin: Datatable-->
        <table class="table table-bordered table-hover table-checkable" id="Datatable">
          <thead>
          <tr>
            @foreach($datatable['html'] as $item)
              {!! $item !!}
            @endforeach
          </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <div class="modal fade text-left" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel"
       aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalDeleteLabel">Hapus</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i aria-hidden="true" class="ki ki-close"></i>
          </button>
        </div>
        @method('DELETE')
        <div class="modal-body">
          <a href="" type="hidden" name="id" disabled></a>
          Anda yakin ingin menghapus data ini?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="formDelete" type="button" class="btn btn-danger">Accept</button>
        </div>
      </div>
    </div>
  </div>

@endsection

{{-- Styles Section --}}
@section('styles')
  <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('css/backend/datatables/dataTables.checkboxes.css') }}" rel="stylesheet" type="text/css"/>
@endsection

{{-- Scripts Section --}}
@section('scripts')
  {{-- vendors --}}
  <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/backend/datatables/dataTables.checkboxes.js') }}" type="text/javascript"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      let dataTable = $('#Datatable').DataTable({
        responsive: {!! $datatable['js']['responsive'] !!},
        processing: {!! $datatable['js']['processing'] !!},
        dom: `<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
        scrollX: {!! $datatable['js']['scrollX'] !!},
        searching: {!! $datatable['js']['searching'] !!},
        ordering: {!! $datatable['js']['ordering'] !!},
        serverSide: {!! $datatable['js']['serverSide'] !!},
        order: [0, 'asc'],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        pageLength: {!! $datatable['js']['pageLength'] !!},
        ajax: {
          url: "{!! $datatable['js']['ajax'] !!}",
          data: function (d) {
            d.value = $('#search').val();
          }
        },
        columns: [
          @foreach($datatable['js']['column'] as $item)
            {!! $item !!}
            @endforeach
        ],
        columnDefs: [
          {
            targets: 0,
            checkboxes: {
              selectRow: true
            }
          },
        ],
        select: {
          style: 'multi'
        },
      });

      let debounce = function (func, wait, immediate) {
        let timeout;
        return function () {
          let context = this, args = arguments;
          let later = function () {
            timeout = null;
            if (!immediate) func.apply(context, args);
          };
          let callNow = immediate && !timeout;
          clearTimeout(timeout);
          timeout = setTimeout(later, wait);
          if (callNow) func.apply(context, args);
        };
      };

      $('#search').keyup(debounce(function () {
        dataTable.draw();
      }, 500));

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
        $(this).find('.modal-body').find('a[name="id"]').attr('href', '{{ route("documents.index") }}/' + id);
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
