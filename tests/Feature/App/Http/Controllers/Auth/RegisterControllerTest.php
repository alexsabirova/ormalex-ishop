<?php

namespace Tests\Feature\App\Http\Controllers\Auth;


use App\Http\Controllers\Auth\RegisterController;
use App\Http\Requests\RegisterFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Notifications\NewUserNotification;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\TestResponse;
use JetBrains\PhpStorm\NoReturn;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    protected array $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = RegisterFormRequest::factory()->create([
            'email' => 'john@mail.com',
            'password' => '1234567890',
            'password_confirmation' => '1234567890',
        ]);
    }

    private function request(): TestResponse
    {
        return $this->post(
            action([RegisterController::class, 'handle']),
            $this->request
        );
    }

    private function findUser(): User
    {
        return User::query()
            ->where('email', $this->request['email'])
            ->first();
    }

    #[NoReturn] #[Test]
    public function it_page_success(): void
    {
        $this->get(action([RegisterController::class, 'page']))
            ->assertOk()
            ->assertSee('Регистрация')
            ->assertViewIs('auth.register');
    }

    #[NoReturn] #[Test]
    public function it_validation_success(): void
    {
        $this->request()->assertValid();
    }

    #[NoReturn] #[Test]
    public function it_should_fail_validation_on_password_confirm(): void
    {
        $this->request['password'] = '0987654321';
        $this->request['password_confirmation'] = '1234567890';

        $this->request()->assertInvalid('password');
    }

    #[NoReturn] #[Test]
    public function it_user_created_success(): void
    {
        $this->assertDatabaseMissing('users', [
            'email' => $this->request['email']
        ]);

        $this->request();

        $this->assertDatabaseHas('users', [
            'email' => $this->request['email']
        ]);
    }

    #[NoReturn] #[Test]
    public function it_should_fail_validation_on_unique_email(): void
    {
        UserFactory::new()->create([
            'email' => $this->request['email'],
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $this->request['email'],
        ]);

        $this->request()
            ->assertInvalid('email');
    }

    #[NoReturn] #[Test]
    public function it_registered_event_and_listeners_dispatched(): void
    {
        Event::fake();

        $this->request();

        Event::assertDispatched(Registered::class);
        Event::assertListening(
            Registered::class,
            SendEmailNewUserListener::class
        );
    }

    #[NoReturn] #[Test]
    public function it_notification_sent(): void
    {
        $this->request();

        Notification::assertSentTo(
            $this->findUser(),
            NewUserNotification::class,
        );
    }

    public function it_user_authenticated_after_and_redirected(): void
    {
        $this->request()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($this->findUser());
    }
}
