<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ErrandMilestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'errand_id',
        'title',
        'description',
        'status',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime',
        ];
    }

    public function errand(): BelongsTo
    {
        return $this->belongsTo(Errand::class);
    }
}
