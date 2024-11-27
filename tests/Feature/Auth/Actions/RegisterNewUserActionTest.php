<?php

namespace Tests\Feature\Auth\Actions;

use App\Http\Requests\RegisterFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;

use JetBrains\PhpStorm\NoReturn;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RegisterNewUserActionTest extends TestCase
{
    use RefreshDatabase;

    #[NoReturn] #[Test]
    public function it_success_user_created(): void
    {
        $this->assertDatabaseMissing('users', [
            'email' => 'john@mail.com',
        ]);

        $action = app(RegisterNewUserContract::class);

        $action(NewUserDTO::make(
            'John',
            'john@mail.com',
            '1234567890')
        );

        $this->assertDatabaseHas('users', [
            'email' => 'john@mail.com',
        ]);
    }
}



