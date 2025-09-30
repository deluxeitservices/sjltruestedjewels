<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JewelleryTabMaster extends Model
{
    /** The underlying table name (non-standard). */
    protected $table = 'jewellery_tab_master';

    /** Primary key column (from your screenshot it’s `id`). */
    protected $primaryKey = 'id';

    /** Table does not have Laravel’s created_at/updated_at columns. */
    public $timestamps = false;

    /**
     * Mass-assignment: since this table has many columns and they can change,
     * keep it open. If you prefer to whitelist, replace with an explicit
     * $fillable array instead.
     */
    protected $guarded = [];

    /**
     * Optional: basic casts for a few commonly numeric fields shown in your schema.
     * Add/remove to taste.
     */
    protected $casts = [
        // weights / numeric-like columns
        'weightJew'                 => 'decimal:3',
        'expectedPriceJew'          => 'decimal:2',
        'estimate_value_of_item'    => 'decimal:2',
        'final_valuation_content'   => 'decimal:2',
        'sales_status'              => 'integer',

        // dates you may want as Carbon instances if they exist/used
        'update_date'               => 'datetime',
        'sent_date'                 => 'datetime',
    ];

    /* =========================
       Example convenience scopes
       ========================= */
    public function scopeOpen($q)
    {
        return $q->where(function ($qq) {
            $qq->whereNull('status')->orWhere('status', '!=', 'closed');
        });
    }

    public function scopeByEmail($q, string $email)
    {
        return $q->where('emailJew', $email);
    }

    /* =========================
       Accessors (optional)
       ========================= */
    public function getFullNameAttribute(): string
    {
        $first = trim((string)($this->attributes['fnameJew'] ?? ''));
        $last  = trim((string)($this->attributes['lnameJew'] ?? ''));
        return trim($first.' '.$last);
    }

    public function items(): HasMany {
        return $this->hasMany(SellItem::class);
    }
}
