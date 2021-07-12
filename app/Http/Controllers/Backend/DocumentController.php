<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Element\TextRun;

class DocumentController extends Controller
{
  public function index()
  {
    $file = asset('template/test.docx');
    $templateProcessor = new TemplateProcessor($file);
//    $templateProcessor = new TemplateProcessor('template/Sample_40_TemplateSetComplexValue.docx');
//
//    $title = new TextRun();
//    $title->addText('This title has been set ', array('bold' => true, 'italic' => true, 'color' => 'blue'));
//    $title->addText('dynamically', array('bold' => true, 'italic' => true, 'color' => 'red', 'underline' => 'single'));
//    $templateProcessor->setComplexBlock('title', $title);
    $templateProcessor->setValue('Name', 'John Doe');

    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Content-Type: application/octet-stream');
    header("Content-Disposition: attachment; filename=myFile.docx");
    header("Content-Transfer-Encoding: binary");
    header('Expires: 0');
    $templateProcessor->saveAs('php://output');
    exit();
//    $templateProcessor->save('php://output');
//    die();
//    $templateProcessor->saveAs('Sample_40_TemplateSetComplexValue.docx');
//    $pathToSave = 'public/kurnia.docx';
  }
}
