<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TemplateData;
use App\Models\TemplateForm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\TemplateProcessor;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class GenerateController extends Controller
{
  private $templateProcessor;

  public function generatesingle($id)
  {
    $templateData = TemplateData::with('template')->findOrFail($id);
    $templateForm = TemplateForm::with(['children', 'selectoption', 'valuesingle' => function ($q) use ($id) {
      $q->where('template_data_id', $id);
    }, 'children.valuemulti' => function ($q) use ($id) {
      $q->where('template_data_id', $id);
    }])
      ->whereNull('parent_id')
      ->where('template_id', $templateData->template_id)
      ->orderBy('sort_order', 'asc')
      ->get();
    $filePath = 'template';
    $file = asset($filePath . '/' . $templateData->template->file);
    $this->templateProcessor = new TemplateProcessor($file);

    foreach ($templateForm as $item):
      $this->single($item);
    endforeach;

    $fileName = Carbon::today()->toDateString() . '_' . $templateData->template->file;
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Content-Type: application/octet-stream');
    header("Content-Disposition: attachment; filename=$fileName");
    header("Content-Transfer-Encoding: binary");
    header('Expires: 0');
    $this->templateProcessor->saveAs('php://output');
    exit();
  }

  public function generatemulti(Request $request)
  {
    $filePath = 'template_temp';
    Storage::disk('public_upload')->deleteDirectory($filePath);
    $saveto = public_path('template_temp');
    if (!File::isDirectory("$saveto")) {
      File::makeDirectory("$saveto", 0755, true);
    }
    $zip_file = $filePath . '/invoices.zip';
    $zip = new ZipArchive();
    $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);
    $data = json_decode($request->data) ?? array();
    foreach ($data as $item) {
      $random = rand();
      $templateData = TemplateData::with('template')->findOrFail($item);
      $templateForm = TemplateForm::with(['children', 'selectoption', 'valuesingle' => function ($q) use ($item) {
        $q->where('template_data_id', $item);
      }, 'children.valuemulti' => function ($q) use ($item) {
        $q->where('template_data_id', $item);
      }])
        ->whereNull('parent_id')
        ->where('template_id', $templateData->template_id)
        ->orderBy('sort_order', 'asc')
        ->get();
      $filePathSingle = 'template';
      $file = asset($filePathSingle . '/' . $templateData->template->file);
      $this->templateProcessor = new TemplateProcessor($file);

      foreach ($templateForm as $itemForm):
        $this->single($itemForm);
      endforeach;

      $fileName = $random . '_' . $templateData->template->file;
      $this->templateProcessor->saveAs($saveto . '\\' . $fileName);
    }
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($saveto));
    foreach ($files as $file) :
      if (!$file->isDir()) {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($saveto) + 1);
        $zip->addFile($filePath, $relativePath);
      }
    endforeach;
    $zip->close();
    $response = response()->json([
      'status' => 'success',
      'message' => 'Data has been saved',
      'redirect' => '/template_temp/invoices.zip'
    ]);
    return $response;
  }

  public function single($data)
  {
    $imgPath = public_path('template_image');
    $templateProcessor = NULL;
    $text = new TextRun();
    if (in_array($data['tag'], ['input', 'select', 'textarea'])) {
      if ($data['type'] == 'image') {
        if (($data['valuesingle']['value'] ?? NULL)) {
          list($width, $height) = getimagesize($imgPath . '\\' . $data['valuesingle']['value']);
          $templateProcessor = $this->templateProcessor->setImageValue($data['name'], array('path' => $imgPath . '/' . $data['valuesingle']['value'], 'width' => $width, 'height' => $height));
        }
      } else {
        $templateProcessor = $this->templateProcessor->setValue($data['name'], $data['valuesingle']['value'] ?? NULL);
      }
    } elseif ($data['tag'] == 'checkbox') {
      $checkbox = (!empty($data['valuesingle']['value']) || isset($data['valuesingle']['value']) ? explode(", ", $data['valuesingle']['value']) : array());
      foreach ($data['selectoption'] as $item):
        $checkboxStatus = FALSE;
        foreach ($checkbox as $checked) {
          if ($checked == $item['option_value']) {
            $checkboxStatus = TRUE;
            break;
          } else {
            $checkboxStatus = FALSE;
          }
        }
        $checkboxStatus ? $text->addText("🗹 " . $item['option_value']) : $text->addText("☐ " . $item['option_value']);
        $text->addText("   ");
      endforeach;
      $templateProcessor = $this->templateProcessor->setComplexValue($data['name'], $text);
    } elseif ($data['tag'] == 'radio') {
      foreach ($data['selectoption'] as $item):
        if (($data['valuesingle']['value'] ?? NULL) == $item['option_value']) {
          $text->addText("⦿ " . $item['option_value']);
        } else {
          $text->addText("○ " . $item['option_value']);
        }
        $text->addText("   ");
      endforeach;
      $templateProcessor = $this->templateProcessor->setComplexValue($data['name'], $text);
    } elseif ($data['tag'] == 'ol') {
      $ol = (!empty($data['valuesingle']['value']) || isset($data['valuesingle']['value']) ? explode(", ", $data['valuesingle']['value']) : array());
      foreach ($ol as $key => $item):
        $text->addText('• ' . $item);
        (count($ol) - 1) == $key ? NULL : $text->addTextBreak(1);
      endforeach;
      $templateProcessor = $this->templateProcessor->setComplexValue($data['name'], $text);
    } elseif ($data['tag'] == 'ul') {
      $ul = (!empty($data['valuesingle']['value']) || isset($data['valuesingle']['value']) ? explode(", ", $data['valuesingle']['value']) : array());
      $no = 1;
      foreach ($ul as $key => $item):
        $text->addText(str_pad($no++ . '.', 3, " ") . ' ' . $item);
        (count($ul) - 1) == $key ? NULL : $text->addTextBreak(1);
      endforeach;
      $templateProcessor = $this->templateProcessor->setComplexValue($data['name'], $text);
    } elseif (in_array($data['tag'], ['table', 'block'])) {
      $array = $this->table($data);
//      dd($array);
//      foreach ($data['children'] as $key => $item){
//        if($item['type'] == 'image'){
//          foreach ($array as $i => $itemImage) {
//            $name = $item['name'];
//            list($width, $height) = getimagesize($imgPath . '/' . $itemImage["je_photo"]);
//            dd($imgPath . '\\' . $itemImage["je_photo"]);
//            $templateProcessor = $this->templateProcessor->setImageValue(sprintf($item['name'].'#%d', $i + 1), $imgPath . '\\1628063790302726375.png');
//          }
//        }
//      }
      $id = $data['children'][0]['name'] ?? NULL;
      if ($id && $array) {
        try {
          $templateProcessor = $this->templateProcessor->cloneRowAndSetValues($id, $array);
        } catch (\Exception $e) {
          error_log(0);
        }
      }
    }
    return $templateProcessor;
  }

  public function table($dataChildren)
  {
    $array = array();
    $data = $dataChildren['children'];
    foreach ($data as $item):
      if (in_array($item['tag'], ['input', 'select', 'textarea'])) {
        if ($item['type'] == 'image') {
          foreach ($item['valuemulti'] as $key => $valmulti):
//            $array[$key][$item['name']] = $valmulti['value'] ?? NULL;
          endforeach;
        } else {
          foreach ($item['valuemulti'] as $key => $valmulti):
            $array[$key][$item['name']] = $valmulti['value'] ?? NULL;
          endforeach;
        }
      } elseif ($item['tag'] == 'checkbox') {
        foreach ($item['valuemulti'] as $key => $valmulti):
          $text = NULL;
          $checkbox = (!empty($valmulti['value']) || isset($valmulti['value']) ? explode(", ", $valmulti['value']) : array());
          foreach ($item['selectoption'] as $keyOption => $itemOption):
            $checkboxStatus = FALSE;
            foreach ($checkbox as $checked) {
              if ($checked == $itemOption['option_value']) {
                $checkboxStatus = TRUE;
                break;
              } else {
                $checkboxStatus = FALSE;
              }
            }
            $text .= ($checkboxStatus ? "🗹 " . $itemOption['option_value'] : "☐ " . $itemOption['option_value']);
            if ((count($item['selectoption']) - 1) != $keyOption) {
              $text .= '   ';
            }
          endforeach;
          $array[$key][$item['name']] = $text;
        endforeach;
      } elseif ($item['tag'] == 'radio') {
        foreach ($item['valuemulti'] as $key => $valmulti):
          $text = NULL;
          foreach ($item['selectoption'] as $keyOption => $itemOption):
            if ($valmulti['value'] == $itemOption['option_value']) {
              $text .= "⦿ " . $itemOption['option_value'];
            } else {
              $text .= "○ " . $itemOption['option_value'];
            }
            if ((count($item['selectoption']) - 1) != $keyOption) {
              $text .= '   ';
            }
          endforeach;
          $array[$key][$item['name']] = $text;
        endforeach;
      }
    endforeach;
    return $array;
  }

}
