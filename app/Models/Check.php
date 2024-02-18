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

    public $guarded = ['id'];

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
     * @param Builder<Check> $query
     * @return void
     */
    public function scopeOnline(Builder $query): void
    {
        $query->where('online', true);
    }

    /**
     * @return BelongsTo<Probe, Check>
     */
    public function probe(): BelongsTo
    {
        return $this->belongsTo(Probe::class);
    }

    /**
     * @return ?self The latest check before this one for the same URL. null if it's the first check
     */
    public function previousCheck(): ?self
    {
        return self::latest('id')
            ->where('id', '<', $this->id)
            ->where('probe_id', '=', $this->probe_id)
            ->first();
    }

    /**
     * @return ?self The latest check for the same URL that was "online" before this one. null if it was never online
     */
    public function previousOnlineCheck(): ?self
    {
        return self::latest('id')
            ->online()
            ->where('id', '<', $this->id)
            ->where('probe_id', '=', $this->probe_id)
            ->first();
    }

    /**
     * @return ?self The latest check for the same URL that was "offline" before this one. null if it was never offline
     **/
    public function previousOfflineCheck(): ?self
    {
        return self::latest('id')
            ->offline()
            ->where('id', '<', $this->id)
            ->where('probe_id', '=', $this->probe_id)
            ->first();
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
