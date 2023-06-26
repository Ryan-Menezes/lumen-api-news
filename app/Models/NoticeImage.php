<?php

namespace App\Models;

use App\Helpers\ImageBase64Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class NoticeImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notice_images';

    protected $fillable = [
        'notice_id',
        'source',
        'description',
        'active',
    ];

    public array $rules = [
        'notice_id' => 'required|numeric|exists:notices,id',
        'source' => 'required',
        'description' => 'required|min:10|max:191',
    ];

    public function notice(): BelongsTo
    {
        return $this->belongsTo(Notice::class);
    }

    /*
    public function setSourceAttribute($value)
    {
        if (!empty($value) && !is_null($value)) {
            $this->attributes['source'] = ImageBase64Helper::generate($value);
        }
    }
    */
}
