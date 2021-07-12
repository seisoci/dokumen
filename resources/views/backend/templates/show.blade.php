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
        <!--end::Button-->
      </div>
    </div>

    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-table">
            <div class="card-header">
              <h3 class="card-title mb-0">{{ $config['form_title'] }}</h3>
            </div>
            <div class="card-body">
              <ul id="sortable">
                @foreach($tree as $item)
                  <li data-id="{{ $item->id }}">
                    <div class="d-flex align-items-center">
                      <i class="fas fa-arrows-alt pr-2"></i>
                      <div class="w-100">{{ $item->label }}</div>
                      <div class="btn-group">
                        <a href="/edit" class="btn btn-sm btn-default"
                        ><i class="fa fa-fw fa-edit"></i>
                        </a>
                        <button
                          type="button"
                          class="btn-delete btn btn-sm btn-default"
                          data-action="s"
                        ><i class="fa fa-fw fa-trash"></i>
                        </button>
                      </div>
                    </div>
                    @foreach($item->children as $child)
                      @if($loop->first)
                        <ul class="children">
                          <li data-id="{{ $child->id }}">
                            <div class="d-flex align-items-center">
                              <i class="fas fa-arrows-alt pr-2"></i>
                              <div class="w-100">{{ $child->label }}</div>
                              <div class="btn-group">
                                <a href="/edit" class="btn btn-sm btn-default"
                                ><i class="fa fa-fw fa-edit"></i>
                                </a>
                                <button
                                  type="button"
                                  class="btn-delete btn btn-sm btn-default"
                                  data-action="s"
                                ><i class="fa fa-fw fa-trash"></i>
                                </button>
                              </div>
                            </div>
                          </li>
                          @elseif($loop->last)
                            <li data-id="{{ $child->id }}">
                              <div class="d-flex align-items-center">
                                <i class="fas fa-arrows-alt pr-2"></i>
                                <div class="w-100">{{ $child->label }}</div>
                                <div class="btn-group">
                                  <a href="/edit" class="btn btn-sm btn-default"
                                  ><i class="fa fa-fw fa-edit"></i>
                                  </a>
                                  <button
                                    type="button"
                                    class="btn-delete btn btn-sm btn-default"
                                    data-action="s"
                                  ><i class="fa fa-fw fa-trash"></i>
                                  </button>
                                </div>
                              </div>
                            </li>
                        </ul>
                  @else
                    <li data-id="{{ $child->id }}">
                      <div class="d-flex align-items-center">
                        <i class="fas fa-arrows-alt pr-2"></i>
                        <div class="w-100">{{ $child->label }}</div>
                        <div class="btn-group">
                          <a href="/edit" class="btn btn-sm btn-default"
                          ><i class="fa fa-fw fa-edit"></i>
                          </a>
                          <button
                            type="button"
                            class="btn-delete btn btn-sm btn-default"
                            data-action="s"
                          ><i class="fa fa-fw fa-trash"></i>
                          </button>
                        </div>
                      </div>
                    </li>
                    @endif
                    @endforeach
                    </li>
                    @endforeach
              </ul>
            </div>
            <div class="card-footer d-flex justify-content-end">
              <div class="btn-group">
                <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-plus fa-sm"></i> Ubah
                </button>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <form id="formStore" action="{{ route('tempalateforms.store') }}" autocomplete="off">
            @csrf
            <input type="hidden" name="menu_type" value="top-menu">
            <div class="card card-table">
              <div class="card-header">
                <h3 class="card-title mb-0">{{ $config['form_title'] }}</h3>
              </div>
              <div class="card-body">
                <input type="hidden" name="template_id" value="{{ $id }}">
                <div class="form-group">
                  <label>Parent</label>
                  <select class="form-control" name="parent_id">
                    <option value="" selected>Utama</option>
                    @foreach($data as $item)
                      <option value="{{ $item->id }}">{{ $item->label .'('.$item->tag.')'  }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Label</label>
                  <input type="text" class="form-control" name="label" placeholder="Input Label Form">
                </div>
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control" name="name"
                         placeholder="Input Form Name {Name}, Table tidak perlu di isi ">
                </div>
                <div class="form-group">
                  <label>Tag Input</label>
                  <select class="form-control" name="tag">
                    <option value="input">Input</option>
                    <option value="select">Select</option>
                    <option value="textarea">Textarea</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="radio">Radio</option>
                    <option value="table">Table</option>
                    <option value="ul">Ul</option>
                    <option value="ol">Ol</option>
                    <option value="block">Block</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Tipe</label>
                  <select class="form-control" name="type">
                    <option value="text">Text</option>
                    <option value="number">Number</option>
                    <option value="decimal">Decimal</option>
                    <option value="file">File</option>
                    <option value="date">Date</option>
                    <option value="datetime">Datetime</option>
                    <option value="image">Image</option>
                    <option value="currency">Currency</option>
                    <option value="time">Time</option>
                  </select>
                </div>
                <div class="form-group">
                  <label style="display: block;">Tampilkan Kolom</label>
                  <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-sm btn-info active">
                      <input type="radio" name="is_column_table" value="0" checked> Tidak
                    </label>
                    <label class="btn btn-sm btn-info">
                      <input type="radio" name="is_column_table" value="1"> Ya
                    </label>
                  </div>
                </div>
              </div>
              <div class="card-footer d-flex justify-content-end">
                <div class="btn-group">
                  <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-fw fa-plus fa-sm"></i> Tambah
                  </button>
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
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
  <style>
    #sortable {
      padding-left: 0 !important;
    }

    #sortable li {
      border-radius: 4px;
      display: block;
      align-items: center;
      margin: 5px;
      padding: 5px;
      border: 1px solid #cccccc;
      color: #0088cc;
      background: #eeeeee;
    }

    .dragged {
      position: absolute;
      top: 0;
      opacity: 0.5;
      display: none;
      z-index: 2000;
    }

    li.placeholder {
      position: relative;
      margin: 0 !important;
      padding: 0 !important;
      border: none !important;
      display: none;
      width: 0 !important;
      height: 0 !important;
    }

    li.placeholder:before {
      position: absolute;
      content: "";
      width: 0;
      height: 0;
      margin-top: -5px;
      left: -5px;
      top: -4px;
      border: 5px solid transparent;
      border-left-color: red;
      border-right: none;
    }
  </style>
@endsection

{{-- Scripts Section --}}
@section('scripts')
  {{-- vendors --}}
  <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
  <script src="https://johnny.github.io/jquery-sortable/js/jquery-sortable.js" type="text/javascript"></script>
  {{-- page scripts --}}
  <script src="{{ asset('js/pages/crud/datatables/basic/basic.js') }}" type="text/javascript"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      $("#sortable").sortable({
        onDrop: function ($item, container, _super) {
          _super($item, container)
          let currentid = $item.data('id');
          console.log(currentid);
          buildIdList()
        },
        isValidTarget: function ($item, container) {
          return $item.closest("ul").is(container.el);
        },
      });

      function buildIdList() {
        let listItems = [];
        $('#sortable li').each(function () {
          let val = $(this).data('id');
          listItems.push(val);
        });
        console.log(listItems);
      }

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
    });
  </script>
@endsection
