<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrentOrders extends Model
{
	protected $table = 'current_orders';

	protected $primaryKey = 'orders_id';
}
