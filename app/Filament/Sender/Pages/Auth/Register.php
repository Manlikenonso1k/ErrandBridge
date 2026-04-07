<?php

namespace App\Filament\Sender\Pages\Auth;

use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Database\Eloquent\Model;

class Register extends BaseRegister
{
    public function form(Form $form): Form
    {
        return $form->schema([
            Wizard::make([
                Step::make('Account Details')
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                    ]),
                Step::make('Security')
                    ->schema([
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ]),
            ]),
        ]);
    }

    protected function handleRegistration(array $data): Model
    {
        $user = parent::handleRegistration($data);
        $user->assignRole('sender');

        return $user;
    }

    protected function afterRegister(): void
    {
        Notification::make()
            ->success()
            ->title('Account created successfully')
            ->body('Welcome to ErrandBridge Sender. Complete your profile to start posting errands.')
            ->send();
    }
}
