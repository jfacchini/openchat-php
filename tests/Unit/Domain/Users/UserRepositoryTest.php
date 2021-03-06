<?php

namespace App\Tests\Unit\Domain\Users;

use App\Domain\Users\User;
use App\Infrastructure\Repository\FileUserRepository;
use App\Tests\Fixtures\UserBuilder;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    private FileUserRepository $userRepository;

    private string $usersFilePath;

    private User $user1;

    private User $user2;

    protected function setUp(): void
    {
        $this->usersFilePath = __DIR__.'/users.json';
        if (file_exists($this->usersFilePath)) {
            unlink($this->usersFilePath);
        }

        $this->userRepository = new FileUserRepository($this->usersFilePath);

        $this->user1 = (new UserBuilder())->withUsername('User1')->build();
        $this->user2 = (new UserBuilder())->withUsername('User2')->build();
    }

    /**
     * @test
     */
    public function saves_data_in_a_file(): void
    {
        $this->userRepository->add($this->user1);

        $newRepository = new FileUserRepository($this->usersFilePath);
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
