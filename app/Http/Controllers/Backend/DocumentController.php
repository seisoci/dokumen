<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\TemplateData;
use App\Models\TemplateForm;
use App\Models\TemplateFormData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DocumentController extends Controller
{
  public function index(Request $request)
  {
    $config['page_title'] = "Daftar Dokumen";
    $config['page_description'] = "Daftar Dokumen";
    $page_breadcrumbs = [
      ['page' => '#', 'title' => "Daftar Dokumen"],
    ];
    $search = $request['q'] ?? NULL;
    $data = Template::when($search, function ($q) use ($search) {
      return $q->where('name', 'LIKE', "%{$search}%");
    })
      ->latest()
      ->paginate(20);
    return view('backend.documents.index', compact('config', 'page_breadcrumbs', 'data', 'search'));
  }

  public function show($id, Request $request)
  {
    $config['page_title'] = "Daftar Isi Form Dokumen";
    $config['page_description'] = "Daftar Isi Form Dokumen";
    $page_breadcrumbs = [
      ['page' => "/documents", 'title' => "List Dokumen"],
      ['page' => '#', 'title' => "Daftar Isi Form Dokumen"],
    ];
    $data = TemplateForm::where('template_id', $id)
      ->where('is_column_table', 1)
      ->whereNull('parent_id')
      ->orderBy('sort_order', 'asc')
      ->get();

    $datatable = [
      'html' => [
        '<th></th>',
      ],
      'js' =>
        [
          'responsive' => 'false',
          'scrollX' => 'true',
          'processing' => 'true',
          'serverSide' => 'true',
          'searching' => 'false',
          'ordering' => 'false',
          'order' => ['0', 'desc'],
          'lengthMenu' => [[10, 25, 50, -1], [10, 25, 50, "All"]],
          'pageLength' => '10',
          'ajax' => route('documents.show', $id),
          'column' => [
            '{ data: "id", name: "id" },',
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
        ->groupBy('template_data.id')
        ->orderBy('template_data.id', 'desc');

      return DataTables::of($dataTable)
        ->filter(function ($query) use ($select, $id) {
          if (request()->has('value')) {
            $data = TemplateFormData::select(DB::raw('`template_data`.`id` AS `id`' . $select))
              ->leftJoin('template_forms', 'template_forms.id', '=', 'template_form_data.template_form_id')
              ->leftJoin('template_data', 'template_data.id', '=', 'template_form_data.template_data_id')
              ->where('template_data.template_id', $id)
              ->where('template_form_data.value', 'LIKE', '%' . request('value') . '%')
              ->groupBy('template_data.id')
              ->get();
            $plucked = $data->pluck('id');
            $query->whereIn('template_data.id', $plucked);
          }
        })
        ->editColumn('doc', function ($row) {
          return '
          <a href=' . asset("/template/$row->file") . '><i class="fas fa-2x fa-file-word"></i></a>
          ';
        })
        ->addColumn('action', function ($row) use ($id) {
          return '
              <div class="btn-group" role="group">
                  <button id="btnGroupDrop1" type="button" class="btn btn-primary font-weight-bold dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="la la-file-text-o"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                      <a class="dropdown-item" href="' . route('generate.single', $row->id) . '">Generate</a>
                      <a class="dropdown-item" href="/documents/' . $id . '/edit?formdataid=' . $row->id . '">Ubah</a>
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
      ['page' => "/documents", 'title' => "List Dokumen"],
      ['page' => "/documents/{$idTemplate}", 'title' => "Daftar Isi Form Dokumen"],
      ['page' => '#', 'title' => "Tambah Data"],
    ];

    $data = TemplateForm::with('selectoption', 'children')
      ->whereNull('parent_id')
      ->where('template_id', $idTemplate)
      ->orderBy('sort_order', 'asc')
      ->get();

    $arrayList = ['checkbox', 'radio', 'select'];
    $renderHtml = NULL;
    $renderJs = NULL;
    foreach ($data as $item):
      if (in_array($item->tag, $arrayList)) {
        $renderHtml .= $this->render($item->id, $item->tag, $item->type, $item->name, $item->label, $item->selectoption, $item->multiple, $item->name)['html'];
        $renderJs .= $this->render($item->id, $item->tag, $item->type, $item->name, $item->label, $item->selectoption, $item->multiple, $item->name)['js'] ?? NULL;
      } elseif ($item->tag == 'table' || $item->tag == 'block') {
        $renderHtml .= $this->render($item->id, $item->tag, $item->type, $item->name, $item->label, $item->children, $item->multiple, $item->name)['html'];
        $renderJs .= $this->render($item->id, $item->tag, $item->type, $item->name, $item->label, $item->children, $item->multiple, $item->name)['js'] ?? NULL;
      } else {
        $renderHtml .= $this->render($item->id, $item->tag, $item->type, $item->name, $item->label, array(), $item->multiple, $item->name)['html'] ?? NULL;
        $renderJs .= $this->render($item->id, $item->tag, $item->type, $item->name, $item->label, array(), $item->multiple, $item->name)['js'] ?? NULL;
      }
    endforeach;

    return view('backend.documents.create', compact('config', 'page_breadcrumbs', 'data', 'idTemplate', 'renderHtml', 'renderJs'));
  }

  public function store($idTemplate, Request $request)
  {
    dd($request->all());
    $templateForm = TemplateForm::with(['children', 'children.selectoption', 'selectoption'])
      ->whereNull('parent_id')
      ->where('template_id', $idTemplate)
      ->orderBy('sort_order', 'asc')
      ->get();

    try {
      DB::beginTransaction();
      $templateData = TemplateData::create([
        'template_id' => $idTemplate,
      ]);
      foreach ($templateForm as $itemParent):
        if (!in_array($itemParent->tag, ['table', 'block'])) {
          if ($request->input($itemParent->name) && !in_array($itemParent->tag, ['checkbox', 'ul', 'ol', 'block', 'table'])):
            TemplateFormData::create([
              'template_data_id' => $templateData->id,
              'template_form_id' => $itemParent->id,
              'value' => $request->input($itemParent->name)
            ]);
          elseif ($request->input($itemParent->name) && in_array($itemParent->tag, ['checkbox', 'ul', 'ol'])):
            if (!$itemParent->multiple) {
              TemplateFormData::create([
                'template_data_id' => $templateData->id,
                'template_form_id' => $itemParent->id,
                'value' => $request->input($itemParent->name)
              ]);
            } else {
              TemplateFormData::create([
                'template_data_id' => $templateData->id,
                'template_form_id' => $itemParent->id,
                'value' => implode(", ", $request->input($itemParent->name))
              ]);
            }
          endif;
        } elseif (in_array($itemParent->tag, ['table', 'block'])) {
          foreach ($itemParent->children as $itemChild):
            $childrenForm = array_values($request[$itemParent->name]);
            foreach ($childrenForm as $item):
              if (!in_array($itemChild->tag, ['checkbox', 'ul', 'ol', 'block', 'table'])):
                TemplateFormData::create([
                  'template_data_id' => $templateData->id,
                  'template_form_id' => $itemChild->id,
                  'value' => $item[$itemChild->name] ?? NULL
                ]);
              elseif (in_array($itemChild->tag, ['checkbox', 'ul', 'ol'])):
                if (!$itemChild->multiple) {
                  TemplateFormData::create([
                    'template_data_id' => $templateData->id,
                    'template_form_id' => $itemChild->id,
                    'value' => $item[$itemChild->name] ?? NULL
                  ]);
                } else {
                  TemplateFormData::create([
                    'template_data_id' => $templateData->id,
                    'template_form_id' => $itemChild->id,
                    'value' => implode(", ", $item[$itemChild->name]) ?? NULL
                  ]);
                }
              endif;
            endforeach;
          endforeach;
        }
      endforeach;
      DB::commit();
      $response = response()->json([
        'status' => 'success',
        'message' => 'Data berhasil disimpan',
        'redirect' => "/documents/{$idTemplate}"
      ]);
    } catch (\Throwable $throw) {
      DB::rollBack();
      $response = response()->json([
        'status' => 'error',
        'message' => 'Gagal menyimpan data'
      ]);
    }
    return $response;
  }

  public function edit($id, Request $request)
  {
    $config['page_title'] = "Ubah Data";
    $config['page_description'] = "Ubah Data";
    $page_breadcrumbs = [
      ['page' => "/documents", 'title' => "List Dokumen"],
      ['page' => "/documents/{$id}", 'title' => "Daftar Isi Form Dokumen"],
      ['page' => '#', 'title' => "Ubah Data"],
    ];

    $templateForm = TemplateForm::where('template_id', $id)
      ->whereNull('parent_id')
      ->orderBy('sort_order', 'asc')
      ->get();

    $templateDataId = $request->formdataid;

    $arrayList = ['checkbox', 'radio', 'select'];
    $renderHtml = NULL;
    $renderJs = NULL;
    foreach ($templateForm as $item):
      if (in_array($item->tag, $arrayList)) {
        $renderHtml .= $this->render($item->id, $item->tag, $item->type, $item->name, $item->label, $item->selectoption, $item->multiple, $item->name, FALSE, $id, $templateDataId, TRUE)['html'];
        $renderJs .= $this->render($item->id, $item->tag, $item->type, $item->name, $item->label, $item->selectoption, $item->multiple, $item->name)['js'] ?? NULL;
      } elseif ($item->tag == 'table' || $item->tag == 'block') {
        $renderHtml .= $this->render($item->id, $item->tag, $item->type, $item->name, $item->label, $item->children, $item->multiple, $item->name, FALSE, $id, $templateDataId, TRUE)['html'];
        $renderJs .= $this->render($item->id, $item->tag, $item->type, $item->name, $item->label, $item->children, $item->multiple, $item->name)['js'] ?? NULL;
      } else {
        $renderHtml .= $this->render($item->id, $item->tag, $item->type, $item->name, $item->label, array(), $item->multiple, $item->name, FALSE, $id, $templateDataId, TRUE)['html'] ?? NULL;
        $renderJs .= $this->render($item->id, $item->tag, $item->type, $item->name, $item->label, array(), $item->multiple, $item->name)['js'] ?? NULL;
      }
    endforeach;

    return view('backend.documents.edit', compact('config', 'page_breadcrumbs', 'templateDataId', 'renderHtml', 'renderJs'));
  }

  public function update($idTemplate, Request $request)
  {
    $templateForm = TemplateForm::with(['children'])
      ->whereNull('parent_id')
      ->where('template_id', $idTemplate)
      ->orderBy('sort_order', 'asc')
      ->get();
    $templateDataId = $request->templateDataId;
    try {
      DB::beginTransaction();
      $templateData = TemplateData::findOrFail($templateDataId);
      foreach ($templateForm as $itemParent):
        if (!in_array($itemParent->tag, ['table', 'block'])) {
          if ($request->input($itemParent->name) && !in_array($itemParent->tag, ['checkbox', 'ul', 'ol', 'block', 'table'])):
            TemplateFormData::updateOrCreate([
              'template_data_id' => $templateData->id,
              'template_form_id' => $itemParent->id,
            ], [
              'value' => $request->input($itemParent->name)
            ]);
          elseif ($request->input($itemParent->name) && in_array($itemParent->tag, ['checkbox', 'ul', 'ol'])):
            if (!$itemParent->multiple) {
              TemplateFormData::updateOrCreate([
                'template_data_id' => $templateData->id,
                'template_form_id' => $itemParent->id,
              ], [
                'value' => $request->input($itemParent->name)
              ]);
            } else {
              TemplateFormData::updateOrCreate([
                'template_data_id' => $templateData->id,
                'template_form_id' => $itemParent->id,
              ], [
                'value' => implode(", ", $request->input($itemParent->name))
              ]);
            }
          endif;
        } elseif (in_array($itemParent->tag, ['table', 'block'])) {
          foreach ($itemParent->children as $itemChild):
            $childrenForm = array_values($request[$itemParent->name]);
            TemplateFormData::where('template_data_id', $templateData->id)->where('template_form_id', $itemChild->id)->delete();
            foreach ($childrenForm as $item):
              if (!in_array($itemChild->tag, ['checkbox', 'ul', 'ol', 'block', 'table'])):
                TemplateFormData::create([
                  'template_data_id' => $templateData->id,
                  'template_form_id' => $itemChild->id,
                  'value' => $item[$itemChild->name] ?? NULL
                ]);
              elseif (in_array($itemChild->tag, ['checkbox', 'ul', 'ol'])):
                if (!$itemChild->multiple) {
                  TemplateFormData::create([
                    'template_data_id' => $templateData->id,
                    'template_form_id' => $itemChild->id,
                    'value' => $item[$itemChild->name] ?? NULL
                  ]);
                } else {
                  TemplateFormData::create([
                    'template_data_id' => $templateData->id,
                    'template_form_id' => $itemChild->id,
                    'value' => implode(", ", $item[$itemChild->name]) ?? NULL
                  ]);
                }
              endif;
            endforeach;
          endforeach;
        }
      endforeach;
      DB::commit();
      $response = response()->json([
        'status' => 'success',
        'message' => 'Data berhasil disimpan',
        'redirect' => "/documents/{$idTemplate}"
      ]);
    } catch (\Throwable $throw) {
      DB::rollBack();
//      $response = $throw;
      $response = response()->json([
        'status' => 'error',
        'message' => 'Gagal menyimpan data'
      ]);
    }
    return $response;
  }

  public function destroy($id)
  {
    $response = response()->json([
      'status' => 'failed',
      'message' => 'Gagal menghapus data',
    ]);
    $data = TemplateData::findOrFail($id);
    if ($data->delete()) {
      $response = response()->json([
        'status' => 'success',
        'message' => 'Data berhasil dihapus',
      ]);
    }
    return $response;
  }

  public function render($id = NULL, $tag, $type, $name, $label, $arrayData = array(), $multiple = FALSE, $tableName = NULL, $tableChild = FALSE, $templateId = 0, $formDataId = 0, $edit = FALSE)
  {
    $select = NULL;
    $columns = [];
    if ($tag != 'table') {
      array_push($columns, 'MAX(CASE WHEN (`template_forms`.`name` = "' . $name . '") THEN `template_form_data`.`value` ELSE NULL END) as `value`');
    } else {
      array_push($columns, 'MAX(CASE WHEN (`template_forms`.`tag` = "' . $tag . '") THEN `template_forms`.`id` ELSE NULL END) as `value`');
    }
    if (count($columns) > 0) {
      $select .= ', ';
    }
    $select .= implode(', ', $columns);

    $templateFormData = TemplateFormData::select(DB::raw('`template_data`.`id` AS `id`' . $select))
      ->leftJoin('template_forms', 'template_forms.id', '=', 'template_form_data.template_form_id')
      ->leftJoin('template_data', 'template_data.id', '=', 'template_form_data.template_data_id')
      ->where('template_data.template_id', $templateId)
      ->where('template_form_data.template_data_id', $formDataId)
      ->groupBy('template_data.id')
      ->first();

    $render = NULL;
    if ($tag === 'input') {
      if ($type == 'text') {
        $render['html'] = '
          <div class="col-md-6">
            <div class="form-group">
              <label>' . $label . '</label>
              <input type="text" name="' . $name . '" class="form-control" placeholder="Input ' . $label . '" value="' . ($templateFormData->value ?? NULL) . '"/>
            </div>
          </div>
        ';
      } elseif ($type == 'number') {
        $render['html'] = '
          <div class="col-md-6">
            <div class="form-group">
              <label>' . $label . '</label>
                <input type="number" name="' . $name . '" class="form-control" placeholder="Input ' . $label . '" value="' . ($templateFormData->value ?? NULL) . '"/>
            </div>
          </div>
        ';
      } elseif ($type == 'decimal') {
        $render['html'] = '
          <div class="col-md-6">
            <div class="form-group">
              <label>' . $label . '</label>
              <input type="text" name="' . $name . '" class="form-control decimal" placeholder="Input ' . $label . '" value="' . ($templateFormData->value ?? NULL) . '"/>
            </div>
          </div>
        ';
      } elseif ($type == 'file') {
        $render['html'] = '
          <div class="col-md-6">
            <div class="form-group">
              <label>' . $label . '</label>
              <div class="custom-file">
									<input type="file" class="custom-file-input" id="customFile" name="' . $name . '" accept=".doc,.docx,.pdf">
									<label class="custom-file-label" for="customFile">Choose file</label>
							</div>
            </div>
          </div>
        ';
      } elseif ($type == 'date') {
        $render['html'] = '
          <div class="col-md-6">
            <div class="form-group">
              <label>' . $label . '</label>
              <input type="text" name="' . $name . '" class="form-control date" placeholder="Input ' . $label . '" value="' . ($templateFormData->value ?? NULL) . '" readonly/>
            </div>
          </div>
        ';
      } elseif ($type == 'datetime') {
        $render['html'] = '
          <div class="col-md-6">
            <div class="form-group">
              <label>' . $label . '</label>
              <input type="text" name="' . $name . '" class="form-control datetimepicker" placeholder="Input ' . $label . '" />
            </div>
          </div>
        ';
      } elseif ($type == 'image') {
        $render['html'] = '
          <div class="col-md-6">
            <div class="form-group">
              <label>' . $label . '</label>
              <input type="text" class="form-control" name="' . $name . '" accept=".jpg,.png,.jpeg">
            </div>
          </div>
        ';
      } elseif ($type == 'currency') {
        $render['html'] = '
          <div class="col-md-6">
            <div class="form-group">
              <label>' . $label . '</label>
              <input type="text" class="form-control currency" name="' . $name . '" value="' . ($templateFormData->value ?? NULL) . '">
            </div>
          </div>
        ';
      } elseif ($type == 'time') {
        $render['html'] = '
          <div class="col-md-6">
            <div class="form-group">
              <label>' . $label . '</label>
              <input type="text" class="form-control time"  name="' . $name . '" value="' . ($templateFormData->value ?? NULL) . '" readonly>
            </div>
          </div>
        ';
      }
    } elseif ($tag == 'select') {
      $option = NULL;
      $checkboxVal = explode(", ", ($templateFormData->value ?? NULL));
      foreach ($arrayData as $item):
        $selected = $edit ? (in_array($item->option_value, $checkboxVal) ? 'selected' : NULL) : ($item->option_selected ? 'selected' : NULL);
        $option .= '<option value="' . $item->option_value . '" ' . $selected . '>' . $item->option_text . '</option>';
      endforeach;
      $render['html'] = '
        <div class="col-md-6">
          <div class="form-group">
            <label>' . $label . '</label>
              <select name="' . $name . '" class="form-control">
                ' . $option . '
              </select>
          </div>
        </div>
      ';
    } elseif ($tag == 'textarea') {
      $render['html'] = '
        <div class="col-md-6">
          <div class="form-group">
            <label>' . $label . '</label>
            <textarea class="form-control" name="' . $name . '"  rows="3">' . ($templateFormData->value ?? NULL) . '</textarea>
          </div>
        </div>
      ';
    } elseif ($tag == 'checkbox') {
      $option = NULL;
      $checkboxVal = explode(", ", ($templateFormData->value ?? NULL));
      foreach ($arrayData as $item):
        $checked = $edit ? (in_array($item->option_value, $checkboxVal) ? 'checked' : NULL) : ($item->option_selected ? 'checked' : NULL);
        $option .= '
            <label class="checkbox">
                <input type="checkbox" name="' . $name . ($multiple ? "[]" : NULL) . '" value="' . $item->option_value . '" ' . $checked . '/>
                 ' . $item->option_text . '
           </label>
        ';
      endforeach;
      $render['html'] = '
        <div class="col-md-6">
          <div class="form-group">
              <label>' . $label . '</label>
              <div class="checkbox-list">
                 ' . $option . '
              </div>
          </div>
        </div>
      ';
    } elseif ($tag == 'radio') {
      $option = NULL;
      $checkboxVal = explode(", ", ($templateFormData->value ?? NULL));
      foreach ($arrayData as $item):
        $checked = $edit ? (in_array($item->option_value, $checkboxVal) ? 'checked' : NULL) : ($item->option_selected ? 'checked' : NULL);
        $option .= '
            <label class="radio">
                <input type="radio" name="' . $name . ($tableChild ? "[]" : NULL) . ($multiple ? "[]" : NULL) . '" value="' . $item->option_value . '" ' . $checked . '/>
                <span></span> ' . $item->option_text . '
           </label>
        ';
      endforeach;
      $render['html'] = '
        <div class="col-md-6">
          <div class="form-group">
          <lavel>' . $label . '</lavel>
            <div class="radio-list">
               ' . $option . '
            </div>
          </div>
        </div>
      ';
    } elseif ($tag == 'table' || $tag == 'block') {
      $render['html'] = $this->tablerender($tag, $type, $name, $label, $arrayData, $templateId, $formDataId, $edit)['html'] ?? NULL;
      $render['js'] = $this->tablerender($tag, $type, $name, $label, $arrayData)['js'] ?? NULL;
    } elseif ($tag == 'ul' || $tag == 'ol') {
      $buildTable = NULL;
      if ($edit) {
        $ulolValue = explode(", ", ($templateFormData->value ?? NULL));
        $no = 1;
        foreach ($ulolValue as $val):
          $buildTable .= '<tr class="' . $name . '" id="' . $name . '_' . $no . '">';
          $buildTable .= $no > 1 ? '<td><button style="max-width: 50px" type="button" id="' . $name . '_' . $no . '" class="btn btn-block btn-danger rm' . $name . '">-</button></td>' : '<td></td>';
          $buildTable .= '<td><input type="text" name="' . $name . '[]' . '" class="form-control" placeholder="Input ' . $label . '" value="' . $val . '"/></td>';
          $buildTable .= '</tr>';
          $no++;
        endforeach;
      } else {
        $buildTable .= '<tr class="' . $name . '" id="' . $name . '_1">';
        $buildTable .= '<td></td>';
        $buildTable .= '<td><input type="text" name="' . $name . '[]' . '" class="form-control" placeholder="Input ' . $label . '"/></td>';
        $buildTable .= '</tr>';
      }
      $jshtml = '<input type="text" name="' . $name . sprintf("%s", "[]") . '" class="form-control" placeholder="Input ' . $label . '"/>';
      $jsInput = preg_replace("/\r|\n/", "", sprintf("%s", "'<td>$jshtml</td>'"));
      $render['html'] = '
          <label class="col-md-12">' . $label . ' :</label>
          <div class="col-md-8">
            <div class="table-responsive" id="tableOption">
               <table class="table table-bordered">
                  <thead>
                     <tr>
                       <th class="text-center" scope="col">
                         <button type="button" class="add' . $name . ' btn btn-sm btn-primary">+</button>
                       </th>
                        <th>' . $label . '</th>
                     </tr>
                     </thead>
                  <tbody>
                    ' . $buildTable . '
                  </tbody>
               </table>
            </div>
          </div>
        ';
      $jsAfter = "<tr class='$name' id='{$name}_" . sprintf("%s", '" + nextindex + "') . "'></tr>";
      $render['js'] = '
          $(".add' . $name . '").on("click", function () {
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

  public function tablerender($tag, $type, $name, $label, $arrayData = array(), $templateId = 0, $formDataId = 0, $edit = FALSE, $tableId = 0)
  {
    $buildTable = NULL;
    $jsInput = NULL;
    $thead = NULL;
    $html = NULL;
    $jshtml = NULL;
    $optionjs = NULL;
    $countVal = 0;
    if ($arrayData->count() > 0) {
      $countVal = TemplateFormData::leftJoin('template_data', 'template_data.id', '=', 'template_form_data.template_data_id')
        ->leftJoin('template_forms', 'template_forms.id', '=', 'template_form_data.id')
        ->where('template_form_data.template_data_id', $formDataId)
        ->where('template_form_data.template_form_id', $arrayData[0]->id)
        ->count();
      if ($countVal == 0) {
        $countVal = 1;
      }
    }
    foreach ($arrayData as $item):
      $thead .= "<th>$item->label</th>";
    endforeach;
    for ($i = 1; $i <= $countVal; $i++) {
      $index = $i - 1;
      $buildTable .= '<tr class="' . $name . '" id="' . $name . '_' . $i . '">';
      $buildTable .= $i > 1 ? '<td><button style="max-width: 50px" type="button" id="' . $name . '_' . $i . '" class="btn btn-block btn-danger rm' . $name . '">-</button></td>' : '<td></td>';
      foreach ($arrayData as $key => $item):
        $query = TemplateFormData::select('template_form_data.id', 'template_form_data.value')
          ->leftJoin('template_data', 'template_data.id', '=', 'template_form_data.template_data_id')
          ->leftJoin('template_forms', 'template_forms.id', '=', 'template_form_data.id')
          ->where('template_form_data.template_data_id', $formDataId)
          ->where('template_form_data.template_form_id', $item->id)
          ->get();
        $buildTable .= '<td>';
        if ($item->tag === 'input') {
          if ($item->type == 'text') {
            $html = '<input type="text" name="' . $name . '[' . $i . ']' . '[' . $item->name . ']' . '" class="form-control" placeholder="Input ' . $item->label . '" value="' . (isset($query[$index]->value) ? $query[$index]->value : NULL) . '"/>';
            $jshtml = '<input type="text" name="' . $name . sprintf("%s", "['+ nextindex +']") . '[' . $item->name . ']' . '" class="form-control" placeholder="Input ' . $item->label . '"/>';
          } elseif ($item->type == 'number') {
            $html = '<input type="number" name="' . $name . '[' . $i . ']' . '[' . $item->name . ']' . '" class="form-control" placeholder="Input ' . $item->label . '" value="' . (isset($query[$index]->value) ? $query[$index]->value : NULL) . '"/>';
            $jshtml = '<input type="number" name="' . $name . sprintf("%s", "['+ nextindex +']") . '[' . $item->name . ']' . '"  class="form-control" placeholder="Input ' . $item->label . '"/>';
          } elseif ($item->type == 'decimal') {
            $html = '<input type="text" name="' . $name . '[' . $i . ']' . '[' . $item->name . ']' . '" class="form-control decimal" placeholder="Input ' . $item->label . '" value="' . (isset($query[$index]->value) ? $query[$index]->value : NULL) . '"/>';
            $jshtml = '<input type="text" name="' . $name . sprintf("%s", "['+ nextindex +']") . '[' . $item->name . ']' . '" class="form-control decimal" placeholder="Input ' . $item->label . '"/>';
          } elseif ($item->type == 'file') {
            $html = '<div class="custom-file"><input type="file" class="custom-file-input" id="customFile" name="' . $name . '[' . $i . ']' . '[' . $item->name . ']' . '" accept=".doc,.docx,.pdf"><label class="custom-file-label" for="customFile">Choose file</label></div>';
            $jshtml = '<div class="custom-file"><input type="file" class="custom-file-input" id="customFile" name="' . $name . sprintf("%s", "['+ nextindex +']") . '[' . $item->name . ']' . '" accept=".doc,.docx,.pdf"><label class="custom-file-label" for="customFile">Choose file</label></div>';
          } elseif ($item->type == 'date') {
            $html = '<input type="text" name="' . $name . '[' . $i . ']' . '[' . $item->name . ']' . '" class="form-control date" placeholder="Input ' . $item->label . '" value="' . (isset($query[$index]->value) ? $query[$index]->value : NULL) . '" readonly/>';
            $jshtml = '<input type="text" name="' . $name . sprintf("%s", "['+ nextindex +']") . '[' . $item->name . ']' . '" class="form-control date" placeholder="Input ' . $item->label . '" readonly/>';
          } elseif ($item->type == 'datetime') {
            $html = '<input type="text" name="' . $name . '[' . $i . ']' . '[' . $item->name . ']' . '" class="form-control datetimepicker" placeholder="Input ' . $label . '" value="' . (isset($query[$index]->value) ? $query[$index]->value : NULL) . '"/>';
            $jshtml = '<input type="text" name="' . $name . sprintf("%s", "['+ nextindex +']") . '[' . $item->name . ']' . '" class="form-control datetimepicker" placeholder="Input ' . $label . '" />';
          } elseif ($item->type == 'image') {
            $html = '<input type="text" class="form-control" name="' . $name . '[' . $i . ']' . '[' . $item->name . ']' . '" accept=".jpg,.png,.jpeg">';
            $jshtml = '<input type="text" class="form-control" name="' . $name . sprintf("%s", "['+ nextindex +']") . '[' . $item->name . ']' . '" accept=".jpg,.png,.jpeg">';
          } elseif ($item->type == 'currency') {
            $html = '<input type="text" class="form-control currency" name="' . $name . '[' . $i . ']' . '[' . $item->name . ']' . '" value="' . (isset($query[$index]->value) ? $query[$index]->value : NULL) . '">';
            $jshtml = '<input type="text" class="form-control currency" name="' . $name . sprintf("%s", "['+ nextindex +']") . '[' . $item->name . ']' . '">';
          } elseif ($item->type == 'time') {
            $html = '<input type="text" class="form-control time"  name="' . $name . '[' . $i . ']' . '[' . $item->name . ']' . '" value="' . (isset($query[$index]->value) ? $query[$index]->value : NULL) . '" readonly>';
            $jshtml = '<input type="text" class="form-control time"  name="' . $name . sprintf("%s", "['+ nextindex +']") . '[' . $item->name . ']' . '" readonly>';
          }
        } elseif ($item->tag == 'select') {
          $option = NULL;
          $checkboxVal = explode(", ", ($templateFormData->value ?? NULL));
          foreach ($item->selectoption as $itemSelect):
            $selected = $edit ? (in_array($item->option_value, $checkboxVal) ? 'selected' : NULL) : ($item->option_selected ? 'selected' : NULL);
            $option .= '<option value="' . $itemSelect->option_value . '" ' . $selected . '>' . $itemSelect->option_text . '</option>';
          endforeach;
          $html = '
          <select name="' . $name . '[' . $i . ']' . '[' . $item->name . ']' . '" class="form-control">
            ' . $option . '
          </select>
        ';
          $jshtml = '
          <select name="' . $name . sprintf("%s", "['+ nextindex +']") . '[' . $item->name . ']' . '" class="form-control">
            ' . $option . '
          </select>
        ';
        } elseif ($item->tag == 'textarea') {
          $html = '<textarea class="form-control"  name="' . $name . '[' . $i . ']' . '[' . $item->name . ']' . '" rows="3">' . (isset($query[$index]->value) ? $query[$index]->value : NULL) . '</textarea>';
          $jshtml = '<textarea class="form-control"  name="' . $name . sprintf("%s", "['+ nextindex +']") . '[' . $item->name . ']' . '" rows="3"></textarea>';
        } elseif ($item->tag == 'checkbox') {
          $option = NULL;
          $edited = (isset($query[$index]->value) ? explode(', ', $query[$index]->value) : array());
          foreach ($item->selectoption as $itemCheckbox):
            $checkboxStatus = NULL;
            foreach ($edited as $itemChecked) {
              if ($itemChecked == $itemCheckbox['option_value']) {
                $checkboxStatus = 'checked';
                break;
              } else {
                $checkboxStatus = NULL;
              }
            }
            $option .= '
            <label class="checkbox">
                <input type="checkbox" name="' . $name . '[' . $i . ']' . '[' . $item->name . ']' . ($item->multiple ? "[]" : NULL) . '" value="' . $itemCheckbox->option_value . '" ' . $checkboxStatus . '/>  ' . $itemCheckbox->option_text . '
           </label>
          ';
            $optionjs .= '
            <label class="checkbox">
                <input type="checkbox" name="' . $name . sprintf("%s", "['+ nextindex +']") . '[' . $item->name . ']' . ($item->multiple ? "[]" : NULL) . '" value="' . $itemCheckbox->option_value . '" ' . ($itemCheckbox->option_selected ? 'checked' : NULL) . '/>  ' . $itemCheckbox->option_text . '
           </label>
          ';
          endforeach;
          $html = '<div class="checkbox-list">' . $option . '</div>';
          $jshtml = '<div class="checkbox-list">' . $optionjs . '</div>';
        } elseif ($item->tag == 'radio') {
          $option = NULL;
          $checkboxVal = explode(", ", ($templateFormData->value ?? NULL));
          foreach ($item->selectoption as $itemRadio):
            $checked = $edit ? (in_array($item->option_value, $checkboxVal) ? 'checked' : NULL) : ($item->option_selected ? 'checked' : NULL);
            $option .= '
              <label class="radio">
                <input type="radio" name="' . $name . '[' . $i . ']' . '[' . $item->name . ']' . '" value="' . $itemRadio->option_value . '" ' . $checked . '/>
                <span></span> ' . $itemRadio->option_text . '
             </label>
            ';
            $optionjs .= '
              <label class="radio">
                <input type="radio" name="' . $name . sprintf("%s", "['+ nextindex +']") . '[' . $item->name . ']' . '" ' . ($itemRadio->option_selected ? 'checked' : NULL) . '/>
                <span></span> ' . $itemRadio->option_text . '
             </label>
            ';
          endforeach;
          $html = '<div class="radio-list">' . $option . '</div>';
          $jshtml = '<div class="radio-list">' . $optionjs . '</div>';
        }
        $buildTable .= $html;
        $buildTable .= '</td>';
        $jsInput .= preg_replace("/\r|\n/", "", sprintf("%s", "'<td>$jshtml</td>'"));
        if ((count($arrayData) - 1) != $key) {
          $jsInput .= sprintf("%s", "+ \n");
        }
      endforeach;
      $buildTable .= '</tr>';
    }
    if (isset($thead)) {
      $render['html'] = '
          <label class="col-md-12">' . $label . ' :</label>
          <div class="col-md-12">
            <div class="table-responsive" id="tableOption">
               <table class="table table-bordered">
                  <thead>
                     <tr>
                       <th class="text-center" scope="col">
                         <button type="button" class="add' . $name . ' btn btn-sm btn-primary">+</button>
                       </th>
                        ' . $thead . '
                     </tr>
                     </thead>
                  <tbody>
                    ' . $buildTable . '
                  </tbody>
               </table>
            </div>
          </div>
        ';
      $jsAfter = "<tr class='$name' id='{$name}_" . sprintf("%s", '" + nextindex + "') . "'></tr>";
      $render['js'] = '
          $(".add' . $name . '").on("click", function () {
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
