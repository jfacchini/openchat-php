<?php

namespace App\Tests\Integration\Users;

use App\Tests\RestTestCase\ApiTestCase;

class RegisterApiTest extends ApiTestCase
{
    /**
     * @test
     */
    public function it_register_a_new_user(): void
    {
        self::given()
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
            ->body('id', self::uuid())
            ->body('username', self::is('Username'))
            ->body('about', self::is('About Username'))
        ;
    }
}
