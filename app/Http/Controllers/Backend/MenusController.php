<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Menus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MenusController extends Controller
{
  public function index()
  {
    $config['page_title']       ="List Menus";
    $config['page_description'] ="Manage menu structure";
    $page_breadcrumbs = [
      ['page' => '#','title' => "List Menus"],
    ];
    $data['nestable']             = $this->show_nestable_menu('top-menu');
    return view('backend.menus.index', compact('config', 'page_breadcrumbs','data'));
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'title'      => 'required|string',
      'url'        => 'required|string',
      'menu_type'  => 'required|string',
    ]);

    if($validator->passes()){
      Menus::create([
        'title'     => $request->input('title'),
        'url'       => $request->input('url'),
        'menu_type' => $request->input('menu_type'),
        'target'    => $request->input('target') ?? '_self',
        'sort'      => Menus::where('menu_type', $request->input('menu_type'))->count() + 1
      ]);
      $response = response()->json([
        'status' => 'success',
        'message' => 'Data has been saved',
        'redirect' => '/menus'
      ]);
    }else{
      $response = response()->json(['error'=>$validator->errors()->all()]);
    }

    return $response;
  }

  public function edit($id)
  {
    $config['page_title']       = "Edit Menus";
    $config['page_description'] = "Manage menu structure";
    $page_breadcrumbs = [
      ['page' => '/menus','title' => "List Menus"],
      ['page' => '#','title' => "Edit Menus"],
    ];
    $menu = Menus::findOrFail($id);
    $data['nestable']   = $this->show_nestable_menu('top-menu');

    return view('backend.menus.edit', compact('config', 'page_breadcrumbs', 'data', 'menu'));
  }

  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'title'      => 'required|string',
      'url'        => 'required|string',
      'menu_type'  => 'required|string',
    ]);

    if($validator->passes()){
      $data = Menus::find($id);
      $data->update([
        'title'     => $request->input('title'),
        'url'       => $request->input('url'),
        'menu_type' => $request->input('menu_type'),
        'target'    => $request->input('target') ?? '_self',
      ]);
      $response = response()->json([
        'status' => 'success',
        'message' => 'Data has been updated',
        'redirect' => '/menus'
      ]);
    }else{
      $response = response()->json(['error'=>$validator->errors()->all()]);
    }

    return $response;
  }

  public function destroy($id)
  {
    $data = Menus::find($id);
    if($data->delete()){
      $child = Menus::where('parent_id', $id)->get();
      $parentMax = Menus::where('parent_id', 0)->max('sort');
      $increment = 1;
      foreach($child as $item):
        Menus::where('id', $item->id)->update([
          'parent_id' => 0,
          'sort' => $parentMax + $increment
        ]);
        $increment++;
      endforeach;

      $response = response()->json([
          'status' => 'success',
          'message' => 'Data has been deleted',
          'redirect' => '/menus'
      ]);
    }
    return $response;
  }

  public function show_nestable_menu($menu_type, $parent_id = 0)
  {
    $data = Menus::where('menu_type', $menu_type)->where('parent_id', $parent_id)->orderBy('sort', 'asc');
		$html = "";
		if($data->count() > 0 ){
			$html .= '<ol class="dd-list">';
			foreach ($data->get() AS $val):
			$html .= '<li class="dd-item dd3-item" data-id="'. $val['id'] .'">
						<div class="dd-handle dd3-handle"></div>
						<div class="dd3-content">'. $val['title'] .'</div>
						<div class="dd3-actions">
							<div class="btn-group">
								<a href="menus/'. $val['id'] .'/edit" class="btn btn-sm btn-default"
									><i class="fa fa-fw fa-edit"></i>
								</a>
								<button
									type="button"
									class="btn-delete btn btn-sm btn-default"
									data-action="menus/'. $val['id'] .'"
									><i class="fa fa-fw fa-trash"></i>
								</button>
							</div>
						</div>
					';
			$html .= $this->show_nestable_menu($menu_type,$val['id']);
			$html .= '</li>';
			endforeach;
			$html .= '</ol>';
		}
		return $html;
	}

  public function render_menu_hierarchy($data = array(), $parentMenu = 0, $result = array())
  {
		foreach($data AS $key => $val){
			$row['id'] = $val['id'];
			$row['parent_id'] = $parentMenu;
			$row['sort'] = ($key + 1);
			array_push($result,$row);
			if(isset($val['children']) && $val['children'] > 0){
				$result = array_merge($result,$this->render_menu_hierarchy($val['children'], $val['id']));
			}
		}
		return $result;
	}

  public function change_hierarchy(Request $request)
  {
		$response['status'] 	= "error";
		$response['message'] 	= "Please check your input";
		$data 					= json_decode($request->input('hierarchy'),TRUE);
		$items 					= $this->render_menu_hierarchy($data);
    DB::beginTransaction();
    try {
      foreach($items AS $item):
        $data = Menus::find($item['id']);
        $data->update([
          'parent_id' => $item['parent_id'],
          'sort'      => $item['sort'],
        ]);
      endforeach;

      DB::commit();
      $response = response()->json([
          'status' => 'success',
          'message' => 'Data has been saved',
          'redirect' => '/menus'
      ]);
    } catch (\Exception $e) {
      DB::rollback();
      $response = response()->json([
          'status' => 'error',
          'error' => "Data can't be saved"
      ]);

    }
		return $response;
	}
}
