<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
/**
 * @method bool hasRole(string $role)
 * @method bool hasAnyRole(...$roles)
 * @method bool hasPermissionTo(string $permission)
 */
class Admin extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;
    protected $guard_name = 'admin'; 
    protected $fillable = [
        'name', 
        'email', 'password', 'phone','address', 'avatar', 'gender', 'role_id'
    ];
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
