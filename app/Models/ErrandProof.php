<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ErrandProof extends Model
{
    use HasFactory;

    protected $fillable = [
        'errand_id',
        'runner_id',
        'file_path',
        'mime_type',
        'notes',
    ];

    public function errand(): BelongsTo
    {
        return $this->belongsTo(Errand::class);
    }

    public function runner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'runner_id');
    }
}
