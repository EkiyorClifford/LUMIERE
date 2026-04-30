<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //
    protected $fillable = [
        'consultant_id',
        'user_id',
        'type',
        'scheduled_at',
        'status',
    ];

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
