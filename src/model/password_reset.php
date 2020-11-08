<?php

namespace Bageur\Auth\Model;

use Illuminate\Database\Eloquent\Model;

class password_reset extends Model
{
    protected $table   = 'bgr_password_resets';
    protected $fillable = [
        'email', 'token'
    ];
    protected $hidden = [
         'id', 'created_at', 'updated_at','email'
    ];
}
