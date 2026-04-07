<?php

namespace App\Filament\Runner\Resources\RunnerKycSubmissionResource\Pages;

use App\Filament\Runner\Resources\RunnerKycSubmissionResource;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreateRunnerKycSubmission extends CreateRecord
{
    protected static string $resource = RunnerKycSubmissionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Filament::auth()->id();

        return $data;
    }
}
