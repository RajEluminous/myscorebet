<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WinningUsers extends Model
{
	protected $table = 'winning_users';
    protected $fillable = [
        'uuid', 'points'
    ];
}
