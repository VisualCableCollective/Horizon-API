<?php

namespace App\Models\Store;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Represents a product in the store.
 * @property int $id
 * @property Carbon $created_at Time when the product was created
 * @property Carbon $updated_at Time when the product information was last updated
 * @property int $creator_id ID of the user / team that the product belongs to
 * @property string $creator_type Type (user or team) to which the product belongs
 * @property string $store_banner_url Url to the store banner of the product.
 */
class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'store_banner_url'];

    /**
     * Get the parent model, which created the product (user or team).
     */
    public function creator()
    {
        return $this->morphTo();
    }

    /**
     * The users that own this product.
     */
    public function owners()
    {
        return $this->belongsToMany(User::class);
    }
}
