<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    //
    protected $fillable = [
        'name',
        'title',
        'location',
        'avatar_path',
        'bio',
        'is_active',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function bespoke()
    {
        return $this->hasMany(BespokeProject::class);
    }

    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function getTitleAttribute()
    {
        return $this->title;
    }

    public function getLocationAttribute()
    {
        return $this->location;
    }

    public function getAvatarPathAttribute()
    {
        return $this->avatar_path;
    }

    public function getBioAttribute()
    {
        return $this->bio;
    }

    public function getIsActiveAttribute()
    {
        return $this->is_active;
    }

    public function getCreatedAtAttribute()
    {
        return $this->created_at;
    }

    public function getUpdatedAtAttribute()
    {
        return $this->updated_at;
    }
}
