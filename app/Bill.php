<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
   protected $table = 'bills';

   protected $primaryKey = 'bills_id';

   public function orders()
    {
        return $this->hasMany('App\Order','bills_id');
    }
}
