@php
$direction = config('layout.extras.user.offcanvas.direction', 'right');
@endphp
{{-- User Panel --}}
<div id="kt_quick_user" class="offcanvas offcanvas-{{ $direction }} p-10">
  {{-- Header --}}
  <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
    <h3 class="font-weight-bold m-0">
      User Profile
    </h3>
    <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
      <i class="ki ki-close icon-xs text-muted"></i>
    </a>
  </div>

  {{-- Content --}}
  <div class="offcanvas-content pr-5 mr-n5">
    {{-- Header --}}
    <div class="d-flex align-items-center mt-5">
      <div class="symbol symbol-100 mr-5">
        <div class="symbol-label" style="background-image:url('{{ !empty(auth()->user()->image) ? asset("images/original/".auth()->user()->image) : asset('media/users/blank.png') }}')"></div>
        <i class="symbol-badge bg-success"></i>
      </div>
      <div class="d-flex flex-column">
        <a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">
          {{ auth()->user()->name }}
        </a>
        <div class="navi mt-2">
          <a href="#" class="navi-item">
            <span class="navi-link p-0 pb-2">
              <span class="navi-icon mr-1">
                {{ Metronic::getSVG("media/svg/icons/Communication/Mail-notification.svg", "svg-icon-lg svg-icon-primary") }}
              </span>
              <span class="navi-text text-muted text-hover-primary">{{ auth()->user()->email }}</span>
            </span>
          </a>
        </div>
      </div>
    </div>

    {{-- Separator --}}
    <div class="separator separator-dashed mt-8 mb-5"></div>

    {{-- Button --}}
    <div class="navi-footer px-8 py-5 d-flex flex-wrap">
      <a href="#" data-toggle="modal" data-target="#modalChangePassword" class="btn btn-light-info font-weight-bold m-2">Ubah Password</a>
      <a href="{{ route('users.edit', Auth::id()) }}" class="btn btn-light-warning font-weight-bold m-2">Edit Profile</a>
      <a href="/logout" class="btn btn-light-primary font-weight-bold m-2">Keluar</a>
    </div>
  </div>
</div>
