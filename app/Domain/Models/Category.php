<?php

namespace App\Domain\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $name
 */
class Category extends Model
{
    use HasFactory;


    protected $fillable = ['name'];

    /**
     * @return BelongsTo
     */
    public function ads(): BelongsTo
    {
        return $this->belongsTo(Ad::class, 'id', 'category_id');
    }

    /**
     * Retrieve category by given name if it exists.
     * @param Builder $query
     * @param string|Category|null $name
     * @return Model|null
     */
    public function scopeName(Builder $query, string|self|null $name): Model|null
    {
        return $query->limit(1)->where('name', '=', is_string($name) ? $name : ($name ? $name->name : $name))?->first() ?? null;
    }

    /**
     * @return CategoryFactory
     */
    protected static function newFactory(): CategoryFactory
    {
        return new CategoryFactory();
    }
}
