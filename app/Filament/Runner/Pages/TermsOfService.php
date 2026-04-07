<?php

namespace App\Filament\Runner\Pages;

use Filament\Pages\Page;

class TermsOfService extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Terms of Service';

    protected static ?string $navigationGroup = 'SUPPORT';

    protected static string $view = 'filament.runner.pages.terms-of-service';
}
