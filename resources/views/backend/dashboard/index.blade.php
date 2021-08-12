{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
  {{-- Dashboard 1 --}}
  <!--begin::Card-->
  <div class="row">
    <div class="col-xl-4">
      <!--begin::Stats Widget 30-->
      <div class="card card-custom bg-info card-stretch gutter-b">
        <!--begin::Body-->
        <div class="card-body">
              <span class="svg-icon svg-icon-3x svg-icon-white">
                <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Group.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <polygon points="0 0 24 0 24 24 0 24"></polygon>
                    <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                    <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>
                  </g>
                </svg>
                <!--end::Svg Icon-->
              </span>
          <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block">{{ $totalUser ?? 0 }}</span>
          <span class="font-weight-bold text-white font-size-sm">Total User</span>
        </div>
        <!--end::Body-->
      </div>
      <!--end::Stats Widget 30-->
    </div>
    <div class="col-xl-4">
      <!--begin::Stats Widget 30-->
      <div class="card card-custom bg-success card-stretch gutter-b">
        <!--begin::Body-->
        <div class="card-body">
          <!--begin::Svg Icon-->
          <span class="svg-icon svg-icon-3x svg-icon-white">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <polygon points="0 0 24 0 24 24 0 24"/>
                <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                <rect fill="#000000" x="6" y="11" width="9" height="2" rx="1"/>
                <rect fill="#000000" x="6" y="15" width="5" height="2" rx="1"/>
              </g>
            </svg>
          </span>
            <!--end::Svg Icon-->
          <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block">{{ $totalTemplate ?? 0 }}</span>
          <span class="font-weight-bold text-white font-size-sm">Total Template</span>
        </div>
        <!--end::Body-->
      </div>
      <!--end::Stats Widget 30-->
    </div>
    <div class="col-xl-4">
      <!--begin::Stats Widget 30-->
      <div class="card card-custom bg-danger card-stretch gutter-b">
        <!--begin::Body-->
        <div class="card-body">
          <!--begin::Svg Icon-->
          <span class="svg-icon svg-icon-3x svg-icon-white">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect x="0" y="0" width="24" height="24"/>
                <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                <path d="M16.7689447,7.81768175 C17.1457787,7.41393107 17.7785676,7.39211077 18.1823183,7.76894473 C18.5860689,8.1457787 18.6078892,8.77856757 18.2310553,9.18231825 L11.2310553,16.6823183 C10.8654446,17.0740439 10.2560456,17.107974 9.84920863,16.7592566 L6.34920863,13.7592566 C5.92988278,13.3998345 5.88132125,12.7685345 6.2407434,12.3492086 C6.60016555,11.9298828 7.23146553,11.8813212 7.65079137,12.2407434 L10.4229928,14.616916 L16.7689447,7.81768175 Z" fill="#000000" fill-rule="nonzero"/>
              </g>
            </svg>
          </span>
          <!--end::Svg Icon-->
          <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block">{{ $totalData ?? 0 }}</span>
          <span class="font-weight-bold text-white font-size-sm">Total Data</span>
        </div>
        <!--end::Body-->
      </div>
      <!--end::Stats Widget 30-->
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
