<?php

namespace App\Filament\Runner\Resources\RunnerKycSubmissionResource\Pages;

use App\Filament\Runner\Resources\RunnerKycSubmissionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRunnerKycSubmissions extends ListRecords
{
    protected static string $resource = RunnerKycSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
