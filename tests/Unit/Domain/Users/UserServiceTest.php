<?php

namespace App\Tests\Unit\Domain\Users;

use App\Domain\Users\IdGenerator;
use App\Domain\Users\RegistrationData;
use App\Domain\Users\User;
use App\Domain\Users\UsernameAlreadyInUseException;
use App\Domain\Users\UserRepository;
use App\Domain\Users\UserService;
use App\Tests\Fixtures\UserBuilder;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class UserServiceTest extends TestCase
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $about;

    /**
     * @var RegistrationData
     */
    private $registrationData;

    /**
     * @var User
     */
    private $user;

    /**
     * @var IdGenerator|ObjectProphecy
     */
    private $idGeneratorProphet;

    /**
     * @var UserRepository|ObjectProphecy
     */
    private $userRepositoryProphet;

    /**
     * @var UserService
     */
    private $userService;

    protected function setUp(): void
    {
        $this->uuid = 'aab1abc3-c3dd-46eb-9e10-d02c1f6c623e';
        $this->username = 'Username';
        $this->password = 'Password';
        $this->about = 'About Username';
        $this->registrationData = new RegistrationData($this->username, $this->password, $this->about);
        $this->user = new User($this->uuid, $this->username, $this->password, $this->about);

        $this->idGeneratorProphet = $this->prophesize(IdGenerator::class);
        /** @var IdGenerator $idGenerator */
        $idGenerator = $this->idGeneratorProphet->reveal();

        $this->userRepositoryProphet = $this->prophesize(UserRepository::class);
        $this->userRepositoryProphet->isUsernameTaken(Argument::cetera())->willReturn(false);
        /** @var UserRepository $userRepository */
        $userRepository = $this->userRepositoryProphet->reveal();

        $this->userService = new UserService($idGenerator, $userRepository);
    }

    /**
     * @test
     */
    public function creates_a_user(): void
    {
        $this->idGeneratorProphet->next()->willReturn($this->uuid);
        $this->userRepositoryProphet->add($this->user)->shouldBeCalled();

        $newUser = $this->userService->createUser($this->registrationData);
        Assert::assertEquals($this->user, $newUser);
    }

    /**
     * @test
     */
    public function throws_an_exception_when_attempting_to_create_a_duplicate_user(): void
    {
        $this->userRepositoryProphet->isUsernameTaken($this->username)->willReturn(true);

        $this->expectException(UsernameAlreadyInUseException::class);

        $this->userService->createUser($this->registrationData);
    }

    /**
     * @test
     */
    public function returns_all_users(): void
    {
        $users = [
            $this->user,
            (new UserBuilder())->withUsername('User2')->withId('a95983a4-cbbe-4652-bf38-71ad23f18c06')->build(),
        ];
        $this->userRepositoryProphet->all()->willReturn($users);

        $foundUsers = $this->userService->allUsers();

        Assert::assertEquals($users, $foundUsers);
    }
}
