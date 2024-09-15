<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait CurrentUserTrait
{
   public function currentUserId()
   {
      return Auth::check() ? Auth::user()->id : null;
   }
}
