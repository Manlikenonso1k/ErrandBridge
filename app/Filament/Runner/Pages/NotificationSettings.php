<?php

namespace App\Filament\Runner\Pages;

use App\Models\RunnerNotificationLog;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class NotificationSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-bell';

    protected static ?string $navigationLabel = 'Notifications';

    protected static ?string $navigationGroup = 'ACCOUNT';

    protected static string $view = 'filament.runner.pages.notification-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $user = Filament::auth()->user();

        $this->form->fill([
            'notify_email' => (bool) $user?->notify_email,
            'notify_push' => (bool) $user?->notify_push,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Toggle::make('notify_email')->label('Email Alerts'),
                Toggle::make('notify_push')->label('Push Alerts'),
            ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();
        $user = Filament::auth()->user();

        if (! $user instanceof User) {
            return;
        }

        $user->notify_email = (bool) ($state['notify_email'] ?? false);
        $user->notify_push = (bool) ($state['notify_push'] ?? false);
        $user->save();

        RunnerNotificationLog::create([
            'runner_id' => $user->id,
            'channel' => 'system',
            'title' => 'Notification settings updated',
            'body' => 'Your notification preferences were updated from the runner panel.',
            'sent_at' => now(),
        ]);

        Notification::make()->title('Notification settings saved')->success()->send();
    }

    public function getLogs()
    {
        return RunnerNotificationLog::query()
            ->where('runner_id', Filament::auth()->id())
            ->latest()
            ->limit(20)
            ->get();
    }
}
