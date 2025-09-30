<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'house_no',
        'street_name',
        'city',
        'postal_code',
        'country',
        'default_address',
    ];

    protected $casts = [
        'default_address' => 'boolean',
    ];

    // Convenience: set this address as default and unset others
    public function setAsDefault(): void
    {
        static::where('user_id', $this->user_id)->update(['default_address' => false]);
        $this->forceFill(['default_address' => true])->save();
    }
}
