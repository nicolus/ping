<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Check extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    public $fillable = [
        'status', 'time', 'online'
    ];

    protected $casts = [
        'status' => 'int',
        'online' => 'bool'
    ];

    /**
     * @param Builder<Check> $query
     * @return void
     */
    public function scopeOffline(Builder $query): void
    {
        $query->where('online', false);
    }

    /**
     * @return BelongsTo<Url, Check>
     */
    public function url(): BelongsTo
    {
        return $this->belongsTo(Url::class);
    }

    public function wasOnline(): bool
    {
        return $this->online === true;
    }

    public function wasOffline(): bool
    {
        return !$this->wasOnline();
    }
}
