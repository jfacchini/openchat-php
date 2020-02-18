<?php

namespace App\Tests\Integration\Users;

use App\Domain\Users\User;
use App\Domain\Users\UserId;
use App\Infrastructure\Normalizers\UserNormalizer;
use App\Infrastructure\Repository\FileUserRepository;
use App\Tests\Fixtures\UserBuilder;
use App\Tests\RestTestCase\ApiAssert;
use App\Tests\RestTestCase\ApiTestCase;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

class UsersApiTest extends ApiTestCase
{
    private FileUserRepository $userRepository;

    private User $user1;

    private User $user2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = static::$kernel->getContainer()->get('test.user_repository');

        $this->user1 = (new UserBuilder())
            ->withUsername('User1')
            ->build();
        $this->user2 = (new UserBuilder())
            ->withId(UserId::new('a95983a4-cbbe-4652-bf38-71ad23f18c06'))
            ->withUsername('User2')
            ->build();
    }

    /**
     * @test
     */
    public function returns_all_users(): void
    {
        $this->register($this->user1);
        $this->register($this->user2);

        $response = $this->when()->get('/api/users');

        self::assertAllUsersAreReturned($response, $this->user1, $this->user2);
    }

    /**
     * @param User[] $users
     */
    private static function assertAllUsersAreReturned(Response $response, ...$users): void
    {
        ApiAssert::assertStatusCode(Response::HTTP_OK, $response);
        ApiAssert::assertContentType('application/json', $response);

        $usersAsArray = json_decode($response->getContent(), true);

        array_walk($users, function (User $user) use ($usersAsArray) {
            Assert::assertContains(UserNormalizer::normalize($user), $usersAsArray);
        });
    }

    private function register(User $user): void
    {
        $this->userRepository->add($user);
    }
}
