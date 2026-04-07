<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_available',
        'current_lat',
        'current_lng',
        'wallet_address',
        'city_in_china',
        'services_offered',
        'availability_hours',
        'languages',
        'notify_email',
        'notify_push',
        'layout_density',
        'language_preference',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_available' => 'boolean',
            'current_lat' => 'float',
            'current_lng' => 'float',
            'services_offered' => 'array',
            'languages' => 'array',
            'notify_email' => 'boolean',
            'notify_push' => 'boolean',
        ];
    }

    public function sentErrands(): HasMany
    {
        return $this->hasMany(Errand::class, 'sender_id');
    }

    public function assignedErrands(): HasMany
    {
        return $this->hasMany(Errand::class, 'runner_id');
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(ErrandMessage::class, 'sender_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(ErrandMessage::class, 'receiver_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(RunnerReview::class, 'runner_id');
    }

    public function notificationLogs(): HasMany
    {
        return $this->hasMany(RunnerNotificationLog::class, 'runner_id');
    }

    public function supportRequests(): HasMany
    {
        return $this->hasMany(SupportRequest::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin' => $this->hasRole('admin'),
            'sender' => $this->hasRole('sender'),
            'runner' => $this->hasAnyRole(['runner', 'receiver']),
            default => false,
        };
    }
}
