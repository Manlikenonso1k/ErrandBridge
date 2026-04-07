<?php

namespace Tests\Feature;

use App\Filament\Auth\RegistrationResponse;
use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse as RegistrationResponseContract;
use Filament\Panel;
use Illuminate\Http\RedirectResponse;
use Mockery;
use Tests\TestCase;

class RegistrationRedirectResponseTest extends TestCase
{
    public function test_registration_response_contract_uses_custom_implementation(): void
    {
        $response = app(RegistrationResponseContract::class);

        $this->assertInstanceOf(RegistrationResponse::class, $response);
    }

    public function test_registration_response_redirects_to_current_panel_url(): void
    {
        $panel = Mockery::mock(Panel::class);
        $panel->shouldReceive('getUrl')->once()->andReturn('/sender');

        Filament::shouldReceive('getCurrentPanel')->once()->andReturn($panel);

        $response = app(RegistrationResponseContract::class)->toResponse(request());

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertStringEndsWith('/sender', $response->getTargetUrl());
    }

    public function test_registration_response_redirects_to_runner_panel_url(): void
    {
        $panel = Mockery::mock(Panel::class);
        $panel->shouldReceive('getUrl')->once()->andReturn('/runner');

        Filament::shouldReceive('getCurrentPanel')->once()->andReturn($panel);

        $response = app(RegistrationResponseContract::class)->toResponse(request());

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertStringEndsWith('/runner', $response->getTargetUrl());
    }

    public function test_registration_response_falls_back_to_filament_default_url(): void
    {
        Filament::shouldReceive('getCurrentPanel')->once()->andReturn(null);
        Filament::shouldReceive('getUrl')->once()->andReturn('/admin');

        $response = app(RegistrationResponseContract::class)->toResponse(request());

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertStringEndsWith('/admin', $response->getTargetUrl());
    }
}
