{{-- Footer --}}

<div class="footer bg-white py-4 d-flex flex-lg-column {{ Metronic::printClasses('footer', false) }}" id="kt_footer">
  {{-- Container --}}
  <div
    class="{{ Metronic::printClasses('footer-container', false) }} d-flex flex-column flex-md-row align-items-center justify-content-between">
    {{-- Copyright --}}
    <div class="text-dark order-2 order-md-1">
      <span class="text-muted font-weight-bold mr-2">2021 &copy;</span>
      <a href="https://ginktech.net"  target="_blank"  class="text-dark-75 text-hover-primary">Gink Techonology</a>
    </div>

    {{-- Nav --}}
    <div class="nav nav-dark order-1 order-md-2">
    </div>
  </div>
</div>
<div class="modal fade" id="modalChangePassword" tabindex="-1" role="dialog" aria-labelledby="modalChangePasswordLabel"
     aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalResetLabel">Ubah Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <div class="form-group m-4" style="display:none;">
        <div class="alert alert-custom alert-light-danger d-block changePassword" role="alert">
          <div class="alert-icon"><i class="flaticon-danger text-danger"></i></div>
          <div class="alert-text">
          </div>
        </div>
      </div>
      <form id="formChangePassword" method="POST" action="{{ route('users.changepassword') }}">
        <div class="modal-body">
          @csrf
          <div class="form-group">
            <label>Old Password <span class="text-danger">*</span></label>
            <input type="password" name="old_password" class="form-control" placeholder="Input password lama"/>
          </div>
          <div class="form-group">
            <label>Password Baru<span class="text-danger">*</span></label>
            <input type="password" name="password" class="form-control" placeholder="Input password baru"/>
          </div>
          <div class="form-group">
            <label>Retype Password Baru<span class="text-danger">*</span></label>
            <input type="password" name="password_confirmation" class="form-control"
                   placeholder="Input password baru kembali"/>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary font-weight-bold">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

