<?php

namespace App\Services;

use App\Events\PlatformFeeUpdated;
use App\Mail\PlatformFeeUpdatedMail;
use App\Models\PlatformSetting;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class PlatformFeeService
{
    public function isEnabled(): bool
    {
        return filter_var($this->getSetting('platform_fee_enabled', 'false'), FILTER_VALIDATE_BOOLEAN);
    }

    public function getPercentage(): float
    {
        return (float) $this->getSetting('platform_fee_percentage', '5');
    }

    public function calculate(float $amountUsdt): array
    {
        $feeEnabled = $this->isEnabled();
        $feeRate = $this->getPercentage();
        $feeAmount = $feeEnabled ? round($amountUsdt * ($feeRate / 100), 2) : 0.0;

        return [
            'gross' => $amountUsdt,
            'fee_rate' => $feeRate,
            'fee_amount' => $feeAmount,
            'net_to_runner' => round($amountUsdt - $feeAmount, 2),
            'fee_enabled' => $feeEnabled,
        ];
    }

    public function updateSettings(bool $enabled, float $percentage, User $updatedBy): void
    {
        PlatformSetting::updateOrCreate(
            ['key' => 'platform_fee_enabled'],
            ['value' => $enabled ? 'true' : 'false', 'updated_by' => $updatedBy->id]
        );

        PlatformSetting::updateOrCreate(
            ['key' => 'platform_fee_percentage'],
            ['value' => (string) $percentage, 'updated_by' => $updatedBy->id]
        );

        logger()->info('Platform fee settings updated', [
            'enabled' => $enabled,
            'percentage' => $percentage,
            'updated_by' => $updatedBy->id,
        ]);

        event(new PlatformFeeUpdated($enabled, $percentage, $updatedBy));

        User::all()->chunk(100)->each(function ($users) use ($enabled, $percentage) {
            foreach ($users as $user) {
                Mail::to($user->email)->queue(new PlatformFeeUpdatedMail($user, $enabled, $percentage));
            }
        });
    }

    private function getSetting(string $key, string $default = ''): string
    {
        return PlatformSetting::query()->where('key', $key)->value('value') ?? $default;
    }
}