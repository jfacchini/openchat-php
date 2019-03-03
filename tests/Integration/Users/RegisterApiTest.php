<?php

namespace App\Tests\Integration\Users;

use App\Tests\RestTestCase\ApiTestCase;

class RegisterApiTest extends ApiTestCase
{
    protected function setUp()
    {
        $container = static::bootKernel([])->getContainer();

        $filePath = $container->getParameter('users_db_filepath');
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

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
