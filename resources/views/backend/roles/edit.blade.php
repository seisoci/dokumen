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
      <form id="formUpdate" action="{{ route('roles.update', Request::segment(2)) }}">
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
            <label>Role Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="Enter name" value="{{ $data->name }}" />
          </div>
          <div class="form-group">
            <label>List Permission</label>
            <div class="checkbox-list">
              @foreach($permission as $value)
              <label class="checkbox">
                <input type="checkbox" name="permission[]" value="{{ $value->id }}"
                  {{ in_array($value->id, $rolePermissions) ? 'checked' : NULL }} />
                {{ ucwords($value->name) }}
              </label>
              @endforeach
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary mr-2">Submit</button>
            <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
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
  $(document).ready(function(){
    $("#formUpdate").submit(function(e){
      e.preventDefault();
      var form 	= $(this);
      var btnSubmit = form.find("[type='submit']");
      var btnSubmitHtml = btnSubmit.html();
      var spinner = $('<span role="status" class="spinner-border spinner-border-sm" aria-hidden="true"></span>');
      var url 	= form.attr("action");
      var data 	= new FormData(this);
      $.ajax({
        beforeSend:function() {
          btnSubmit.addClass("disabled").html("<i class='fa fa-spinner fa-pulse fa-fw'></i> Loading...").prop("disabled","disabled");
        },
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        cache: false,
        processData: false,
        contentType: false,
        type: "POST",
        url : url,
        data : data,
        success: function(response) {
          btnSubmit.removeClass("disabled").html(btnSubmitHtml).removeAttr("disabled");
          if ( response.status == "success" ){
            toastr.success(response.message,'Success !');
            setTimeout(function() {
                window.location.href = response.redirect;
            }, 1000);
          }else{
            $("[role='alert']").parent().removeAttr("style");
            $(".alert-text").html('');
            $.each( response.error, function( key, value ) {
              $(".alert-text").append('<span style="display: block">'+value+'</span>');
            });
            toastr.error("Please complete your form",'Failed !');
          }
        },error: function(response){
            btnSubmit.removeClass("disabled").html(btnSubmitHtml).removeAttr("disabled");
            toastr.error(response.responseJSON.message, 'Failed !');
        }
      });
    });
  });
</script>
@endsection
