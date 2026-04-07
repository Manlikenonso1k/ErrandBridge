<?php

namespace App\Filament\Runner\Pages;

use App\Events\SupportRequestSubmitted;
use App\Models\SupportRequest;
use Filament\Facades\Filament;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SupportCenter extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-lifebuoy';

    protected static ?string $navigationLabel = 'Support Center';

    protected static ?string $navigationGroup = 'SUPPORT';

    protected static string $view = 'filament.runner.pages.support-center';

    public ?array $data = [];

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                TextInput::make('subject')->required()->maxLength(255),
                Textarea::make('message')->required()->maxLength(2000)->rows(5),
            ]);
    }

    public function submit(): void
    {
        $state = $this->form->getState();

        $supportRequest = SupportRequest::create([
            'user_id' => Filament::auth()->id(),
            'subject' => trim(strip_tags((string) ($state['subject'] ?? ''))),
            'message' => trim(strip_tags((string) ($state['message'] ?? ''))),
            'status' => 'open',
        ]);

        event(new SupportRequestSubmitted($supportRequest));

        $this->form->fill();

        Notification::make()->title('Support request submitted')->success()->send();
    }
}
