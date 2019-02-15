<?php

namespace App\Tests\Unit\Infrastructure\Api;

use App\Domain\Users\RegistrationData;
use App\Domain\Users\User;
use App\Domain\Users\UserService;
use App\Infrastructure\Api\UsersApi;
use App\Tests\Fixtures\UserBuilder;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\HttpFoundation\Request;

final class UsersApiTest extends TestCase
{
    /**
     * @var string
     */
    private $id = '69b843fb-766c-4467-8f0f-b9263d4fae58';

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

    /**
     * @var User
     */
    private $user;

    protected function setUp(): void
    {
        $this->registrationData = new RegistrationData($this->username, $this->password, $this->about);
        $this->user = (new UserBuilder())
            ->withId($this->id)
            ->withUsername($this->username)
            ->withPassword($this->password)
            ->withAbout($this->about)
            ->build();
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
        $this->userServiceProphet->createUser($this->registrationData)->willReturn($this->user);

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

    /**
     * @test
     */
    public function returns_a_json_with_the_newly_created_user(): void
    {
        $response = $this->userApi->createUser($this->request);

        Assert::assertSame(
            sprintf('{"id":"%s","username":"%s","about":"%s"}', $this->id, $this->username, $this->about),
            $response->getContent(),
        );
    }
}
