<?php

namespace App\Filament\Runner\Pages;

use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class AppearanceSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $navigationLabel = 'Appearance';

    protected static ?string $navigationGroup = 'ACCOUNT';

    protected static string $view = 'filament.runner.pages.appearance-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $user = Filament::auth()->user();

        $this->form->fill([
            'layout_density' => $user?->layout_density ?? 'comfortable',
            'language_preference' => $user?->language_preference ?? 'en',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Select::make('layout_density')
                    ->label('Layout Density')
                    ->options([
                        'compact' => 'Compact',
                        'comfortable' => 'Comfortable',
                    ])
                    ->required(),
                Select::make('language_preference')
                    ->label('Language Preference')
                    ->options([
                        'en' => 'English',
                        'zh' => 'Mandarin Chinese',
                        'pcm' => 'Pidgin',
                    ])
                    ->required(),
            ]);
    }

    public function save(): void
    {
        $user = Filament::auth()->user();

        if (! $user instanceof User) {
            return;
        }

        $state = $this->form->getState();

        $user->layout_density = $state['layout_density'] ?? 'comfortable';
        $user->language_preference = $state['language_preference'] ?? 'en';
        $user->save();

        Notification::make()->title('Appearance settings saved')->success()->send();
    }
}
