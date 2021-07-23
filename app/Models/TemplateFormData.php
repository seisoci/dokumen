<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperTemplateFormData
 */
class TemplateFormData extends Model
{
  use HasFactory;

  protected $fillable = [
    'template_data_id',
    'template_form_id',
    'value'
  ];


}
