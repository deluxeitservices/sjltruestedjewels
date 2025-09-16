<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MetalQuote extends Model
{
    protected $fillable = ['metal','currency','bid','ask','mid','per_gram','as_of'];
    protected $casts = ['as_of'=>'datetime'];
}
