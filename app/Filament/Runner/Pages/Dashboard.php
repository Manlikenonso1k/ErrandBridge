<?php

namespace App\Filament\Runner\Pages;

use App\Filament\Runner\Widgets\AvailableErrandsMapWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Runner Live Map';

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationGroup = 'ERRANDS';

    protected function getHeaderWidgets(): array
    {
        return [
            AvailableErrandsMapWidget::class,
        ];
    }
}
