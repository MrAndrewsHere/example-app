<?php

namespace App\Domain\Models;


use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function ads(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Ad::class, 'id', 'category_id');
    }

    protected static function newFactory(): CategoryFactory
    {
        return new CategoryFactory();
    }

    public function scopeName(Builder $query, string|self|null $name)
    {
        return $query->limit(1)->where('name', '=', is_string($name) ? $name : ($name ? $name->name : $name));
    }
}
