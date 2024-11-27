<?php

namespace Tests\Feature\Auth\DTOs;

use App\Http\Requests\RegisterFormRequest;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;

use JetBrains\PhpStorm\NoReturn;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class NewUserDTOTest extends TestCase
{
    use RefreshDatabase;

    #[NoReturn] #[Test]
    public function it_instance_created_from_form_request(): void
    {
        $dto = NewUserDTO::fromRequest(new RegisterFormRequest([
            'name' => 'John',
            'email' => 'john@mail.com',
            'password' => '1234567890',
        ]));

        $this->assertInstanceOf(NewUserDTO::class, $dto);
    }
}



