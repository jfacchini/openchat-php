<?php

namespace App\Tests\Integration\Users;

use App\Tests\RestTestCase\ApiTestCase;
use function App\Tests\RestTestCase\given;
use function App\Tests\RestTestCase\is;
use function App\Tests\RestTestCase\uuid;

class RegisterApiTest extends ApiTestCase
{
    /**
     * @test
     */
    public function it_register_a_new_user(): void
    {
        given()
            ->body(<<<JSON
            {
              "username": "Username",
              "password": "Password",
              "about": "About Username"
            }
            JSON
            )
        ->when()
            ->post('/api/users')
        ->then()
            ->statusCode(201)
            ->contentType(ApiTestCase::JSON_TYPE)
            ->body('id', uuid())
            ->body('username', is('Username'))
            ->body('about', is('About Username'))
        ;
    }
}
