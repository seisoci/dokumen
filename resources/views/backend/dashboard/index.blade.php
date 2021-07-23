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
      </div>
    </div>

    <div class="card-body">
      <!--begin: Datatable-->
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
