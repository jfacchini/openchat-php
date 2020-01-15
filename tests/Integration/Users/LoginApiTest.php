<?php

namespace App\Tests\Integration\Users;

use App\Domain\Users\User;
use App\Domain\Users\UserId;
use App\Infrastructure\Repository\FileUserRepository;
use App\Tests\Fixtures\UserBuilder;
use App\Tests\RestTestCase\ApiTestCase;
use function App\Tests\RestTestCase\is;

class LoginApiTest extends ApiTestCase
{
    private User $aUser;

    private FileUserRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = static::$kernel->getContainer()->get('test.user_repository');

        $this->aUser = (new UserBuilder())
            ->withId(UserId::new('a95983a4-cbbe-4652-bf38-71ad23f18c06'))
            ->withUsername('aUserName')
            ->withAbout('My about')
            ->build();
    }

    /**
     * @test
     */
    public function perform_login(): void
    {
        $this->markTestSkipped('not implemented');
        $this
        ->given()
            ->body(<<<JSON
            {
              "username": "{$this->aUser->username()}",
              "password": "aPassWord"
            }
            JSON
            )
        ->when()
            ->post('/api/login')
        ->then()
            ->statusCode(200)
            ->contentType(ApiTestCase::JSON_TYPE)
            ->body('id', is($this->aUser->id()->toString()))
            ->body('username', is($this->aUser->username()))
            ->body('about', is($this->aUser->about()))
        ;
    }
}
