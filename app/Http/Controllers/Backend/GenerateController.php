<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TemplateData;
use App\Models\TemplateForm;
use App\Models\TemplateFormData;
use PhpOffice\PhpWord\Element\ListItem;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Element\TextRun;

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
      ->get();
//    dd($templateForm->toArray());
    $filePath = 'template';
    $file = asset($filePath . '/' . $templateData->template->file);
    $this->templateProcessor = new TemplateProcessor($file);
//    dd($templateForm->toArray());

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
//    $templateProcessor = new TemplateProcessor('template/Sample_40_TemplateSetComplexValue.docx');
//
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
//    $templateProcessor->save('php://output');
//    die();
//    $templateProcessor->saveAs('Sample_40_TemplateSetComplexValue.docx');
//    $pathToSave = 'public/kurnia.docx';
  }

  public function single($data)
  {
    $templateProcessor = NULL;
    $text = new TextRun();
    if ($data['tag'] == 'input') {
      $templateProcessor = $this->templateProcessor->setValue($data['name'], $data['valuesingle']['value']);
    } elseif ($data['tag'] == 'checkbox') {
//      foreach ($data['selectoption'] as $item):
//        if($data['valuesingle']['value'] == $item['option_value']){
//          $text->addText("🗹 ".$item['option_value']);
//        }else{
//          $text->addText("☐ ".$item['option_value']);
//        }
//        $text->addText("   ");
//      endforeach;
//      $templateProcessor = $this->templateProcessor->setComplexValue($data['name'], $text);
    } elseif ($data['tag'] == 'radio') {
      foreach ($data['selectoption'] as $item):
        if($data['valuesingle']['value'] == $item['option_value']){
          $text->addText("🗹 ".$item['option_value']);
        }else{
          $text->addText("☐ ".$item['option_value']);
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
    }
    return $templateProcessor;
  }
}
