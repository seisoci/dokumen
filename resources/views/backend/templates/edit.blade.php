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
              <h3 class="card-title mb-0">{{ $config['tree_title'] }}</h3>
            </div>
            <div class="card-body">
              <ul id="sortable">
                @foreach($tree as $item)
                  <li data-id="{{ $item->id }}">
                    <div class="d-flex align-items-center">
                      <i class="fas fa-arrows-alt pr-2"></i>
                      <div
                        class="w-100 font-size-sm  {{ $item->is_file_name ? 'font-weight-bold text-success' : NULL }}">{{ $item->label }}{{ $item->tag != 'table' ? '{' .$item->name. '}' : '' }}
                        - {{ ucfirst($item->tag) }}{{ $item->tag != 'table' ? '['.ucfirst($item->type).']' : NULL}}
                      </div>
                      <div class="btn-group">
                        <span
                          class="btn btn-sm {{ $item->is_column_table == 1 ? 'btn-success' : 'btn-danger' }}">{{ $item->is_column_table == 1 ? 'Show' : 'Hide' }}</span>
                        <a href="/templates/{{ $item->template_id }}/edit?id={{ $item->id }}"
                           class="btn btn-sm btn-default"
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
                              <div
                                class="w-100 font-size-xs {{ $child->is_file_name ? 'font-weight-bold text-success' : NULL }}">{{ $child->label }}{{ !empty($child->name) ? '{' .$child->name. '}' : '' }}
                                - {{ ucfirst($child->tag) }}[{{ ucfirst($child->type) }}]
                              </div>
                              <div class="btn-group">
                                <a href="/templates/{{ $child->template_id }}/edit?id={{ $child->id }}"
                                   class="btn btn-sm btn-default"
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
          <form id="formUpdate" action="{{ route('templateforms.update', Request::segment(2)) }}" autocomplete="off">
            @method('PUT')
            <div class="card card-table">
              <div class="card-header">
                <h3 class="card-title mb-0">{{ $config['form_title'] }}</h3>
              </div>
              <div class="card-body">
                <input type="hidden" name="template_id" value="{{ $id }}">
                <input type="hidden" name="id" value="{{ $templateFormId }}">
                <div class="form-group">
                  <label>Parent</label>
                  <select class="form-control" name="parent_id">
                    @if($edited->children_count > 0 && in_array($edited->tag, ['table', 'block']))
                      <option value="" selected>Utama</option>
                    @else
                      <option value="">Utama</option>
                      @foreach($data as $item)
                        <option
                          value="{{ $item->id }}" {{ $edited->parent_id == $item->id ? 'selected' : '' }}>{{ $item->label .'('.$item->tag.')'  }}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group">
                  <label>Label</label>
                  <input type="text" class="form-control" name="label" placeholder="Input Label Form"
                         value="{{ $edited->label }}">
                </div>
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control" name="name"
                         placeholder="Input Form Name {Name} harus unik" value="{{ $edited->name }}">
                </div>
                <div class="form-group">
                  <label>Tag Input</label>
                  <select class="form-control" name="tag">
                    @if($edited->children_count > 0 && in_array($edited->tag, ['table', 'block']))
                      {!! in_array($edited->tag, ['table', 'block']) ? '<option value="'.$edited->tag.'" selected>'.ucfirst($edited->tag).'</option>' : NULL  !!}
                    @else
                      <option>--Pilih Tag Input--</option>
                      <option value="input" {{ $edited->tag == 'input' ? 'selected' : NULL }}>Input</option>
                      <option value="select" {{ $edited->tag == 'select' ? 'selected' : NULL }}>Select</option>
                      <option value="textarea" {{ $edited->tag == 'textarea' ? 'selected' : NULL }}>Textarea</option>
                      <option value="checkbox" {{ $edited->tag == 'checkbox' ? 'selected' : NULL }}>Checkbox</option>
                      <option value="radio" {{ $edited->tag == 'radio' ? 'selected' : NULL }}>Radio</option>
                      {!! !$edited->parent_id ? "<option value='table' ".($edited->tag == 'table' ? 'selected' : NULL).">Table</option>" : NULL  !!}
                      {!! !$edited->parent_id ? "<option value='ul' ".($edited->tag == 'ul' ? 'selected' : NULL).">Ul</option>" : NULL  !!}
                      {!! !$edited->parent_id ? "<option value='ol' ".($edited->tag == 'ol' ? 'selected' : NULL).">Ol</option>" : NULL  !!}
{{--                      {!! !$edited->parent_id ? "<option value='block' ".($edited->tag == 'block' ? 'selected' : NULL).">Block</option>" : NULL  !!}--}}
                    @endif
                  </select>
                </div>
                <div class="form-group">
                  <label>Tipe</label>
                  {{ $edited->type }}
                  <select class="form-control" name="type">
                    @foreach($type as $item)
                      <option
                        value="{{ $item['val'] }}" {{ $edited->type == $item['val'] ? 'selected' : NULL }}>{{ $item['text'] }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="table-responsive" id="tableOption"
                     style="{{ !in_array($edited->tag, $selectBox) ? "display: none" : NULL }}">
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
                    @if(isset($edited->selectoption) && count($edited->selectoption) < 1)
                      <tr class="items" id="items_1">
                        <td></td>
                        <td><input type="text" name="formoption[value][]" class="form-control"/></td>
                        <td><input type="text" name="formoption[text][]" class="form-control"/></td>
                        <td class="d-flex justify-content-center align-items-center">
                          <div class="form-control" style="border: none">
                            <input type="checkbox" name="formoption[selected][]" class="w-20px h-20px yes" value="1">
                            <input type="checkbox" name="formoption[selected][]" value="0" checked class="no"
                                   style="display: none">
                          </div>
                        </td>
                      </tr>
                    @endif
                    @foreach($edited->selectoption as $item)
                      <tr class="items" id="items_{{ $loop->iteration }}">
                        @if($loop->first)
                          <td></td>
                        @else
                          <td>
                            <button type="button" id="items_{{ $loop->iteration }}"
                                    class="btn btn-block btn-danger rmItems">-
                            </button>
                          </td>
                        @endif
                        <td><input type="text" name="formoption[value][]" class="form-control"
                                   value="{{ $item->option_value }}"/></td>
                        <td><input type="text" name="formoption[text][]" class="form-control"
                                   value="{{ $item->option_text }}"/></td>
                        <td class="d-flex justify-content-center align-items-center">
                          <div class="form-control" style="border: none">
                            <input type="checkbox" name="formoption[selected][]" class="w-20px h-20px yes"
                                   value="1" {{ $item->option_selected == 1 ? 'checked' : NULL }}>
                            <input type="checkbox" name="formoption[selected][]" value="0" {{ $item->option_selected == 0 ? 'checked' : NULL }} class="no" style="display: none">
                          </div>
                        </td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="form-group" id="viewColumn" style="{{ !$edited->parent_id ? NULL : 'display: none' }}">
                  <label style="display: block;">Tampilkan Kolom</label>
                  <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-sm btn-info {{ $edited->is_column_table == 0 ? 'active' : NULL }}">
                      <input type="radio" name="is_column_table"
                             value="0" {{ $edited->is_column_table == 0 ? 'checked' : NULL }}> Tidak
                    </label>
                    <label class="btn btn-sm btn-info {{ $edited->is_column_table == 0 ? 'active' : NULL }}">
                      <input type="radio" name="is_column_table"value="1" {{ $edited->is_column_table == 1 ? 'checked' : NULL }}> Ya
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label style="display: block;">Gunakan sebagai Nama File (Unik)</label>
                  <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-sm btn-info {{ $edited->is_file_name == 0 ? 'active' : NULL }}">
                      <input type="radio" name="is_file_name"
                             value="0" {{ $edited->is_file_name == 0 ? 'checked' : NULL }}> Tidak
                    </label>
                    <label class="btn btn-sm btn-info {{ $edited->is_file_name == 0 ? 'active' : NULL }}">
                      <input type="radio" name="is_file_name" value="1" {{ $edited->is_file_name == 1 ? 'checked' : NULL }}> Ya
                    </label>
                  </div>
                </div>
                <div id="isMultiple" class="form-group"
                     style="{{ $edited->tag != 'checkbox' ? 'display: none' : NULL }}">
                  <label style="display: block;">Multiple Checklist</label>
                  <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-sm btn-info active">
                      <input type="radio" name="multiple" value="0" {{ $edited->multiple == 0 ? 'checked' : NULL }}>
                      Tidak
                    </label>
                    <label class="btn btn-sm btn-info">
                      <input type="radio" name="multiple" value="1" {{ $edited->multiple == 1 ? 'checked' : NULL }}> Ya
                    </label>
                  </div>
                </div>
              </div>
              <div class="card-footer d-flex justify-content-end">
                <div class="btn-group">
                  <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-plus fa-sm"></i> Ubah
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
  <script src="{{ asset('js/backend/sortable/jquery-sortable.js') }}" type="text/javascript"></script>
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

      $('input:checkbox').click(function(){
        if($(this).is(':checked')){
          $(this).siblings('input:checkbox').prop('checked', false);
        }else{
          $(this).siblings('input:checkbox').prop('checked', true);
        }
      });

      $('tbody').on('click', 'input[name^="formoption[selected]"]', function () {
        let $row = $(this).closest("tr").attr('id');
        let tag = $('select[name=tag] option').filter(':selected').val();
        if (tag === 'select' || tag === 'radio') {
          $('#tableOption').find("input[name^='formoption[selected]']").each(function () {
            let $idLoop = $(this).closest("tr").attr('id');
            if ($idLoop !== $row) {
              // $(this).prop("checked", false);
              $(this).closest(".no").prop("checked", true);
              $(this).closest(".yes").prop("checked", false);
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
        // $('#isMultiple').css('display', 'none');
        if (optionMultiple.includes(tag)) {
          // if (tag === 'checkbox') {
          //   $('#isMultiple').css('display', '');
          // }
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
        // const tableBlock = ["table", "block"];
        const tableBlock = ["table"];
        if (tag === 'input') {
          $.each(selectType, function (key, value) {
            $("select[name='type']").append($('<option></option>').val(value.val).text(value.text));
          });
          $("input[name='name']").prop('disabled', false);
        } else if (tableBlock.includes(tag)) {
          $("select[name='type']").append($('<option></option>').val('text').text('Text'));
        } else {
          $("select[name='type']").append($('<option></option>').val('text').text('Text'));
          $("input[name='name']").prop('disabled', false);
        }
      });

      $("select[name='parent_id']").on('change', function () {
        if (!$(this).val()) {
          $("select[name='tag']").append($('<option></option>').val('ul').text('Ul'));
          $("select[name='tag']").append($('<option></option>').val('ol').text('Ol'));
          $("select[name='tag']").append($('<option></option>').val('table').text('Table'));
          // $("select[name='tag']").append($('<option></option>').val('block').text('Block'));
          $('#viewColumn').css('display', '');
        } else {
          $("select[name='tag'] option[value='table']").remove();
          $("select[name='tag'] option[value='ul']").remove();
          $("select[name='tag'] option[value='ol']").remove();
          // $("select[name='tag'] option[value='block']").remove();
          $('#viewColumn').css('display', 'none');
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
            '<input type="checkbox" name="formoption[selected][]" class="w-20px h-20px yes" value="1">' +
            '<input type="checkbox" name="formoption[selected][]" value="0" checked class="no" style="display: none">'+
            '</div>' +
            '</td>'
          );
        }
      });

      $('tbody').on('click', '.rmItems', function () {
        let id = this.id;
        let split_id = id.split("_");
        let deleteindex = split_id[1];
        $("#items_" + deleteindex).remove();
      });

      $('#modalDelete').on('show.bs.modal', function (event) {
        let id = $(event.relatedTarget).data('id');
        $(this).find('.modal-body').find('a[name="id"]').attr('href', '{{ url("templateforms") }}/' + id);
      });

      $('#modalDelete').on('hidden.bs.modal', function (event) {
        $(this).find('.modal-body').find('a[name="id"]').attr('href', '');
      });

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
              toastr.error((response.message || "Please complete your form"), 'Failed !');
            }
          }, error: function (response) {
            btnSubmit.removeClass("disabled").html(btnSubmitHtml).removeAttr("disabled");
            toastr.error(response.responseJSON.message, 'Failed !');
          }
        });
      });

      $("#changeHierarchy").on('click', function (e) {
        e.preventDefault();
        let url = '{{ route('change_hierarchy', $id) }}';
        let data = {data: buildIdList()};
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
