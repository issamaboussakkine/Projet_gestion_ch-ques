<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
    protected $fillable = [
        'client_name',
        'amount',
        'bank',
        'cheque_number',
        'date',
        'status',
        'image',
        'user_id'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}