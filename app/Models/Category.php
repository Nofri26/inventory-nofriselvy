<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasUuids;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'name',
        'description',
    ];

    public function productVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }
}
