<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $formation = Formation::query()->select('id', 'name')->get();
      $data = collect($formation)->map(function($data) {
        return collect($data)->merge([
          'id_formation' => Crypt::encrypt($data->id)
        ]);
      });

      return view('frontend.main', compact('data'));
    }

    public function show($id)
    {
      try {
        $decrypted = Crypt::decrypt($id);
        $data = Formation::where('id', $decrypted)->select('description')->first();
      } catch (DecryptException $e) {

      }

      return response()->json($data);
    }
}
