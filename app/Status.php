<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Status extends Model
{
	protected $fillable = ['content'];
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
