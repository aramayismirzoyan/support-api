<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Request extends Model
{
    use HasFactory;

    public const ACTIVE = 'active';
    public const RESOLVED = 'resolved';

    protected $fillable = [
        'message',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOfStatus(Builder $query, string $status): void
    {
        $query->where('status', $status);
    }

    public function scopeOfData(Builder $query, string $createdAt): void
    {
        $query->where(function ($query) use ($createdAt) {
            $query->whereDate('created_at', '=', $createdAt);
            $query->orWhere('created_at', '=', $createdAt);
        });
    }
}
