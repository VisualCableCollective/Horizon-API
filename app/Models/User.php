<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

use App\Models\Store\Product;
use App\Models\Store\Team;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all of the products owned and created by the user.
     */
    public function createdProducts()
    {
        return $this->morphMany(Product::class, 'creator');
    }

    /**
     * The teams that the user is a member of.
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    /**
     * The products that are owned by the user.
     */
    public function ownedProducts()
    {
        return $this->belongsToMany(Product::class);
    }

}
