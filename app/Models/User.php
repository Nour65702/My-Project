<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Product;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = ['created_from'];

    public function getCreatedFromAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function imageable()
    {
        return $this->morphOne(Images::class, 'imageable');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function hasRole($role)
    {
        return $this->roles->contains('name', $role);
    }
    // public function assignRole($role)
    // {
    //     $role = Role::where('name', $role)->first();

    //     if ($role) {
    //         $this->roles()->attach($role);
    //     }
    // }
    public function isAdmin()
    {
        return $this->roles()->where('name', 'admin')->exists();
    }
}
