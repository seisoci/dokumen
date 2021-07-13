<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class TemplateFormOption extends Model
{
  use HasFactory;

  protected $fillable = [
    'template_form_id',
    'option_text',
    'option_value',
    'option_selected',
  ];

  protected function serializeDate(DateTimeInterface $date)
  {
    return $date->format('Y-m-d H:i');
  }
}
