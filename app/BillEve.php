<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillEve extends Model
{
   protected $table = 'bills_eve';

   protected $primaryKey = 'bills_id';

   public function orders()
    {
        return $this->hasMany('App\OrderEve','bills_id');
    }

}
