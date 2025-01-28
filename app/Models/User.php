<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Model implements Authenticatable
{
    use HasApiTokens;
    use HasUuids;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function product(): HasMany
    {
        return $this->hasMany(Product::class, 'created_by_id', 'id');
    }

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function getAuthIdentifier(): string
    {
        return 'username';
    }

    public function getAuthPasswordName(): string
    {
        return $this->username;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken(): string
    {
        return $this->username;
    }

    public function setRememberToken($value)
    {
        return $this->username = $value;
    }

    public function getRememberTokenName(): string
    {
        return 'username';
    }
}
