<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'created_by_id',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id', 'id', self::class);
    }

    public function productVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    }
}
