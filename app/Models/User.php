<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'membership_tier',
        'consultant_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array// what is this? I dont understand
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function treasure()
    {
        return $this->hasMany(Treasure::class);
    }

    public function getIsGoldCircleAttribute()
    {
        return $this->membership_tier === 'gold_circle';
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function bespokeProjects()
    {
        return $this->hasMany(BespokeProject::class);
    }
}
