<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConciergeRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'piece',
        'piece_category',
        'measurement',
        'message',
        'source',
        'status',
    ];
}
