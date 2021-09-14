<?php

namespace App\Models\Store;

use App\Models\Store\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Represents a team for managing store products.
 * @property int $id
 * @property Carbon $created_at Time when the team was created
 * @property Carbon $updated_at Time when the team information was last updated
 * @property int $name Name of the team
 */
class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The users who joined this team
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get all of the products created by the team.
     */
    public function products()
    {
        return $this->morphMany(Product::class, 'creator');
    }
}
