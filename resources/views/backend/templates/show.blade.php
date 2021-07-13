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
                          class="btn btn-sm btn-default"
                          data-toggle="modal"
                          data-target="#modalDelete"
                          data-id="{{ $item->id }}"
                        ><i class="fa fa-fw fa-trash"></i>
                        </button>
                      </div>
                    </div>
                    @foreach($item->children as $child)
                      @if ($loop->first)
                        <ul class="children">
                          @endif
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
                                  class="btn btn-sm btn-default"
                                  data-toggle="modal"
                                  data-target="#modalDelete"
                                  data-id="{{ $child->id }}"
                                ><i class="fa fa-fw fa-trash"></i>
                                </button>
                              </div>
                            </div>
                          </li>
                          @if ($loop->last)
                        </ul>
                      @endif

                    @endforeach
                  </li>
                @endforeach
              </ul>
            </div>
            <div class="card-footer d-flex justify-content-end">
              <div class="btn-group">
                <button id="changeHierarchy" type="button" class="btn btn-warning btn-sm"><i
                    class="fa fa-fw fa-plus fa-sm"></i> Ubah
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <form id="formStore" action="{{ route('templateforms.store') }}" autocomplete="off">
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
                    <option>--Pilih Tag Input--</option>
                    <option value="input">Input</option>
                    <option value="select">Select</option>
                    <option value="textarea">Textarea</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="radio">Radio</option>
                    <option value="ul">Ul</option>
                    <option value="ol">Ol</option>
                    <option value="block">Block</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Tipe</label>
                  <select class="form-control" name="type">
                  </select>
                </div>
                <div class="table-responsive" id="tableOption" style="display: none">
                  <table class="table table-bordered">
                    <thead>
                    <tr>
                      <th class="text-center" scope="col">
                        <button type="button"
                                class="add btn btn-sm btn-primary">+
                        </button>
                      </th>
                      <th class="text-center" scope="col">Value</th>
                      <th class="text-center" scope="col">Text</th>
                      <th class="text-center" scope="col">Selected</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="items" id="items_1">
                      <td></td>
                      <td><input type="text" name="formoption[value][]" class="form-control"/></td>
                      <td><input type="text" name="formoption[text][]" class="form-control"/></td>
                      <td class="d-flex justify-content-center align-items-center">
                        <div class="form-control" style="border: none">
                          <input type="checkbox" name="formoption[selected][]" class="w-20px h-20px" value="1">
                        </div>
                      </td>
                    </tr>
                    </tbody>
                  </table>
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
                <div id="isMultiple" class="form-group" style="display: none">
                  <label style="display: block;">Multiple Checklist</label>
                  <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-sm btn-info active">
                      <input type="radio" name="multiple" value="0" checked> Tidak
                    </label>
                    <label class="btn btn-sm btn-info">
                      <input type="radio" name="multiple" value="1"> Ya
                    </label>
                  </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                  <div class="btn-group">
                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-fw fa-plus fa-sm"></i> Tambah
                    </button>
                  </div>
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
  <script src="{{ asset('js/pages/crud/datatables/basic/basic.js') }}" type="text/javascript"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      $("#sortable").sortable({
        onDrop: function ($item, container, _super) {
          _super($item, container)
          // let currentid = $item.data('id');
          buildIdList();
        },
        isValidTarget: function ($item, container) {
          return $item.closest("ul").is(container.el);
        },
      });

      function buildIdList() {
        let listItems = [];
        $('#sortable').children('li').each(function (index, value) {
          let data = [];
          let child = [];
          $(this).find('ul').children('li').each(function () {
            child.push($(this).data('id'));
          });
          data = {
            'parent': $(this).data('id'),
            'child': child
          };
          listItems.push(data);
        });
        return listItems;
      }

      $('tbody').on('click', 'input[name^="formoption[selected]"]', function () {
        let $row = $(this).closest("tr").attr('id');
        let tag = $('select[name=tag] option').filter(':selected').val();
        console.log(tag);
        if (tag === 'select' || tag === 'radio') {
          $('#tableOption').find("input[name^='formoption[selected]']").each(function () {
            let $idLoop = $(this).closest("tr").attr('id');
            if ($idLoop !== $row) {
              $(this).prop("checked", false);
            }
          });
        }
      });

      let selectType = [
        {
          "val": "text",
          "text": "Text"
        },
        {
          "val": "number",
          "text": "Number"
        },
        {
          "val": "decimal",
          "text": "Decimal"
        },
        {
          "val": "file",
          "text": "File"
        },
        {
          "val": "date",
          "text": "Date"
        },
        {
          "val": "datetime",
          "text": "Datetime"
        },
        {
          "val": "image",
          "text": "Image"
        },
        {
          "val": "currency",
          "text": "Currency"
        },
        {
          "val": "time",
          "text": "Time"
        }
      ];

      $("select[name='tag']").on('change', function () {
        const optionMultiple = ["select", "checkbox", "radio"];
        let tag = $(this).val();
        $('#isMultiple').css('display', 'none');
        if (optionMultiple.includes(tag)) {
          if (tag === 'checkbox') {
            $('#isMultiple').css('display', '');
          }
          $('#tableOption').css('display', '');
          let $row = $('#items_1');
          $row.find('input[name="formoption[value][]"]').val('');
          $row.find('input[name="formoption[text][]"]').val('');
          $row.find('input[name="formoption[selected][]"]').prop("checked", false);
          for (let i = 2; i < 100; i++) {
            $("#items_" + i).remove();
          }
        } else {
          $('#tableOption').css('display', 'none');
        }
        $("select[name='type']").empty();
        if ($(this).val() === 'input') {
          $.each(selectType, function (key, value) {
            $("select[name='type']").append($('<option></option>').val(value.val).text(value.text));
          });
        } else {
          $("select[name='type']").append($('<option></option>').val('text').text('Text'));
        }
      });

      $("select[name='parent_id']").on('change', function () {
        if (!$(this).val()) {
          $("select[name='tag']").append($('<option></option>').val('table').text('Table'));
        } else {
          $("select[name='tag'] option[value='table']").remove();
        }
      });

      $(".add").on('click', function () {
        let total_items = $(".items").length;
        let lastid = $(".items:last").attr("id");
        let split_id = lastid.split("_");
        let nextindex = Number(split_id[1]) + 1;
        let max = 100;
        if (total_items < max) {
          $(".items:last").after("<tr class='items' id='items_" + nextindex + "'></tr>");
          $("#items_" + nextindex).append(
            "<td><button type='button' id='items_" + nextindex + "' class='btn btn-block btn-danger rmItems'>-</button></td>" +
            '<td><input type="text" name="formoption[value][]" class="form-control"/></td>' +
            '<td><input type="text" name="formoption[text][]" class="form-control"/></td>' +
            '<td class="d-flex justify-content-center align-items-center">' +
            '<div class="form-control" style="border: none">' +
            '<input type="checkbox" name="formoption[selected][]" class="w-20px h-20px" value="1">' +
            '</div>' +
            '</td>'
          );
        }
        // initSelected();
      });

      $('tbody').on('click', '.rmItems', function () {
        let id = this.id;
        let split_id = id.split("_");
        let deleteindex = split_id[1];
        $("#items_" + deleteindex).remove();
      });

      $('#modalDelete').on('show.bs.modal', function (event) {
        let id = $(event.relatedTarget).data('id');
        $(this).find('.modal-body').find('a[name="id"]').attr('href', '{{ route("templateforms.index") }}/' + id);
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
              setTimeout(function () {
                if (response.redirect === "" || response.redirect === "reload") {
                  location.reload();
                } else {
                  location.href = response.redirect;
                }
              }, 1000);
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

      $("#changeHierarchy").on('click', function (e) {
        e.preventDefault();
        let url = '{{ route('change_hierarchy', $id) }}';
        let data = {data: buildIdList()};
        console.log(data);
        let btnSubmit = $(this);
        let btnSubmitHtml = btnSubmit.html();
        $.ajax({
          beforeSend: function () {
            btnSubmit.addClass("disabled").html("<i class='fa fa-spinner fa-pulse fa-fw'></i> Loading ...").prop("disabled", "disabled");
          },
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          cache: false,
          processData: false,
          contentType: 'application/json',
          dataType: 'json',
          type: "POST",
          url: url,
          data: JSON.stringify(data),
          success: function (response) {
            btnSubmit.removeClass("disabled").html(btnSubmitHtml).removeAttr("disabled");
            if (response.status === "success") {
              toastr.success(response.message, 'Success !');
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
        let btn = $(this);
        let url = $('#modalDelete').find('a[name="id"]').attr('href');
        let btnHtml = btn.html();
        let spinner = $('<span role="status" class="spinner-border spinner-border-sm" aria-hidden="true"></span>');
        $.ajax({
          beforeSend: function () {
            btn.text(' Loading. . .').prepend(spinner).prop("disabled", "disabled");
          },
          type: 'DELETE',
          url: url,
          dataType: 'json',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (response) {
            toastr.success(response.message, 'Success !');
            btn.removeClass("disabled").text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm").html(btnHtml);
            $('#modalDelete').modal('hide');
            setTimeout(function () {
              if (response.redirect === "" || response.redirect === "reload") {
                location.reload();
              } else {
                location.href = response.redirect;
              }
            }, 1000);
          },
          error: function (response) {
            toastr.error(response.responseJSON.message, 'Failed !');
            btn.removeClass("disabled").text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm").html(btnHtml);
            $('#modalDelete').modal('hide');
            $('#modalDelete').find('a[name="id"]').attr('href', '');
          }
        });
      });

    });
  </script>
@endsection
