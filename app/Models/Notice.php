<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notices';

    protected $fillable = [
        'author_id',
        'title',
        'subtitle',
        'slug',
        'description',
        'active',
        'published_at',
    ];

    public array $rules = [
        'author_id' => 'required|numeric|exists:authors,id',
        'title' => 'required|min:20|max:100',
        'subtitle' => 'required|min:20|max:155',
        'slug' => 'required',
        'description' => 'required|min:100',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(NoticeImage::class);
    }
}
