<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Errand extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'runner_id',
        'title',
        'description',
        'type',
        'status',
        'pickup_address',
        'pickup_lat',
        'pickup_lng',
        'delivery_address',
        'delivery_lat',
        'delivery_lng',
        'budget_usdt',
        'escrow_tx_hash',
        'completion_tx_hash',
        'deadline',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'pickup_lat' => 'decimal:7',
            'pickup_lng' => 'decimal:7',
            'delivery_lat' => 'decimal:7',
            'delivery_lng' => 'decimal:7',
            'budget_usdt' => 'decimal:2',
            'deadline' => 'datetime',
        ];
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function runner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'runner_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ErrandMessage::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment(): HasOne
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    public function proofs(): HasMany
    {
        return $this->hasMany(ErrandProof::class);
    }

    public function milestones(): HasMany
    {
        return $this->hasMany(ErrandMilestone::class)->orderBy('created_at');
    }
}