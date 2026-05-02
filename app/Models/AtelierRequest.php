<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtelierRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'message',
        'status',
        'invited_at',
    ];

    protected function casts(): array
    {
        return [
            'invited_at' => 'datetime',
        ];
    }
}
