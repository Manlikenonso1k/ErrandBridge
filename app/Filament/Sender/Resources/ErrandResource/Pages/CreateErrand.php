<?php

namespace App\Filament\Sender\Resources\ErrandResource\Pages;

use App\Filament\Sender\Resources\ErrandResource;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreateErrand extends CreateRecord
{
    protected static string $resource = ErrandResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['sender_id'] = Filament::auth()->id();
        $data['status'] = $data['status'] ?? 'pending';

        return $data;
    }
}
