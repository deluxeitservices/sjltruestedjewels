<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SjlContact extends Model
{
    protected $table = 'sjl_contacts'; // <-- explicit table name
    protected $fillable = ['name','mobile','email','message','ip','user_agent'];
}
