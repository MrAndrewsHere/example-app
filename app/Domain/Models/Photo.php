<?php

namespace App\Domain\Models;

use Database\Factories\PhotoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'photo';
    protected $fillable = ['url', 'ad_id'];

    /**
     * @return PhotoFactory
     */
    protected static function newFactory(): PhotoFactory
    {
        return PhotoFactory::new();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ad(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Ad::class, 'id', 'ad_id');
    }
}
