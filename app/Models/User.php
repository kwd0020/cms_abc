<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Role;
use App\Models\Tenant;
use App\Models\Scopes\TenantScope;

class User extends Authenticatable
{

    public function bypassTenantScopeForAdmin(): bool{
        return true;
    }

       /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    public function hasRole(string $roleSlug): bool{
        if(! $this->relationLoaded('role')){
            $this->load('role');
        }

        return $this->role && $this->role->role_slug === $roleSlug;
    } 

    protected $primaryKey = 'user_id';    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $fillable = [
        'tenant_id',
        'role_id',
        'user_name',
        'user_email',
        'phone_number',
        'password',
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
    protected function casts(): array{
        return [
            'password' => 'hashed',
        ];
    }

    public function role() {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }
    
    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'tenant_id');
    }
}
