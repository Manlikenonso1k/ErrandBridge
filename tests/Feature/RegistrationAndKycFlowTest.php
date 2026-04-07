<?php

namespace Tests\Feature;

use App\Filament\Runner\Pages\Auth\Register as RunnerRegisterPage;
use App\Filament\Sender\Pages\Auth\Register as SenderRegisterPage;
use App\Models\KycSubmission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RegistrationAndKycFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::findOrCreate('admin', 'web');
        Role::findOrCreate('sender', 'web');
        Role::findOrCreate('runner', 'web');
    }

    public function test_sender_registration_assigns_sender_role(): void
    {
        $page = new class extends SenderRegisterPage {
            public function registerViaTest(array $data): User
            {
                /** @var User $user */
                $user = $this->handleRegistration($data);

                return $user;
            }
        };

        $user = $page->registerViaTest([
            'name' => 'Sender One',
            'email' => 'sender-one@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->assertTrue($user->hasRole('sender'));
        $this->assertFalse($user->hasRole('runner'));
    }

    public function test_runner_registration_assigns_runner_role(): void
    {
        $page = new class extends RunnerRegisterPage {
            public function registerViaTest(array $data): User
            {
                /** @var User $user */
                $user = $this->handleRegistration($data);

                return $user;
            }
        };

        $user = $page->registerViaTest([
            'name' => 'Runner One',
            'email' => 'runner-one@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->assertTrue($user->hasRole('runner'));
        $this->assertFalse($user->hasRole('sender'));
    }

    public function test_new_runner_can_submit_initial_pending_kyc_record(): void
    {
        $page = new class extends RunnerRegisterPage {
            public function registerViaTest(array $data): User
            {
                /** @var User $user */
                $user = $this->handleRegistration($data);

                return $user;
            }
        };

        $runner = $page->registerViaTest([
            'name' => 'Runner Kyc',
            'email' => 'runner-kyc@example.com',
            'password' => Hash::make('password'),
        ]);

        $submission = KycSubmission::create([
            'user_id' => $runner->id,
            'document_path' => 'kyc/runner-kyc-id.png',
            'notes' => 'Initial KYC submitted after registration.',
        ])->refresh();

        $this->assertSame('pending', $submission->status);
        $this->assertTrue($runner->hasRole('runner'));

        $this->assertDatabaseHas('kyc_submissions', [
            'id' => $submission->id,
            'user_id' => $runner->id,
            'status' => 'pending',
        ]);
    }

    public function test_sender_can_log_in_after_registration(): void
    {
        $page = new class extends SenderRegisterPage {
            public function registerViaTest(array $data): User
            {
                /** @var User $user */
                $user = $this->handleRegistration($data);

                return $user;
            }
        };

        $user = $page->registerViaTest([
            'name' => 'Sender Login Test',
            'email' => 'sender-login@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->assertTrue($user->hasRole('sender'));

        $this->assertTrue(Auth::attempt([
            'email' => 'sender-login@example.com',
            'password' => 'password123',
        ]));
    }

    public function test_runner_can_log_in_after_registration(): void
    {
        $page = new class extends RunnerRegisterPage {
            public function registerViaTest(array $data): User
            {
                /** @var User $user */
                $user = $this->handleRegistration($data);

                return $user;
            }
        };

        $user = $page->registerViaTest([
            'name' => 'Runner Login Test',
            'email' => 'runner-login@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->assertTrue($user->hasRole('runner'));

        $this->assertTrue(Auth::attempt([
            'email' => 'runner-login@example.com',
            'password' => 'password123',
        ]));
    }
}
