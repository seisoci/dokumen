<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class TemplateForm extends Model
{
    use HasFactory;

  protected $fillable = [
    'template_id',
    'parent_id',
    'tag',
    'type',
    'name',
    'label',
    'multiple',
    'sort_order',
    'is_column_table',
  ];

  protected function serializeDate(DateTimeInterface $date)
  {
    return $date->format('Y-m-d H:i');
  }

  public function children(){
    return $this->hasMany(TemplateForm::class, 'parent_id')->orderBy('sort_order', 'asc');
  }

  public function selectoption(){
    return $this->hasMany(TemplateFormOption::class, 'template_form_id');
  }
}
