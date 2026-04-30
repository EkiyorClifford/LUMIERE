<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BespokeProject extends Model
{
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }
}
