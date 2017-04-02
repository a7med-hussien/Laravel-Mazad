<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
	use SoftDeletes;

	protected $hidden = ['user_id'];

	public function user()
	{
		return $this->belongsTo("App\User");
	}
}