<?php

namespace App\Filament\Sender\Pages;

use Filament\Pages\Page;

class PostErrand extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';

    protected static ?string $navigationLabel = 'Post New Errand';

    protected static ?string $title = 'Post New Errand';

    protected static string $view = 'filament.sender.pages.post-errand';
}
