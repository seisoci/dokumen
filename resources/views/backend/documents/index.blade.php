{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
  <!--begin::Card-->
  <div class="row">
    <div class="col-md-12 pb-6">
      <form action="{{ route('documents.index') }}" method="GET">
        <div class="bg-white d-flex justify-content-end p-4 mt-2 pr-10">
          <div class="row">
            <div class="col-md-9">
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
              <span class="input-group-text line-height-0 py-0">
                 <i class="fas fa-search"></i>
              </span>
                  </div>
                  <input type="text" class="form-control" name="q" placeholder="Ketik nama dokumen ... " value="{{ $search }}"/>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <button type="submit" class="btn btn-primary ml-4">Submit</button>
            </div>
          </div>
        </div>
      </form>
    </div>
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
@endsection

{{-- Scripts Section --}}
@section('scripts')
  {{-- vendors --}}

  {{-- page scripts --}}
@endsection
