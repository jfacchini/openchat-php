<?php

namespace App\Tests\Unit\Domain\Users;

use App\Domain\Users\User;
use App\Domain\Users\UserRepository;
use App\Tests\Fixtures\UserBuilder;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var string
     */
    private $usersFilePath;

    /**
     * @var User
     */
    private $user1;

    /**
     * @var User
     */
    private $user2;

    protected function setUp()
    {
        $this->usersFilePath = __DIR__.'/users.json';
        $this->userRepository = new UserRepository($this->usersFilePath);

        $this->user1 = (new UserBuilder())->withUsername('User1')->build();
        $this->user2 = (new UserBuilder())->withUsername('User2')->build();
    }

    /**
     * @test
     */
    public function saves_data_in_a_file(): void
    {
        $newRepository = new UserRepository($this->usersFilePath);

        $this->userRepository->add($this->user1);
        $user = $newRepository->get($this->user1->id());

        Assert::assertEquals($this->user1, $user);
    }

    /**
     * @test
     */
    public function informs_when_a_username_is_already_taken(): void
    {
        $this->userRepository->add($this->user1);

        Assert::assertTrue(
            $this->userRepository->isUsernameTaken($this->user1->username()),
            sprintf('Expected to have "%s" username already taken.', $this->user1->username())
        );
        Assert::assertFalse(
            $this->userRepository->isUsernameTaken($this->user2->username()),
            sprintf('Expected to have "%s" username available.', $this->user2->username())
        );
    }
}
