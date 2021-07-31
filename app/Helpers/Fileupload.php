<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Image;
use File;
use Illuminate\Support\Str;

class Fileupload
{
  public $image_path;
  public $document_path;

  // [array('800', '450', 'thumbnail'), array('1280', '720', 'compress')]
  public static function uploadImagePublic($file, $dimensions = NULL, $location = 'storage', $old_file = NULL, $fileName = NULL, $imagetype = NULL)
  {
    if ($imagetype == 'base64') {
      $image = $file;  // your base64 encoded

      $publicPath = public_path('template_image');
      if (!File::isDirectory("$publicPath")) {
        File::makeDirectory("$publicPath", 0755, true);
      }
      $image = str_replace('data:image/png;base64,', '', $image);
      $image = str_replace(' ', '+', $image);
      $imageName = Carbon::now()->timestamp.'.png';
      Image::make(base64_decode($image))->save($publicPath . '/' . $imageName);
      return $imageName;
    } else {
      if (request()->hasFile($file)) {
        if ($location == 'storage') {
          $image_path = storage_path('app/public/images');
          $file = request()->file($file);
          $ext = $file->getClientOriginalExtension();
          $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . Carbon::now()->timestamp) . '.' . $ext;

          if (!File::isDirectory("$image_path/original")) {
            File::makeDirectory("$image_path/original", 0777, true);
          }
          Image::make($file)->save($image_path . '/original/' . $fileName);
          File::delete("images/original/$old_file");

          foreach ($dimensions as $row) {
            $canvas = Image::canvas($row[0], $row[1]);
            $resizeImage = Image::make($file)->resize($row[0], $row[1], function ($constraint) {
              $constraint->aspectRatio();
            });
            if (!File::isDirectory($image_path . '/' . $row[2])) {
              File::makeDirectory($image_path . '/' . $row[2], 0777, true);
            }
            $canvas->insert($resizeImage, 'center');
            $canvas->save($image_path . '/' . $row[2] . '/' . $fileName);
            File::delete("images/$row[2]/$old_file");
          }
        } else {
          $image_path = public_path('images');
          $file = request()->file($file);
          $ext = $file->getClientOriginalExtension();
          $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . Carbon::now()->timestamp) . '.' . $ext;

          if (!File::isDirectory("$image_path/original")) {
            File::makeDirectory("$image_path/original", 0755, true);
          }
          Image::make($file)->save($image_path . '/original/' . $fileName);
          File::delete("images/original/$old_file");

          foreach ($dimensions as $row) {
            $canvas = Image::canvas($row[0], $row[1]);
            $resizeImage = Image::make($file)->resize($row[0], $row[1], function ($constraint) {
              $constraint->aspectRatio();
            });
            if (!File::isDirectory($image_path . '/' . $row[2])) {
              File::makeDirectory($image_path . '/' . $row[2], 0755, true);
            }
            $canvas->insert($resizeImage, 'center');
            $canvas->save($image_path . '/' . $row[2] . '/' . $fileName);
            File::delete("images/$row[2]/$old_file");
          }
        }
        return $fileName;
      }
    }
  }

  public static function uploadFilePublic($file, $location = 'storage', $fileName = NULL)
  {
    if (request()->hasFile($file)) {
      $filePath = 'template';
      $file = request()->file($file);
      $ext = $file->getClientOriginalExtension();
      $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . Carbon::now()->timestamp) . '.' . $ext;
      if (!File::isDirectory("$filePath")) {
        File::makeDirectory("$filePath", 0755, true);
      }
      Storage::disk('public_upload')->putFileAs($filePath, $file, $fileName);
    }
    return $fileName;
  }

  public static function deleteFilePublic($fileName)
  {
    $filePath = 'template';
    Storage::disk('public_upload')->delete($filePath . '/' . $fileName);
  }
}
