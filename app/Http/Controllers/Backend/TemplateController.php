<?php

namespace App\Http\Controllers\Backend;

use App\Facades\Fileupload;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TemplateController extends Controller
{
  public function index()
  {

  }

  public function create()
  {
    $config['page_title'] = "Create Document";
    $config['page_description'] = "Manage Document list";
    $page_breadcrumbs = [
      ['page' => '/templates', 'title' => "List Document"],
      ['page' => '#', 'title' => "Create Document"],
    ];

    return view('backend.templates.index', compact('config', 'page_breadcrumbs'));
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'file' => 'required|mimes:doc,docx,dotx',
    ]);

    if ($validator->passes()) {
      $filePath = 'document';
      $file = $request->file('file');
      $ext = $file->getClientOriginalExtension();
      $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . Carbon::now()->timestamp) . '.' . $ext;

      if (!File::isDirectory("$filePath")) {
        File::makeDirectory("$filePath", 0777, true);
      }
      Storage::disk('public_upload')->putFile("$filePath", $file);
      dd($fileName);
    } else {
      $response = response()->json(['error' => $validator->errors()->all()]);
    }
    return $response;

  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
