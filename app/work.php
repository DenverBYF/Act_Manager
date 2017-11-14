<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class work extends Model
{
    //
	protected $fillable = ['content', 'user_id', 'ddl', 'status', 'file_url'];
}
