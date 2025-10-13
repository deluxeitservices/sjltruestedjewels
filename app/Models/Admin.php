<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin'; // your custom table name

    protected $fillable = [
        'email',
        'password',
        // add other columns as needed
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // If you don't have timestamps columns, disable them:
    public $timestamps = false;
}
