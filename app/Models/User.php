<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Store\Product;
use App\Models\Store\Team;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'latest_vcc_api_token',
    ];

    protected $attributes = [
        'latest_vcc_api_token' => ""
    ];

    /**
     * Get all of the products owned and created by the user.
     */
    public function products()
    {
        return $this->morphMany(Product::class, 'ownable');
    }

    /**
     * The teams that the user is a member of.
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }
}
