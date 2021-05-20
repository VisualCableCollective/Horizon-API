<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Represents a product in the store.
 * @property int $id
 * @property Carbon $created_at Time when the product was created
 * @property Carbon $updated_at Time when the product information was last updated
 * @property int $ownable_id ID of the user / team that the product belongs to
 * @property string $ownable_type Type (user or team) to which the product belongs
 */
class Product extends Model
{
    use HasFactory;

    /**
     * Get the parent model, which owns and created the product (user or team).
     */
    public function ownable()
    {
        return $this->morphTo();
    }
}
