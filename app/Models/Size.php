<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Size extends Model
{
    use HasUuids;

    protected $table = 'sizes';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'age_from',
        'age_to',
        'description',
    ];

    public function productVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }
}
