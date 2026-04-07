<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RunnerReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'errand_id',
        'runner_id',
        'sender_id',
        'stars',
        'feedback',
    ];

    public function errand(): BelongsTo
    {
        return $this->belongsTo(Errand::class);
    }

    public function runner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'runner_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
