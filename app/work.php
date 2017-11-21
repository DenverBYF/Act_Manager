<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class work extends Model
{
    //
	protected $fillable = [
		'name','content', 'user_id', 'ddl', 'status', 'file_url', 'hidden', 'start_time', 'end_time', 'tip'
	];

	public function manager()
	{
		return $this->belongsTo('App\User','user_id');
	}

	public function users()
	{
		return $this->belongsToMany('App\User','work_user');
	}
}
