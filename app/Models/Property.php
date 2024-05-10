<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'surface',
        'rooms',
        'bedrooms',
        'floor',
        'price',
        'city',
        'address',
        'postal_code',
        'sold',
        'image',
     ];

     public function options(): BelongsToMany
     {
        return $this->belongsToMany(Option::class);
     }

     public function getSlug(): string
     {
         return Str::slug($this->title);
     }

     public function scopeAvailable(Builder $builder): Builder
     {
         return $builder->where('sold', 0);
     }

     public function scopeRecent(Builder $builder): Builder
     {
         return $builder->orderBy('created_at', 'desc');
     }

}
