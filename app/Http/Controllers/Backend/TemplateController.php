<?php

namespace App\Http\Controllers\Backend;

use App\Facades\Fileupload;
use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\TemplateForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TemplateController extends Controller
{
  public function index(Request $request)
  {
    $config['page_title'] = "Daftar Template";
    $config['page_description'] = "Daftar Template";
    $page_breadcrumbs = [
      ['page' => '#', 'title' => "Daftar Template"],
    ];

    if ($request->ajax()) {
      $data = Template::query();
      return DataTables::of($data)
        ->addColumn('doc', function ($row) {
          return '
          <a class="btn btn-primary" href=' . asset("/template/$row->file") . '><i class="fas fa-file-word pr-0"></i></a>
          ';
        })
        ->addColumn('action', function ($row) {
          return '
              <div class="btn-group" role="group">
                  <button id="btnGroupDrop1" type="button" class="btn btn-primary font-weight-bold dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="la la-file-text-o"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                      <a class="dropdown-item" href="templates/' . $row->id . '">Atur Konfigurasi</a>
                      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalEdit" data-id="' . $row->id . '"  data-name="' . $row->name . '">Ubah</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalDelete" data-id="' . $row->id . '">Hapus</a>
                  </div>
              </div>
          ';
        })
        ->rawColumns(['doc', 'action'])
        ->make(true);
    }
    return view('backend.templates.index', compact('config', 'page_breadcrumbs'));
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string',
      'file' => 'required|mimes:doc,docx,dotx',
    ]);

    if ($validator->passes()) {
      $fileName = Fileupload::uploadFilePublic('file', 'public');
      Template::create([
        'name' => $request->input('name'),
        'file' => $fileName
      ]);
      $response = response()->json([
        'status' => 'success',
        'message' => 'Data has been saved',
      ]);
    } else {
      $response = response()->json(['error' => $validator->errors()->all()]);
    }
    return $response;
  }

  public function show($id)
  {
    $validator = Validator::make(['id' => $id], [
      'id' => 'required|integer',
    ]);
    if ($validator->passes()) {
      $config['page_title'] = "Atur Konfigurasi Template";
      $config['page_description'] = "Atur Konfigurasi Template";
      $config['form_title'] = "Tambah Field";
      $config['tree_title'] = "Struktur & Urutan Data Field";
      $page_breadcrumbs = [
        ['page' => '/templates', 'title' => "Daftar Template"],
        ['page' => '#', 'title' => "Atur Konfigurasi Template"],
      ];

      $data = TemplateForm::where('template_id', $id)
        ->whereIn('tag', ['table', 'block'])
        ->get();

      $tree = TemplateForm::with('children')
        ->where('template_id', $id)
        ->whereNull('parent_id')
        ->orderBy('sort_order', 'asc')
        ->get();
      return view('backend.templates.show', compact('config', 'page_breadcrumbs', 'id', 'data', 'tree'));
    } else {
      return abort(404, 'Forbidden');
    }
  }

  public function edit(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'id' => 'required|integer',
    ]);
    if ($validator->passes()) {
      $config['page_title'] = "Atur Konfigurasi Template";
      $config['page_description'] = "Atur Konfigurasi Template";
      $config['form_title'] = "Ubah Field";
      $config['tree_title'] = "Struktur & Urutan Data Field";
      $page_breadcrumbs = [
        ['page' => '/templates', 'title' => "Daftar Template"],
        ['page' => '#', 'title' => "Atur Konfigurasi Template"],
      ];

      $templateFormId = $request->id;
      $data = TemplateForm::where('template_id', $id)
        ->whereIn('tag', ['table', 'block'])
        ->get();

      $edited = TemplateForm::with(['selectoption', 'parent'])->withCount('children')->findOrFail($request->input('id'));
      $tree = TemplateForm::with('children')
        ->where('template_id', $id)
        ->whereNull('parent_id')
        ->orderBy('sort_order', 'asc')
        ->get();

      if($edited->tag == 'input'){
        $type = [
          ['val' => 'text', 'text' => 'Text'],
          ['val' => 'number', 'text' => 'Number'],
          ['val' => 'decimal', 'text' => 'Decimal'],
          ['val' => 'file', 'text' => 'File'],
          ['val' => 'date', 'text' => 'Date'],
          ['val' => 'datetime', 'text' => 'Datetime'],
          ['val' => 'image', 'text' => 'Image'],
          ['val' => 'currency', 'text' => 'Currency'],
          ['val' => 'time', 'text' => 'Time'],
        ];
      }else{
        $type = [
          ['val' => 'text', 'text' => 'Text'],
        ];
      }
      $selectBox = ["select", "checkbox", "radio"];
      return view('backend.templates.edit', compact('config', 'page_breadcrumbs', 'id', 'templateFormId', 'data', 'tree', 'edited', 'type', 'selectBox'));
    } else {
      return abort(404, 'Forbidden');
    }
  }

  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string',
      'file' => 'nullable|mimes:doc,docx',
    ]);
    $data = Template::findOrFail($id);
    if ($validator->passes()) {
      if (isset($request->file) && !empty($request->file)) {
        $fileName = Fileupload::uploadFilePublic('file', 'public');
        Fileupload::deleteFilePublic($data->file);
        $data->update([
          'name' => $request->input('name'),
          'file' => $fileName,
        ]);
      } else {
        $data->update([
          'name' => $request->input('name'),
        ]);
      }
      $response = response()->json([
        'status' => 'success',
        'message' => 'Data has been saved',
      ]);
    } else {
      $response = response()->json(['error' => $validator->errors()->all()]);
    }
    return $response;
  }

  public function destroy($id)
  {
    $response = response()->json([
      'status' => 'failed',
      'message' => 'Data tidak bisa dihapus',
    ]);
    $data = Template::findOrFail($id);
    Fileupload::deleteFilePublic($data->file);
    if ($data->delete()) {
      $response = response()->json([
        'status' => 'success',
        'message' => 'Data berhasil disimpan',
      ]);
    }
    return $response;
  }
}
