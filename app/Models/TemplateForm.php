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

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  protected function serializeDate(DateTimeInterface $date)
  {
    return $date->format('Y-m-d H:i');
  }

  public function parent(){
    return $this->belongsTo(TemplateForm::class, 'parent_id')->with('selectoption')->orderBy('sort_order', 'asc');
  }

  public function children(){
    return $this->hasMany(TemplateForm::class, 'parent_id')->with('selectoption')->orderBy('sort_order', 'asc');
  }

  public function selectoption(){
    return $this->hasMany(TemplateFormOption::class, 'template_form_id')->orderBy('id', 'asc');
  }

  public function formdata(){
    return $this->hasMany(TemplateFormData::class, 'template_form_id');
  }
}
