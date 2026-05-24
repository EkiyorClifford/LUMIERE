<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SizerKitRequest extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'shipping_address_line_1',
        'shipping_address_line_2',
        'shipping_address_line_3',
        'ring_size_guess',
        'notes',
        'status',
    ];
}
