<?php

// C:\Users\HP\Desktop\Lumiere\app\Models\Admin.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * @var array<string, list<string>>
     */
    private const ROLE_PERMISSIONS = [
        'superadmin' => ['*'],
        'manager' => [
            'view-dashboard',
            'manage-catalog',
            'manage-content',
            'manage-orders',
            'manage-customers',
            'manage-bespoke',
        ],
        'editor' => [
            'view-dashboard',
            'manage-content',
        ],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'last_login_at',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'email_verified_at' => 'datetime',
    ];

    public function hasPermission(string $permission): bool
    {
        $permissions = self::ROLE_PERMISSIONS[$this->role] ?? [];

        return in_array('*', $permissions, true) || in_array($permission, $permissions, true);
    }
}
