<?php

namespace App\Tests\Unit\Infrastructure\Api;

use App\Domain\Users\User;
use App\Domain\Users\UserCredentials;
use App\Domain\Users\UserRepository;
use App\Infrastructure\Api\LoginApi;
use App\Tests\Fixtures\UserBuilder;
use ocramius\util\Optional;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class LoginApiTest extends TestCase
{
    /**
     * @var LoginApi
     */
    private $loginApi;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserCredentials
     */
    private $credentials;

    /**
     * @var User
     */
    private $user;

    protected function setUp()
    {
        $this->user = (new UserBuilder())->build();
        $this->credentials = new UserCredentials($this->user->username(), 'password');

        $this->userRepository = $this->prophesize(UserRepository::class);
        $this->userRepository
            ->userFor($this->credentials)
            ->willReturn(Optional::of($this->user));

        $this->loginApi = new LoginApi($this->userRepository->reveal());
    }

    /**
     * @test
     */
    public function returns_a_json_that_represents_a_valid_user(): void
    {
        $request = new Request([], [], [], [], [], [], <<<JSON
            {
              "username": "{$this->user->username()}",
              "password": "password"
            }
        JSON
        );

        $response = $this->loginApi->login($request);

        Assert::assertEquals(200, $response->getStatusCode());
        Assert::assertEquals('application/json', $response->headers->get('Content-Type'));
        Assert::assertEquals([
            'id' => $this->user->id()->toString(),
            'username' => $this->user->username(),
            'about' => $this->user->about(),
        ], json_decode($response->getContent(), true));
    }
}
