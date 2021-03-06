<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductGroup
 *
 * @property int $id
 * @property string $name
 * @property int $order
 * @property int $hide
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductGroup whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductGroup whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductGroup show()
 */
class ProductGroup extends Model
{
    public function products()
    {
        return $this->hasMany(Product::class, 'group_id');
    }

    public function scopeShow($query)
    {
        $query->where('hide', 0);
    }
}
