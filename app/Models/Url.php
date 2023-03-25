<?php

namespace App\Models;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        return $this->checks()->one()->latestOfMany();
    }

    public function latestGoodCheck(): HasOne
    {
        return $this->checks()->one()->ofMany([
            'id' => 'max',
        ], function ($query) {
            $query->where('online', '=', 1);
        });
    }

    public function isOnline(): bool
    {
        if ($this->latestCheck === null) {
            return false;
        }

        return $this->latestCheck->wasOnline();
    }

    public function isOffline(): bool
    {
        return !$this->isOnline();
    }

    /**
     * @return Check
     */
    public function makeCheck(): Check
    {
        try {
            $response = Http::timeout(config('app.check_timeout'))->get($this->url);

            if (!empty($response->transferStats) && $response->transferStats->hasResponse()){
                $time = round($response->transferStats->getTransferTime() * 1000);
            }

            return $this->checks()->create([
                'online' => $response->status() < 300,
                'status' => $response->status(),
                'time' => $time ?? null
            ]);
        } catch (HttpResponseException|RequestException) {
            return $this->checks()->create([
                'online' => false,
                'status' => null,
            ]);
        }
    }
}
