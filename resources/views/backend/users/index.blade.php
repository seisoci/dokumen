{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
{{-- Dashboard 1 --}}
<!--begin::Card-->
<div class="card card-custom">
  <div class="card-header flex-wrap py-3">
    <div class="card-title">
      <h3 class="card-label">{{ $config['page_title'] }}
        <span class="d-block text-muted pt-2 font-size-sm">{{ $config['page_description'] }}</span></h3>
    </div>
    <div class="card-toolbar">
      <!--begin::Button-->
      <a href="{{ route('users.create') }}" class="btn btn-primary font-weight-bolder">
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
    <!--begin: Datatable-->
    <table class="table table-bordered table-hover table-checkable" id="Datatable">
      <thead>
        <tr>
          <th>Image</th>
          <th>Nama</th>
          <th>Role</th>
          <th>Username</th>
          <th>Email</th>
          <th>Active</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
<div class="modal fade" id="modalReset" tabindex="-1" role="dialog" aria-labelledby="modalResetLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalResetLabel">Reset Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <form id="formReset" method="POST" action="{{ route('users.resetpassword') }}">
        <div class="modal-body">
          @csrf
          <input type="hidden" name="id"></a>
          Are you sure you want to reset password default? <br> (password same with username)
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary font-weight-bold">Submit</button>
        </div>
      </form>
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
      <meta name="csrf-token" content="{{ csrf_token() }}">
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
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Scripts Section --}}
@section('scripts')
{{-- vendors --}}
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function(){
    let dataTable = $('#Datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        order: [[1, 'desc']],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        pageLength: 10,
        ajax: "{{ route('users.index') }}",
        columns: [
            {data: 'image', name: 'image'},
            {data: 'name', name: 'name'},
            {data: 'roles', name: 'roles'},
            {data: 'username', name: 'username'},
            {data: 'email', name: 'email'},
            {data: 'active', name: 'active'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [
        {
          className: 'dt-center',
          orderable: false,
          targets: 0,
          render: function(data, type, full, meta) {
            return `
              <div class="symbol symbol-80">
                <img src="` + data + `" alt="photo">
              </div>`;
          }
        },
        {
          className: 'dt-center',
          targets: 5,
          width: '75px',
          render: function(data, type, full, meta) {
            let status = {
              0: {'title': 'Inactive', 'class': ' label-light-danger'},
              1: {'title': 'Active', 'class': ' label-light-success'},
            };
            if (typeof status[data] === 'undefined') {
              return data;
            }
            return '<span class="label label-lg font-weight-bold' + status[data].class + ' label-inline">' + status[data].title +
              '</span>';
            },
          },
        ],
    });


    $('#modalReset').on('show.bs.modal', function (event) {
      let id = $(event.relatedTarget).data('id');
      $(this).find('.modal-body').find('input[name="id"]').val(id);
    });

    $('#modalReset').on('hidden.bs.modal', function (event) {
      $(this).find('.modal-body').find('input[name="id"]').val('');
    });

    $('#modalDelete').on('show.bs.modal', function (event) {
      let id = $(event.relatedTarget).data('id');
      $(this).find('.modal-body').find('a[name="id"]').attr('href', '{{ route("users.index") }}/'+ id);
    });

    $('#modalDelete').on('hidden.bs.modal', function (event) {
      $(this).find('.modal-body').find('a[name="id"]').attr('href', '');
    });

    $("#formReset").submit(function(e){
      e.preventDefault();
      let form = $(this);
      let btnSubmit = form.find("[type='submit']");
      let btnSubmitHtml = btnSubmit.html();
      let url = form.attr("action");
      let data = new FormData(this);
      $.ajax({
        beforeSend:function() {
          btnSubmit.addClass("disabled").html("<i class='fa fa-spinner fa-pulse fa-fw'></i> Loading ...").prop("disabled","disabled");
        },
        cache: false,
        processData: false,
        contentType: false,
        type: "POST",
        url : url,
        data : data,
        success: function(response) {
          btnSubmit.removeClass("disabled").html(btnSubmitHtml).removeAttr("disabled");
          if (response.status === "success") {
            toastr.success(response.message, 'Success !');
            $('#modalReset').modal('hide');
            dataTable.draw();
          } else {
            $("[role='alert']").parent().removeAttr("style");
            $(".alert-text").html('');
            $.each(response.error, function(key, value) {
              $(".alert-text").append('<span style="display: block">'+value+'</span>');
            });
            toastr.error("Please complete your form", 'Failed !');
          }
        },
        error: function(response) {
          btnSubmit.removeClass("disabled").html(btnSubmitHtml).removeAttr("disabled");
          toastr.error(response.responseJSON.message, 'Failed !');
        }
      });
    });

    $("#formDelete").click(function(e){
      e.preventDefault();
      let form 	    = $(this);
      let url 	    = $('#modalDelete').find('a[name="id"]').attr('href');
      let btnHtml   = form.html();
      let spinner   = $('<span role="status" class="spinner-border spinner-border-sm" aria-hidden="true"></span>');
      $.ajax({
          beforeSend:function() {
            form.text(' Loading. . .').prepend(spinner);
          },
          type: 'DELETE',
          url: url,
          dataType: 'json',
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          success: function (response) {
            toastr.success(response.message,'Success !');
            form.text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm").html(btnHtml);
            $('#modalDelete').modal('hide');
            dataTable.draw();
          },
          error: function (response) {
            toastr.error(response.responseJSON.message ,'Failed !');
            form.text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm").html(btnHtml);
            $('#modalDelete').modal('hide');
            $('#modalDelete').find('a[name="id"]').attr('href', '');
          }
      });
    });
  });
</script>
@endsection
