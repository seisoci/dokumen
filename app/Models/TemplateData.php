<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

/**
 * @mixin IdeHelperTemplateData
 */
class TemplateData extends Model
{
  use HasFactory;

  protected $fillable = [
    'template_id'
  ];

  protected function serializeDate(DateTimeInterface $date)
  {
    return $date->format('Y-m-d H:i');
  }

  public function templateform(){
    return $this->belongsTo(TemplateForm::class, 'template_form_id');
  }
}
