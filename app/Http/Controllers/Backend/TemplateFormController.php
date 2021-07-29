<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TemplateForm;
use App\Models\TemplateFormOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TemplateFormController extends Controller
{

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'template_id' => 'required|integer',
      'parent_id' => 'nullable|integer',
      'tag' => 'required',
      'type' => 'required',
      'name' => 'nullable',
      'label' => 'required|string',
      'is_column_table' => 'between:0,1'
    ]);

    if ($validator->passes()) {
      try {
        DB::beginTransaction();
        $items['value'] = $request->input('formoption.value');
        $items['text'] = $request->input('formoption.text');
        $items['selected'] = $request->input('formoption.selected');

        if ($request->input('parent_id')) {
          $max = TemplateForm::where('template_id', $request->input('template_id'))
            ->where('parent_id', $request->input('parent_id'))
            ->max('sort_order');
        } else {
          $max = TemplateForm::where('template_id', $request->input('template_id'))
            ->whereNull('parent_id')
            ->max('sort_order');
        }
        $multiple = 0;
        if($request->input('tag') == 'checkbox'){
          $multiple = $request->input('multiple');
        }elseif(in_array($request->input('tag'), ['ul', 'ol'])){
          $multiple = 1;
        }

        $templateForm = TemplateForm::create([
          'template_id' => $request->input('template_id'),
          'parent_id' => $request->input('parent_id'),
          'tag' => $request->input('tag'),
          'type' => $request->input('type'),
          'name' => $request->input('name'),
          'label' => $request->input('label'),
          'multiple' => $multiple,
          'sort_order' => $max += 1,
          'is_column_table' => $request->input('is_column_table') ?? '0',
        ]);

        $type = ['select', 'checkbox', 'radio'];
        if (in_array($request->input('tag'), $type)) {
          foreach ($items['value'] as $key => $item):
            TemplateFormOption::create([
              'template_form_id' => $templateForm->id,
              'option_text' => $items['text'][$key],
              'option_value' => $item,
              'option_selected' => $items['selected'][$key] ?? 0
            ]);
          endforeach;
        }
        DB::commit();

        $response = response()->json([
          'status' => 'success',
          'message' => 'Data has been saved',
          'redirect' => 'reload',
        ]);
      } catch (\Throwable $throw) {
        DB::rollBack();
        $response = $throw;
      }
    } else {
      $response = response()->json(['error' => $validator->errors()->all()]);
    }
    return $response;
  }

  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'id' => 'required|integer',
      'template_id' => 'required|integer',
      'parent_id' => 'nullable|integer',
      'tag' => 'required',
      'type' => 'required',
      'name' => 'nullable',
      'label' => 'required|string',
      'is_column_table' => 'between:0,1'
    ]);

    if ($validator->passes()) {
      try {
        DB::beginTransaction();
        $items['value'] = $request->input('formoption.value');
        $items['text'] = $request->input('formoption.text');
        $items['selected'] = $request->input('formoption.selected');

        $data = TemplateForm::findOrFail($request->input('id'));
        $multiple = 0;
        if ($request->input('tag') == 'checkbox') {
          $multiple = $request->input('multiple');
        } else if (in_array($request->input('tag'), ['li', 'ol'])) {
          $multiple = 1;
        }
        $data->selectoption()->delete();
        $data->update([
          'parent_id' => $request->input('parent_id'),
          'tag' => $request->input('tag'),
          'type' => $request->input('type'),
          'name' => $request->input('name'),
          'label' => $request->input('label'),
          'multiple' => $multiple,
          'is_column_table' => $request->input('is_column_table') ?? '0',
        ]);

        $type = ['select', 'checkbox', 'radio'];
        if (in_array($request->input('tag'), $type)) {
          foreach ($items['value'] as $key => $item):
            TemplateFormOption::create([
              'template_form_id' => $data->id,
              'option_text' => $items['text'][$key],
              'option_value' => $item,
              'option_selected' => $items['selected'][$key] ?? 0
            ]);
          endforeach;
        }
        DB::commit();

        $response = response()->json([
          'status' => 'success',
          'message' => 'Data has been saved',
          'redirect' => "/templates/{$id}",
        ]);
      } catch (\Throwable $throw) {
        DB::rollBack();
        $response = $throw;
      }
    } else {
      $response = response()->json(['error' => $validator->errors()->all()]);
    }
    return $response;
  }

  public function change_hierarchy(Request $request, $id)
  {
    DB::beginTransaction();
    try {
      $items = $request->input('data');
      $noParent = 1;
      foreach ($items as $item):
        $data = TemplateForm::where('template_id', $id)->where('id', $item['parent'])->sole();
        $data->update([
          'sort_order' => $noParent++,
        ]);
        $noChild = 1;
        foreach ($item['child'] as $child):
          $data = TemplateForm::where('template_id', $id)->where('id', $child)->sole();
          $data->update([
            'sort_order' => $noChild++,
          ]);
        endforeach;
      endforeach;

      DB::commit();
      $response = response()->json([
        'status' => 'success',
        'message' => 'Data berhasil disimpan',
      ]);
    } catch (\Exception $e) {
      DB::rollback();
      $response = response()->json([
        'status' => 'error',
        'error' => 'Gagal menyimpan data'
      ]);
    }
    return $response;
  }

  public function destroy($id)
  {
    DB::beginTransaction();
    try {
      $dataDelete = TemplateForm::findOrFail($id);
      $templateId = $dataDelete->template_id;
      TemplateForm::where('parent_id', $dataDelete->id)->delete();

      if ($dataDelete->delete()) {
        $data = TemplateForm::with('children')
          ->where('template_id', $templateId)
          ->orderBy('sort_order', 'asc')
          ->get();
        $noParent = 1;
        foreach ($data as $item):
          $data = TemplateForm::findOrFail($item->id);
          $data->update([
            'sort_order' => $noParent++,
          ]);
          $noChild = 1;
          foreach ($item->children as $child):
            $data = TemplateForm::findOrFail($child->id);
            $data->update([
              'sort_order' => $noChild++,
            ]);
          endforeach;
        endforeach;
      }

      DB::commit();
      $response = response()->json([
        'status' => 'success',
        'message' => 'Data berhasil dihapus',
        'redirect' => "/templates/$templateId"
      ]);
    } catch (\Exception $e) {
      DB::rollback();
      $response = response()->json([
        'status' => 'error',
        'error' => 'Gagal menghapus data'
      ]);
    }
    return $response;
  }
}
