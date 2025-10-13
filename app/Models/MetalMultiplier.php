<?php 
// app/Models/MetalMultiplier.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetalMultiplier extends Model
{
    protected $fillable = ['key','multiplier'];
    public $timestamps = true;
}
