<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Point extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class)->withDefault([
            'name' => 'Unassigned',
        ]);
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(User::class, 'business_id');
    }
}
