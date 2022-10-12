<?php

namespace App\Domain\Models;

use Database\Factories\AdFactory;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Ad extends Model
{
    use HasFactory;

    protected $with = ['preview'];
    protected $fillable = ['name', 'description', 'price','created_at','updated_at'];


    /**
     * @return AdFactory
     */
    protected static function newFactory(): AdFactory
    {
        return AdFactory::new();
    }

    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeCollectible(Builder $query): Builder
    {
        return $query->select('id', 'name', 'price');
    }

    /**
     * @param Builder $query
     * @param string|null $sortBy
     * @param bool $descending
     * @return Builder
     */
    public function scopeSorted(Builder $query, string $sortBy = null, bool $descending = false): Builder
    {
        if (!$sortBy) {
            return $query;
        }
        return $query->orderBy($sortBy, $descending ? 'desc' : 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function preview(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Photo::class, 'ad_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photo(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Photo::class, 'ad_id', 'id');
    }
}
