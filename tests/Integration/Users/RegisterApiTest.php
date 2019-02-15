<?php

namespace App\Tests\Integration\Users;

use App\Tests\RestClient\ApiTestCase;

class RegisterApiTest extends ApiTestCase
{
    /**
     * @test
     */
    public function it_register_a_new_user(): void
    {
        $username = 'Username';
        $password = 'Password';

        self::given()
            ->body(<<<JSON
            {
              "username": "$username",
              "password": "$password"
            }
            JSON)
        ->when()
            ->post('/api/users')
        ->then()
            ->statusCode(201)
            ->contentType(ApiTestCase::JSON_TYPE)
            ->body('username', $username)
            ->body('password', $password)
        ;
    }
}
