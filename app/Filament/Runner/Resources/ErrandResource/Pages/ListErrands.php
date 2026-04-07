<?php

namespace App\Filament\Runner\Resources\ErrandResource\Pages;

use App\Filament\Runner\Resources\ErrandResource;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListErrands extends ListRecords
{
    protected static string $resource = ErrandResource::class;

    public function getTabs(): array
    {
        return [
            'active' => Tab::make('Active')
                ->modifyQueryUsing(fn ($query) => $query->whereIn('status', ['accepted', 'in_progress'])),
            'completed' => Tab::make('Completed')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'completed')),
            'rejected' => Tab::make('Rejected')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'cancelled')),
            'disputed' => Tab::make('Disputed')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'disputed')),
        ];
    }
}
