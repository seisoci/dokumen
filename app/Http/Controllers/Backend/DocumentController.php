<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\TemplateForm;
use App\Models\TemplateFormData;
use App\Models\TemplateFormOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DocumentController extends Controller
{
  public function index()
  {
    $config['page_title'] = "Daftar Dokumen";
    $config['page_description'] = "Daftar Dokumen";
    $page_breadcrumbs = [
      ['page' => '#', 'title' => "Daftar Dokumen"],
    ];
    $data = Template::latest()->paginate(20);

    return view('backend.documents.index', compact('config', 'page_breadcrumbs', 'data'));
  }

  public function show($id, Request $request)
  {
    $config['page_title'] = "Daftar Isi Form Dokumen";
    $config['page_description'] = "Daftar Isi Form Dokumen";
    $page_breadcrumbs = [
      ['page' => '#', 'title' => "Daftar Isi Form Dokumen"],
    ];
    $data = TemplateForm::where('template_id', $id)
      ->where('is_column_table', 1)
      ->whereNull('parent_id')
      ->orderBy('sort_order', 'asc')
      ->get();

    $datatable = [
      'html' => [
        '<th>No</th>',
      ],
      'js' =>
        [
          'responsive' => 'false',
          'scrollX' => 'true',
          'processing' => 'true',
          'serverSide' => 'true',
          'searching' => 'false',
          'order' => ['0', 'desc'],
          'lengthMenu' => [[10, 25, 50, -1], [10, 25, 50, "All"]],
          'pageLength' => '10',
          'ajax' => route('documents.show', $id),
          'column' => [
            '{ data: "DT_RowIndex", name: "id", searchable: false, className: "dt-center" },',
          ]
        ]
    ];
    $columns = [];
    $select = NULL;
    foreach ($data as $item):
      array_push($datatable['js']['column'], '{ data: "' . $item->name . '", name: "' . $item->name . '" },');
      array_push($datatable['html'], '<th>' . $item->label . '</th>');
      if ($item->tag != 'table') {
        array_push($columns, 'MAX(CASE WHEN (`template_forms`.`name` = "' . $item->name . '") THEN `template_form_data`.`value` ELSE NULL END) as `' . $item->name . '`');
      } else {
        array_push($columns, 'MAX(CASE WHEN (`template_forms`.`tag` = "' . $item->tag . '") THEN `template_forms`.`id` ELSE NULL END) as `' . $item->name . '`');
      }
    endforeach;
    if (count($columns) > 0) {
      $select .= ', ';
    }
    $select .= implode(', ', $columns);
    array_push($datatable['js']['column'], '{ data: "action", name: "action", orderable: false },');
    array_push($datatable['html'], '<th>Action</th>');
    if ($request->ajax()) {
      $dataTable = TemplateFormData::select(DB::raw('`template_data`.`id` AS `id`' . $select))
        ->leftJoin('template_forms', 'template_forms.id', '=', 'template_form_data.template_form_id')
        ->leftJoin('template_data', 'template_data.id', '=', 'template_form_data.template_data_id')
        ->where('template_data.template_id', $id)
        ->groupBy('template_data.id');

      return DataTables::of($dataTable)
        ->filter(function ($query) use ($select, $id) {
          if (request()->has('value')) {
            $data = TemplateFormData::select(DB::raw('`template_data`.`id` AS `id`' . $select))
              ->leftJoin('template_forms', 'template_forms.id', '=', 'template_form_data.template_form_id')
              ->leftJoin('template_data', 'template_data.id', '=', 'template_form_data.template_data_id')
              ->where('template_data.template_id', $id)
              ->where('template_form_data.value', 'LIKE', '%' . request('value') . '%')
              ->groupBy('template_data.id')->get();
            $plucked = $data->pluck('id');
            $query->whereIn('template_data.id', $plucked);
          }
        })
        ->editColumn('doc', function ($row) {
          return '
          <a href=' . asset("/template/$row->file") . '><i class="fas fa-2x fa-file-word"></i></a>
          ';
        })
        ->addColumn('action', function ($row) {
          return '
              <div class="btn-group" role="group">
                  <button id="btnGroupDrop1" type="button" class="btn btn-secondary font-weight-bold dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-file-download"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                      <a class="dropdown-item" href="templates/' . $row->id . '">Generate</a>
                      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalEdit" data-id="' . $row->id . '"  data-name="' . $row->name . '">Ubah</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalDelete" data-id="' . $row->id . '">Hapus</a>
                  </div>
              </div>
          ';
        })
        ->addIndexColumn()
        ->rawColumns(['doc', 'action'])
        ->make(true);
    }
    return view('backend.documents.show', compact('config', 'page_breadcrumbs', 'datatable', 'data', 'id'));
  }

  public function create($idTemplate)
  {
    $config['page_title'] = "Tambah Data";
    $config['page_description'] = "Tambah Data";
    $page_breadcrumbs = [
      ['page' => '#', 'title' => "Tambah Data"],
    ];

    $data = TemplateForm::with('selectoption', 'children')
      ->where('template_id', $idTemplate)
      ->whereNull('parent_id')
      ->orderBy('sort_order', 'asc')
      ->get();

    $arrayList = ['checkbox', 'radio', 'select'];
    $renderHtml = NULL;
    $renderJs = NULL;
    foreach ($data as $item):
      if (in_array($item->tag, $arrayList)) {
        $renderHtml .= $this->render($item->tag, $item->type, $item->name, $item->label, $item->selectoption, $item->multiple, $item->name)['html'];
        $renderJs .= $this->render($item->tag, $item->type, $item->name, $item->label, $item->selectoption, $item->multiple, $item->name)['js'] ?? NULL;
      } elseif ($item->tag == 'table') {
        $renderHtml .= $this->render($item->tag, $item->type, $item->name, $item->label, $item->children, $item->multiple, $item->name)['html'];
        $renderJs .= $this->render($item->tag, $item->type, $item->name, $item->label, $item->children, $item->multiple, $item->name)['js'] ?? NULL;
      } else {
        $renderHtml .= $this->render($item->tag, $item->type, $item->name, $item->label, array(), $item->multiple, $item->name)['html'] ?? NULL;
        $renderJs .= $this->render($item->tag, $item->type, $item->name, $item->label, array(), $item->multiple, $item->name)['js'] ?? NULL;
      }
    endforeach;

    return view('backend.documents.create', compact('config', 'page_breadcrumbs', 'data', 'renderHtml', 'renderJs'));
  }

  public function render($tag, $type, $name, $label, $arrayData = array(), $multiple = FALSE, $tableName = NULL, $tableChild = FALSE)
  {
    $render = NULL;
    if ($tag === 'input') {
      if ($type == 'text') {
        $render['html'] = '
              ' . (!$tableChild ? "<div class='form-group'>" : NULL) . '
              ' . (!$tableChild ? "<label>$label</label>" : NULL) . '
              <input type="text" name="' . $name . ($tableChild ? "[]" : NULL) . ($multiple ? "[]" : NULL) . '" class="form-control" placeholder="Input ' . $label . '"/>
              ' . (!$tableChild ? "</div>" : NULL) . '
        ';
      } elseif ($type == 'number') {
        $render['html'] = '
              ' . (!$tableChild ? "<div class='form-group'>" : NULL) . '
              ' . (!$tableChild ? "<label>$label</label>" : NULL) . '
              <input type="number" name="' . $name . ($tableChild ? "[]" : NULL) . ($multiple ? "[]" : NULL) . '" class="form-control" placeholder="Input ' . $label . '"/>
            ' . (!$tableChild ? "</div>" : NULL) . '
        ';
      } elseif ($type == 'decimal') {
        $render['html'] = '
              ' . (!$tableChild ? "<div class='form-group'>" : NULL) . '
              ' . (!$tableChild ? "<label>$label</label>" : NULL) . '
              <input type="text" name="' . $name . ($tableChild ? "[]" : NULL) . ($multiple ? "[]" : NULL) . '" class="form-control decimal" placeholder="Input ' . $label . '"/>
            ' . (!$tableChild ? "</div>" : NULL) . '
        ';
      } elseif ($type == 'file') {
        $render['html'] = '
              ' . (!$tableChild ? "<div class='form-group'>" : NULL) . '
              ' . (!$tableChild ? "<label>$label</label>" : NULL) . '
              <div class="custom-file">
									<input type="file" class="custom-file-input" id="customFile" name="' . $name . ($tableChild ? "[]" : NULL) . ($multiple ? "[]" : NULL) . '" accept=".doc,.docx,.pdf">
									<label class="custom-file-label" for="customFile">Choose file</label>
							</div>
            ' . (!$tableChild ? "</div>" : NULL) . '
        ';
      } elseif ($type == 'date') {
        $render['html'] = '
             ' . (!$tableChild ? "<div class='form-group'>" : NULL) . '
             ' . (!$tableChild ? "<label>$label</label>" : NULL) . '
              <input type="text" name="' . $name . ($tableChild ? "[]" : NULL) . ($multiple ? "[]" : NULL) . '" class="form-control date" placeholder="Input ' . $label . '" readonly/>
             ' . (!$tableChild ? "</div>" : NULL) . '
        ';
      } elseif ($type == 'datetime') {
        $render['html'] = '
              ' . (!$tableChild ? "<div class='form-group'>" : NULL) . '
              ' . (!$tableChild ? "<label>$label</label>" : NULL) . '
              <input type="text" name="' . $name . ($tableChild ? "[]" : NULL) . ($multiple ? "[]" : NULL) . '" class="form-control datetimepicker" placeholder="Input ' . $label . '" />
              ' . (!$tableChild ? "</div>" : NULL) . '
        ';
      } elseif ($type == 'image') {
        $render['html'] = '
              ' . (!$tableChild ? "<div class='form-group'>" : NULL) . '
              ' . (!$tableChild ? "<label>$label</label>" : NULL) . '
              <input type="text" class="form-control" name="' . $name . ($tableChild ? "[]" : NULL) . ($multiple ? "[]" : NULL) . '" accept=".jpg,.png,.jpeg">
              ' . (!$tableChild ? "</div>" : NULL) . '
        ';
      } elseif ($type == 'currency') {
        $render['html'] = '
              ' . (!$tableChild ? "<div class='form-group'>" : NULL) . '
              ' . (!$tableChild ? "<label>$label</label>" : NULL) . '
              <input type="text" class="form-control currency" name="' . $name . ($tableChild ? "[]" : NULL) . ($multiple ? "[]" : NULL) . '">
              ' . (!$tableChild ? "</div>" : NULL) . '
        ';
      } elseif ($type == 'time') {
        $render['html'] = '
              ' . (!$tableChild ? "<div class='form-group'>" : NULL) . '
              ' . (!$tableChild ? "<label>$label</label>" : NULL) . '
              <input type="text" class="form-control time"  name="' . $name . ($tableChild ? "[]" : NULL) . ($multiple ? "[]" : NULL) . '" readonly>
              ' . (!$tableChild ? "</div>" : NULL) . '
        ';
      }
    } elseif ($tag == 'select') {
      $option = NULL;
      foreach ($arrayData as $item):
        $option .= '<option value="' . $item->option_value . '" ' . ($item->option_selected ? 'checked' : NULL) . '>' . $item->option_text . '</option>';
      endforeach;
      $render['html'] = '
              ' . (!$tableChild ? "<div class='form-group'>" : NULL) . '
              ' . (!$tableChild ? "<label>$label</label>" : NULL) . '
              <select name="' . $name . ($tableChild ? "[]" : NULL) . ($multiple ? "[]" : NULL) . '" class="form-control">
                ' . $option . '
              </select>
             ' . (!$tableChild ? "</div>" : NULL) . '
        ';
    } elseif ($tag == 'textarea') {
      $render['html'] = '
              ' . (!$tableChild ? "<div class='form-group'>" : NULL) . '
              ' . (!$tableChild ? "<label>$label</label>" : NULL) . '
              <textarea class="form-control"  rows="3"></textarea>
             ' . (!$tableChild ? "</div>" : NULL) . '
      ';
    } elseif ($tag == 'checkbox') {
      $option = NULL;
      foreach ($arrayData as $item):
        $option .= '
            <label class="checkbox">
                <input type="checkbox" name="' . $name . ($tableChild ? "[]" : NULL) . ($multiple ? "[]" : NULL) . '" value="' . $item->option_value . '" ' . ($item->option_selected ? 'checked' : NULL) . '/>
                 ' . $item->option_text . '
           </label>
        ';
      endforeach;
      $render['html'] = '
            ' . (!$tableChild ? "<div class='form-group'>" : NULL) . '
            ' . (!$tableChild ? "<label>$label</label>" : NULL) . '
            <div class="checkbox-list">
               ' . $option . '
            </div>
           ' . (!$tableChild ? "</div>" : NULL) . '
      ';
    } elseif ($tag == 'radio') {
      $option = NULL;
      foreach ($arrayData as $item):
        $option .= '
            <label class="radio">
                <input type="radio" name="' . $name . ($tableChild ? "[]" : NULL) . ($multiple ? "[]" : NULL) . '" value="' . $item->option_value . '" ' . ($item->option_selected ? 'checked' : NULL) . '/>
                <span></span> ' . $item->option_text . '
           </label>
        ';
      endforeach;
      $render['html'] = '
            ' . (!$tableChild ? "<div class='form-group'>" : NULL) . '
            ' . (!$tableChild ? "<label>$label</label>" : NULL) . '
            <div class="radio-list">
               ' . $option . '
            </div>
           ' . (!$tableChild ? "</div>" : NULL) . '
      ';
    } elseif ($tag == 'table') {
      $render['html'] = $this->tablerender($tag, $type, $name, $label, $arrayData, $multiple, $tableName, TRUE)['html'] ?? NULL;
      $render['js'] = $this->tablerender($tag, $type, $name, $label, $arrayData, $multiple, $tableName, TRUE)['js'] ?? NULL;
    }
    return $render;
  }

  public function tablerender($tag, $type, $name, $label, $arrayData = array(), $multiple = FALSE, $tableName = NULL, $tableChild = FALSE)
  {
    $arrayList = ['checkbox', 'radio'];
    $buildTable = NULL;
    $jsInput = NULL;
    $thead = NULL;
    $html = NULL;
    $jshtml = NULL;
    $option = NULL;
    $optionjs = NULL;
    foreach ($arrayData as $key => $item):
      $thead .= "<th>$item->label</th>";
      $buildTable .= '<td>';
      if ($item->tag === 'input') {
        if ($item->type == 'text') {
          $html = '<input type="text" name="' . $name . '[1]' . '[' . $item->name . ']' . ($item->multiple ? "[]" : NULL) . '" class="form-control" placeholder="Input ' . $item->label . '"/>';
          $jshtml = '<input type="text" name="' . $name . sprintf("%s", "['+ nextindex +']") . '[' . $item->name . ']' . ($item->multiple ? "[]" : NULL) . '" class="form-control" placeholder="Input ' . $item->label . '"/>';
        } elseif ($item->type == 'number') {
          $html = '<input type="number" name="' . $name . '[1]' . '[' . $item->name . ']' . ($item->multiple ? "[]" : NULL) . '" class="form-control" placeholder="Input ' . $item->label . '"/>';
          $jshtml = '<input type="number" name="' . $name . sprintf("%s", "['+ nextindex +']") . '[' . $item->name . ']' . ($item->multiple ? "[]" : NULL) . '"  class="form-control" placeholder="Input ' . $item->label . '"/>';
        }elseif ($item->type == 'decimal') {
          $html = '<input type="text" name="' . $name . '[1]' . '[' . $item->name . ']' . ($item->multiple ? "[]" : NULL) . '" class="form-control decimal" placeholder="Input ' . $item->label . '"/>';
          $jshtml = '<input type="text" name="' . $name . sprintf("%s", "['+ nextindex +']") . '[' . $item->name . ']' . ($item->multiple ? "[]" : NULL) . '" class="form-control decimal" placeholder="Input ' . $item->label . '"/>';
        } elseif ($item->type == 'file') {
          $html = '<div class="custom-file"><input type="file" class="custom-file-input" id="customFile" name="' . $name . '[1]' . '[' . $item->name . ']' . ($item->multiple ? "[]" : NULL) . '" accept=".doc,.docx,.pdf"><label class="custom-file-label" for="customFile">Choose file</label></div>';
          $jshtml = '<div class="custom-file"><input type="file" class="custom-file-input" id="customFile" name="' . $name . sprintf("%s", "['+ nextindex +']") . '[' . $item->name . ']' . ($item->multiple ? "[]" : NULL) . '" accept=".doc,.docx,.pdf"><label class="custom-file-label" for="customFile">Choose file</label></div>';
        } elseif ($item->type == 'date') {
          $html = '<input type="text" name="' . $name . '[1]' . '[' . $item->name . ']' . ($item->multiple ? "[]" : NULL) . '" class="form-control date" placeholder="Input ' . $item->label . '" readonly/>';
          $jshtml = '<input type="text" name="' . $name . sprintf("%s", "['+ nextindex +']") . '[' . $item->name . ']' . ($item->multiple ? "[]" : NULL) . '" class="form-control date" placeholder="Input ' . $item->label . '" readonly/>';
        }
      }
      if ($item->tag == 'select') {
        $option = NULL;
        foreach ($item->selectoption as $itemSelect):
          $option .= '<option value="' . $itemSelect->option_value . '" ' . ($itemSelect->option_selected ? 'checked' : NULL) . '>' . $itemSelect->option_text . '</option>';
        endforeach;
        $html = '
              <select name="' . $name . '[1]' . '[' . $item->name . ']' . ($item->multiple ? "[]" : NULL) . '" class="form-control">
                ' . $option . '
              </select>
        ';
        $jshtml = '
              <select name="' . $name . sprintf("%s", "['+ nextindex +']") . '[' . $item->name . ']' . ($item->multiple ? "[]" : NULL) . '" class="form-control">
                ' . $option . '
              </select>
        ';
      } elseif ($item->tag == 'checkbox') {
        foreach ($item->selectoption as $itemCheckbox):
          $option .= '
            <label class="checkbox">
                <input type="checkbox" name="' . $name . '[1]' . '[' . $item->name . ']' . ($item->multiple ? "[]" : NULL) . '" value="' . $itemCheckbox->option_value . '" ' . ($itemCheckbox->option_selected ? 'checked' : NULL) . '/>
                 ' . $itemCheckbox->option_text . '
           </label>
          ';
          $optionjs .= '
            <label class="checkbox">
                <input type="checkbox" name="' . $name . sprintf("%s", "['+ nextindex +']") . '[' . $item->name . ']' . ($item->multiple ? "[]" : NULL) . '" ' . ($itemCheckbox->option_selected ? 'checked' : NULL) . '/>
                 ' . $itemCheckbox->option_text . '
           </label>
          ';
        endforeach;
        $html = '
            <div class="checkbox-list">
               ' . $option . '
            </div>
        ';

        $jshtml = '
            <div class="checkbox-list">
               ' . $optionjs . '
            </div>
        ';
      }


      $buildTable .= $html;
      $buildTable .= '</td>';
      $jsInput .= preg_replace("/\r|\n/", "", sprintf("%s", "'<td>$jshtml</td>'"));
      if ((count($arrayData) - 1) != $key) {
        $jsInput .= sprintf("%s", "+ \n");
      }
    endforeach;
    if (isset($thead)) {
      $render['html'] = '
          <label>' . $label . ' :</label>
          <div class="table-responsive" id="tableOption">
             <table class="table table-bordered">
                <thead>
                   <tr>
                     <th class="text-center" scope="col">
                       <button type="button" class="add btn btn-sm btn-primary">+</button>
                     </th>
                      ' . $thead . '
                   </tr>
                   </thead>
                <tbody>
                  <tr class="' . $name . '" id="' . $name . '_1">
                    <td></td>
                    ' . $buildTable . '
                  </tr>
                </tbody>
             </table>
          </div>
        ';
      $jsAfter = "<tr class='$name' id='{$name}_" . sprintf("%s", '" + nextindex + "') . "'></tr>";
      $render['js'] = '
          $(".add").on("click", function () {
            let total_items = $(".' . $name . '").length;
            let lastid = $(".' . $name . ':last").attr("id");
            let split_id = lastid.split("_");
            let nextindex = Number(split_id[split_id.length-1]) + 1;
            let max = 100;
            if (total_items < max) {
              $(".' . $name . ':last").after("' . $jsAfter . '");
               $("#' . $name . '_" + nextindex).append(
               "' . sprintf('%s', "<td><button style='max-width: 50px' type='button' id='{$name}_" . sprintf("%s", '" + nextindex + "') . "' class='btn btn-block btn-danger rm{$name}'>-</button></td>" . "") . '"+
               ' . $jsInput . '
               );
            }
            initType();
          });

          $("tbody").on("click", ".rm' . $name . '", function () {
            let id = this.id;
            let split_id = id.split("_");
            let deleteindex = split_id[split_id.length-1];
            $("#' . $name . '_"  + deleteindex).remove();
            initType();
          });

          ';
    } else {
      $render['html'] = NULL;
    }
    return $render;

  }
}
