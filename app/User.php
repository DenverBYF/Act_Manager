<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','tel','stuId','sex'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	public function acts()
	{
		return $this->belongsToMany('App\Act','act_user');
	}

	public function works()
	{
		return $this->belongsToMany('App\work','work_user');
	}

	public function workManager()
	{
		return $this->hasMany('App\work','user_id');
	}

	public function worksNotFinish()
	{
		return $this->belongsToMany('App\work','work_user')->wherePivot('status',0);
	}

	public function worksFinish()
	{
		return $this->belongsToMany('App\work','work_user')->wherePivot('status',1);
	}
}
