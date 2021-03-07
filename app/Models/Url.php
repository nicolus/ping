<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Http;

class Url extends Model
{
    use HasFactory;

    public $fillable = [
        'url',
        'name'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function checks(): HasMany
    {
        return $this->hasMany(Check::class);
    }

    public function latestCheck(): HasOne
    {
        return $this->hasOne(Check::class)->latest('id');
    }

    /**
     * @return Model|Check
     */
    public function makeCheck(): Check
    {
        try {
            $response = Http::get($this->url);
            return $this->checks()->create(['status' => $response->status()]);
        } catch (HttpResponseException) {
            return $this->checks()->create(['status' => 0]);
        }
    }
}
