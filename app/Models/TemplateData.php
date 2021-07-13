<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class TemplateData extends Model
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
}
