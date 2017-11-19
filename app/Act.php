<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Act extends Model
{
    //
	protected $fillable = ['name','desc','time','bz','address','content'];

	public function users()
	{
		return $this->belongsToMany('App\User','act_user');
	}

	public function joinUser()
	{
		return $this->belongsToMany('App\User','act_user')->wherePivot('join',1);
	}

	public function notJoinUser()
	{
		return $this->belongsToMany('App\User','act_user')->wherePivot('join',0);
	}

	public function manager()
	{
		return $this->belongsTo('App\User');
	}
}
