<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    protected $table = 'menus';

    protected $fillable = [
      'menu_type',
      'parent_id',
      'menu_type',
      'sort',
      'icon',
      'title',
      'url',
      'target'
    ];
}
