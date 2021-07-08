<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MatchOldPassword implements Rule{
  public $id;

  public function __construct($id)
  {
    $this->id = $id;
  }

  public function passes($attribute, $value)
  {
    return Hash::check($value, User::find($this->id)->password);
  }


  public function message()
  {
    return 'The :attribute is no match with old password.';
  }

}
