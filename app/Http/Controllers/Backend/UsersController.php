<?php

namespace App\Http\Controllers\Backend;

use App\Facades\Fileupload;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use Validator;

class UsersController extends Controller
{
  public function index(Request $request)
  {
    $config['page_title'] = "List User";
    $config['page_description'] = "List User";
    $page_breadcrumbs = [
      ['page' => '#', 'title' => "List User"],
    ];

    if ($request->ajax()) {
      $data = User::whereHas('roles', function ($query) {
        return $query->where('name', '<>', 'super-admin');
      });
      return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function ($row) {
          $actionBtn = '
              <div class="btn-group" role="group">
                  <button id="btnGroupDrop1" type="button" class="btn btn-secondary font-weight-bold dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="la la-file-text-o"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                      <a class="dropdown-item" href="users/' . $row->id . '/edit">Ubah</a>
                      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalReset" data-id="' . $row->id . '">Reset Password</a>
                      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalDelete" data-id="' . $row->id . '">Hapus</a>
                  </div>
              </div>
          ';
          return $actionBtn;
        })->editColumn('image', function (User $user) {
          return !empty($user->image) ? asset("/images/thumbnail/$user->image") : asset('media/users/blank.png');
        })->addColumn('roles', function ($row) {
          return ucfirst($row->getRoleNames()[0]);
        })
        ->make(true);
    }
    return view('backend.users.index', compact('config', 'page_breadcrumbs'));
  }

  public function create()
  {
    $config['page_title'] = "Tambah User";
    $page_breadcrumbs = [
      ['page' => '/backend/users', 'title' => "List User"],
      ['page' => '#', 'title' => "Tambah User"],
    ];
    $data = array(
      'roles' => Role::select('name')->where('name', '!=', 'super-admin')->get()
    );
    return view('backend.users.create', compact('config', 'page_breadcrumbs', 'data'));
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'username' => 'required|string|unique:users',
      'email' => 'nullable|string|unique:email',
      'active' => 'required|between:0,1',
      'password' => 'required|confirmed',
      'profile_avatar' => 'image|mimes:jpg,png,jpeg|max:2048',
      'profile_avatar_remove' => 'between:0,1,NULL'
    ]);

    if ($validator->passes()) {
      $image = NULL;
      $dimensions = [array('300', '300', 'thumbnail')];
      DB::beginTransaction();
      try {
        if (isset($request->profile_avatar) && !empty($request->profile_avatar)) {
          $image = Fileupload::uploadImagePublic('profile_avatar', $dimensions, 'public');
        }
        $user = User::create([
          'email' => $request->input('email'),
          'name' => $request->input('name'),
          'username' => $request->input('username'),
          'password' => Hash::make($request->password),
          'active' => $request->input('active'),
          'image' => $image,
        ]);
        $user->assignRole($request->role);

        DB::commit();
        $response = response()->json([
          'status' => 'success',
          'message' => 'Data has been saved',
          'redirect' => '/backend/users'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        $response = response()->json([
          'status' => 'error',
          'error' => ['Username/Email sudah ada']
        ]);

      }
    } else {
      $response = response()->json(['error' => $validator->errors()->all()]);
    }
    return $response;

  }

  public function edit($id)
  {
    $config['page_title'] = "Edit Users";
    $page_breadcrumbs = [
      ['page' => '/backend/users', 'title' => "List User"],
      ['page' => '#', 'title' => "Edit User"],
    ];

    $logInUser = Auth::user()->roles()->first()->name;
    if ($id == Auth::id() || in_array($logInUser, ['super-admin', 'admin'])) {
      $user = User::findOrFail($id);
      $userRole = $user->roles->first();

      $roles = Role::query()->select('name');
      $roles->when($userRole->name == 'super-admin', function ($q) {
        return $q->where('name', '=', 'super-admin')->pluck('name', 'name');
      });
      $roles->when($userRole->name != 'super-admin', function ($q) {
        return $q->where('name', '!=', 'super-admin')->pluck('name', 'name');
      });
      $data = array(
        'user' => $user,
        'roles' => $roles->get(),
        'userRole' => $userRole
      );
    } else {
      $errors = [
        'code' => '401',
        'message' => 'Unauthorized'
      ];
      return view('errors.401', compact('errors'));
    }

    return view('backend.users.edit', compact('config', 'page_breadcrumbs', 'logInUser', 'id', 'data'));
  }

  public function update(Request $request, $id)
  {
    $logInUser = Auth::user()->roles()->first()->name;
    if ($id == Auth::id() || in_array($logInUser, ['super-admin', 'admin'])) {
      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'username' => 'required|unique:users,username,' . $id,
        'email' => 'nullable|unique:users,email,' . $id,
        'active' => 'required|between:0,1',
        'profile_avatar' => 'image|mimes:jpg,png,jpeg|max:2048',
        'profile_avatar_remove' => 'between:0,1,NULL'
      ]);

      $data = User::findOrFail($id);
      $userRole = $data->roles->first();
      if ($validator->passes()) {
        $image = NULL;
        $dimensions = [array('300', '300', 'thumbnail')];
        DB::beginTransaction();
        try {
          if (isset($request->profile_avatar) && !empty($request->profile_avatar)) {
            $image = Fileupload::uploadImagePublic('profile_avatar', $dimensions, 'public', $data->image);
            File::delete(["images/original/$data->image", "images/thumbnail/$data->image"]);
          }
          $data->update([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'active' => $request->input('active'),
            'image' => $image,
          ]);
          if (isset($request->role)) {
            $data->removeRole($userRole->name);
            $data->assignRole($request->role);
          }
          DB::commit();
          $response = response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan',
            'redirect' => '/backend/users'
          ]);
        } catch (\Exception $e) {
          DB::rollback();
          $response = response()->json([
            'status' => 'error',
            'error' => 'Gagal menyimpan data'
          ]);
        }
      } else {
        $response = response()->json(['error' => $validator->errors()->all()]);
      }
    } else {
      $errors = [
        'code' => '401',
        'message' => 'Unauthorized'
      ];
      return view('errors.401', compact('errors'));
    }
    return $response;
  }

  public function destroy($id)
  {
    $response = response()->json([
      'status' => 'failed',
      'message' => 'Data tidak bisa dihapus',
    ]);
    $data = User::findOrFail($id);
    File::delete(["images/original/$data->image", "images/thumbnail/$data->image"]);
    if ($data->delete()) {
      $response = response()->json([
        'status' => 'success',
        'message' => 'Data berhasil disimpan',
      ]);
    }
    return $response;
  }

  public function resetpassword(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'id' => 'required|integer',
    ]);

    if ($validator->passes()) {
      $data = User::findOrFail($request->id);
      $data->password = Hash::make($data->username);
      if ($data->save()) {
        $response = response()->json([
          'status' => 'success',
          'message' => 'Data berhasil disimpan'
        ]);
      }
    } else {
      $response = response()->json(['error' => $validator->errors()->all()]);
    }
    return $response;
  }

  public function changepassword(Request $request)
  {
    $id = Auth::id();
    $validator = Validator::make($request->all(), [
      'old_password' => ['required', new MatchOldPassword($id)],
      'password' => 'required|between:6,255|confirmed',
    ]);
    $response = response()->json([
      'status' => 'failed',
      'message' => 'Password lama salah'
    ]);
    if ($validator->passes()) {
      $data = User::findOrFail($id);
      $data->password = Hash::make($request->password);
      if ($data->save()) {
        $response = response()->json([
          'status' => 'success',
          'message' => 'Password berhasil diubah'
        ]);
      }
    } else {
      $response = response()->json(['error' => $validator->errors()->all()]);
    }
    return $response;
  }
}
