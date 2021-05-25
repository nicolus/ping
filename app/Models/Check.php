<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function url(): BelongsTo
    {
        return $this->belongsTo(Url::class);
    }

    public function wasOnline()
    {
        return $this->online === true;
    }

    public function wasOffline()
    {
        return !$this->wasOnline();
    }
}
