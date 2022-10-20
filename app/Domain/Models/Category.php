<?php

namespace App\Domain\Models;


use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function ads(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Ad::class, 'category_id', 'id');
    }

    protected static function newFactory(): CategoryFactory
    {
        return new CategoryFactory();
    }

    public function scopeName($query, ?string $name)
    {
        if (!$name) {
            return $query;
        }
        return $query->where('name', '=', $name);
    }
}
