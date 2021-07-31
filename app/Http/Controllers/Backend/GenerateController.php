<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TemplateData;
use App\Models\TemplateForm;
use App\Models\TemplateFormData;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\Element\ListItem;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Element\TextRun;
use ZipArchive;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class GenerateController extends Controller
{
  private $templateProcessor;


  public function generatesingle($id)
  {
    $templateData = TemplateData::with('template')->findOrFail($id);
    $templateForm = TemplateForm::with(['children', 'selectoption', 'valuesingle' => function ($q) use ($id) {
      $q->where('template_data_id', $id);
    }])
      ->whereNull('parent_id')
      ->where('template_id', $templateData->template_id)
      ->orderBy('sort_order', 'asc')
      ->get();
    $filePath = 'template';
    $file = asset($filePath . '/' . $templateData->template->file);
    $this->templateProcessor = new TemplateProcessor($file);

// Add listitem elements
//    $section->addListItem('List Item 1', 0);
//    $section->addListItem('List Item 2', 0);
//    $section->addListItem('List Item 3', 0);
//    $this->templateProcessor->setComplexValue('list', $section);

//    $replacements = array(
//      array('customer_name' => 'Batman', 'customer_address' => 'Gotham City'),
//      array('customer_name' => 'Superman', 'customer_address' => 'Metropolis'),
//    );

//    $this->templateProcessor->cloneBlock('list', 0, true, false, $replacements);

    $text = new TextRun();
    $text->addText('• List item 1');
    $text->addTextBreak(1);
    $text->addText('• List item 2');
    $text->addTextBreak(1);
    $this->templateProcessor->setComplexValue('list', $text);

    foreach ($templateForm as $item):
      $this->single($item);
    endforeach;

//    $title = new TextRun();
//    $title->addText('This title has been set ', array('bold' => true, 'italic' => true, 'color' => 'blue'));
//    $title->addText('dynamically', array('bold' => true, 'italic' => true, 'color' => 'red', 'underline' => 'single'));
//    $templateProcessor->setComplexBlock('title', $title);
//    $templateProcessor->setValue('nama', 'John Doe');
//
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Content-Type: application/octet-stream');
    header("Content-Disposition: attachment; filename=myFile.docx");
    header("Content-Transfer-Encoding: binary");
    header('Expires: 0');
    $this->templateProcessor->saveAs('php://output');
    exit();
  }

  public function generatemulti()
  {
    $filePath = 'template_temp';
    Storage::disk('public_upload')->deleteDirectory($filePath . '/*');
    $zip_file = $filePath . '/invoices.zip';
    $zip = new ZipArchive();
    $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    $path = public_path('template');
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
    foreach ($files as $name => $file) :
      if (!$file->isDir()) {
        $filePath = $file->getRealPath();
//        $relativePath = 'invoices/' . substr($filePath, strlen($path) + 1);
        $relativePath = substr($filePath, strlen($path) + 1);
//        dd(substr($filePath, strlen($path) + 1));
        $zip->addFile($filePath, $relativePath);
      }
    endforeach;
    $zip->close();
    return response()->download($zip_file);
  }

  public function single($data)
  {
    $imgPath = public_path('template_image');
    $templateProcessor = NULL;
    $text = new TextRun();
    if (in_array($data['tag'], ['input', 'select', 'textarea'])) {
      if ($data['type'] == 'image') {
        if ($data['valuesingle']['value']) {
          list($width, $height) = getimagesize($imgPath . '/' . $data['valuesingle']['value']);
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
        if ($data['valuesingle']['value'] == $item['option_value']) {
          $text->addText("🗹 " . $item['option_value']);
        } else {
          $text->addText("☐ " . $item['option_value']);
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
      $id = $data['children'][0]['name'] ?? NULL;
      if ($id && $array) {
        $templateProcessor = $this->templateProcessor->cloneRowAndSetValues($id, $array);
      }
    }
    return $templateProcessor;
  }

  public function table($data)
  {
    $array = array();
    foreach ($data['children'] as $item):
      if (in_array($item['tag'], ['input', 'select', 'textarea'])) {
        foreach ($item['valuemulti'] as $key => $valmulti):
          $array[$key][$item['name']] = $valmulti['value'] ?? NULL;
        endforeach;
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
              $text .= "🗹 " . $itemOption['option_value'];
            } else {
              $text .= "☐ " . $itemOption['option_value'];
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
