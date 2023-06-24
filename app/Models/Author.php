<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class Author extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'authors';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'gender',
        'active',
    ];

    protected $hidden = [
        'password',
    ];

    public array $rules = [
        'first_name' => 'required|min2|max:45|alpha',
        'last_name' => 'required|min2|max:60|alpha',
        'email' => 'required|email|max:100|email:rfc,dns',
        'password' => 'required|between:6,12',
        'gender' => 'required|alpha|max:1',
    ];

    public function notices(): HasMany
    {
        return $this->hasMany(Notice::class);
    }

    public function setPasswordAttribute($value)
    {
        if (!empty($value) && !is_null($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }
}
