<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'errand_id',
        'sender_id',
        'runner_id',
        'gross_amount',
        'platform_fee',
        'net_amount',
        'amount_usdt',
        'fee_amount',
        'tx_hash',
        'direction',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'gross_amount' => 'decimal:2',
            'platform_fee' => 'decimal:2',
            'net_amount' => 'decimal:2',
            'amount_usdt' => 'decimal:2',
            'fee_amount' => 'decimal:2',
        ];
    }

    public function errand(): BelongsTo
    {
        return $this->belongsTo(Errand::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function runner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'runner_id');
    }
}