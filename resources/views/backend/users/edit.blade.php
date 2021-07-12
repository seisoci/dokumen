{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
  <div class="row">
    <div class="col-md-6">
      <div class="card card-custom">
        <div class="card-header">
          <h3 class="card-title">
            {{ $config['page_title'] }}
          </h3>
        </div>
        <!--begin::Form-->
        <form id="formUpdate" action="{{ route('users.update', Request::segment(3)) }}">
          <meta name="csrf-token" content="{{ csrf_token() }}">
          @method('PUT')
          <div class="card-body">
            <div class="form-group" style="display:none;">
              <div class="alert alert-custom alert-light-danger" role="alert">
                <div class="alert-icon"><i class="flaticon-danger text-danger"></i></div>
                <div class="alert-text">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="image-input" id="kt_image_2" style="asset('/media/users/blank.png')">
                <div class="image-input-wrapper"
                     style="background-image: url({{ $data['user']->image != NULL ? asset("/images/original/".$data['user']->image) : asset('media/users/blank.png') }})">
                </div>
                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                       data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                  <i class="fa fa-pen icon-sm text-muted"></i>
                  <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg"/>
                  <input type="hidden" name="profile_avatar_remove"/>
                </label>
                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                      data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                <i class="ki ki-bold-close icon-xs text-muted"></i>
              </span>
              </div>
              <span class="form-text text-muted">Maximum file 2 MB and format png, jpg, jpeg</span>
            </div>
            <div class="form-group">
              <label>Nama Lengkap <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" placeholder="Enter name"
                     value="{{ $data['user']->name ?? '' }}"/>
            </div>
            <div class="form-group">
              <label>Username <span class="text-danger">*</span></label>
              <input type="text" name="username" class="form-control" placeholder="Enter Username"
                     value="{{ $data['user']->username ?? '' }}"/>
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="text" name="email" class="form-control" placeholder="Enter email"
                     value="{{ $data['user']->email ?? '' }}"/>
            </div>
            <div class="form-group">
              <label for="activeSelect">Status Pengguna <span class="text-danger">*</span></label>
              <select class="form-control" id="activeSelect" name="active">
                <option value="0" {{ $data['user']->active == 0 ? 'selected' : NULL }}>Tidak Aktif</option>
                <option value="1" {{ $data['user']->active == 1 ? 'selected' : NULL }}>Aktif</option>
              </select>
            </div>
            @if(in_array($logInUser, ['super-admin', 'admin']))
            <div class="form-group">
              <label for="roleSelect">Role <span class="text-danger">*</span></label>
              <select class="form-control" id="roleSelect" name="role">
                @foreach ($data['roles'] ?? array() as $item)
                  <option value="{{ $item->name }}">{{ ucfirst($item->name) }}</option>
                @endforeach
              </select>
            </div>
            @endif
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
@endsection

{{-- Scripts Section --}}
@section('scripts')
  {{-- vendors --}}

  {{-- page scripts --}}
  <script type="text/javascript">
    $(document).ready(function () {
      new KTImageInput('kt_image_2');

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
                location.reload();
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
