<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrentBills extends Model
{
	protected $table = 'current_bills';

	protected $primaryKey = 'bills_id';

	public function orders()
	{
		return $this->hasMany('App\CurrentOrders','bills_id');
	}
}
