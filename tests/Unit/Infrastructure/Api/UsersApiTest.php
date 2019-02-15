<?php

namespace App\Tests\Unit\Infrastructure\Api;

use App\Domain\Users\RegistrationData;
use App\Domain\Users\UserService;
use App\Infrastructure\Api\UsersApi;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\HttpFoundation\Request;

final class UsersApiTest extends TestCase
{
    /**
     * @var string
     */
    private $username = 'Username';

    /**
     * @var string
     */
    private $password = 'Password';

    /**
     * @var string
     */
    private $about = 'About Username';

    /**
     * @var Request
     */
    private $request;

    /**
     * @var RegistrationData
     */
    private $registrationData;

    /**
     * @var UsersApi
     */
    private $userApi;

    /**
     * @var UserService|ObjectProphecy
     */
    private $userServiceProphet;

    protected function setUp(): void
    {
        $this->registrationData = new RegistrationData($this->username, $this->password, $this->about);
        $this->request = Request::create(
            '/api/users',
            Request::METHOD_POST,
            [],
            [],
            [],
            [],
            <<<JSON
            {
              "username": "{$this->username}",
              "password": "{$this->password}",
              "about": "{$this->about}"
            }
            JSON
        );

        $this->userServiceProphet = $this->prophesize(UserService::class);
        $this->userApi = new UsersApi($this->userServiceProphet->reveal());
    }

    /**
     * @test
     */
    public function creates_a_new_user(): void
    {
        $this->userApi->createUser($this->request);

        $this->userServiceProphet->createUser($this->registrationData)->shouldBeCalled();
    }
}
