<?php

namespace App\Models;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory, InteractsWithSockets;

    protected $fillable = [
        'name', 'owner_id',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(RoomMessage::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'room_user');
    }

    public function canAccess(int $userId): bool
    {
        return $this->members->contains($userId);
    }
}
