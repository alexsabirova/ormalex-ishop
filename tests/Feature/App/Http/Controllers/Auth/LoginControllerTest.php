<?php

namespace Tests\Feature\App\Http\Controllers\Auth;


use App\Http\Controllers\Auth\LoginController;
use App\Http\Requests\LoginFormRequest;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\NoReturn;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    #[NoReturn] #[Test]
    public function it_page_success(): void
    {
        $this->get(action([LoginController::class, 'page']))
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.login');
    }

    #[NoReturn] #[Test]
    public function it_handle_success(): void
    {
        $password = '1234567890';

        $user = UserFactory::new()->create([
            'email' => 'john@mail.com',
            'password' => Hash::make($password),
        ]);

        $request = LoginFormRequest::factory()->create([
            'email' => $user->email,
            'password' => $password,
        ]);

        $response = $this->post(
            action([LoginController::class, 'handle']),
            $request);

        $response
            ->assertValid()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

    #[NoReturn] #[Test]
    public function it_handle_fail(): void
    {
        $request = LoginFormRequest::factory()->create([
            'email' => 'notfound@mail.com',
            'password' => str()->random(10),
        ]);

        $this->post(action([LoginController::class, 'handle']), $request)
            ->assertInvalid(['email']);

        $this->assertGuest();
    }

    #[NoReturn] #[Test]
    public function it_logout_success(): void
    {
        $user = UserFactory::new()->create([
            'email' => 'john@mail.com',
        ]);

        $this
            ->actingAs($user)
            ->delete(action([LoginController::class, 'logout']));

        $this->assertGuest();
    }

    #[NoReturn] #[Test]
    public function it_logout_guest_middleware_fail(): void
    {
        $this->delete(action([LoginController::class, 'logout']))
            ->assertRedirect(route('home'));
    }
}



