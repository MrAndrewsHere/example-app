<?php

namespace App\Domain\Models;

use Database\Factories\AdFactory;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class Ad extends Model
{
    use HasFactory;
    use Notifiable;

    protected $with = ['preview'];

    protected $fillable = ['name', 'description', 'price', 'category_id'];

    /**
     * Normalize price value from db
     *
     * @return float|int
     */
    public function getPriceAttribute(): float|int
    {
        return round($this->attributes['price'] / 1000);
    }

    /**
     * Cast price value to integer to store in db instead float type
     *
     * @param $value
     * @return void
     */
    public function setPriceAttribute($value): void
    {
        $this->attributes['price'] = $value * 1000;
    }

    /**
     * @return AdFactory
     */
    protected static function newFactory(): AdFactory
    {
        return AdFactory::new();
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }


    /**?
     * @param DateTimeInterface $date
     * @return string
     */

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * @param Builder $query
     * @param string|null $sortBy
     * @param bool $descending
     * @return Builder
     */
    public function scopeSorted(Builder $query, string $sortBy = null, bool $descending = true): Builder
    {
        if (!$sortBy) {
            return $query;
        }

        return $query->orderBy($sortBy, $descending ? 'desc' : 'asc');
    }

    public function scopeCategory(Builder $query, Category|string|null $category): Builder
    {
        if (is_null($category)) {
            return $query;
        }
        $category = is_string($category) ? $category : $category->name;

        return $query->whereHas('category', function (Builder $query) use ($category) {
            return $query->where('name', $category);
        });
    }

    /**
     * @return HasOne
     */
    public function preview(): HasOne
    {
        return $this->hasOne(Photo::class, 'ad_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function photo(): HasMany
    {
        return $this->hasMany(Photo::class, 'ad_id', 'id');
    }
}
