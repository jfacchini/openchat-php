<?php

namespace App\Infrastructure\Repository;

use App\Domain\Users\User;
use App\Domain\Users\UserId;
use App\Domain\Users\UserRepository;
use ReflectionClass;
use ReflectionProperty;
use RuntimeException;

final class FileUserRepository implements UserRepository
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;

        if (file_exists($this->filePath)) {
            $this->data = array_map([$this, 'denormalise'], json_decode(file_get_contents($filePath), true));
        } else {
            $this->data = [];
        }
    }

    public function add(User $user): void
    {
        $this->data[$user->id()->toString()] = $user;

        file_put_contents($this->filePath, json_encode(array_map([$this, 'normalise'], $this->data), JSON_PRETTY_PRINT));
    }

    public function isUsernameTaken(string $username): bool
    {
        $users = array_filter($this->data, function (User $user) use ($username) {
            return $user->username() === $username;
        });

        return count($users) > 0;
    }

    public function get(UserId $id): User
    {
        if (!isset($this->data[$id->toString()])) {
            throw new RuntimeException("No User with id \"$id\" was found.");
        }

        return $this->data[$id->toString()];
    }

    public function all(): array
    {
        return $this->data;
    }

    private function normalise(User $user): array
    {
        $reflect = new ReflectionClass(User::class);
        $properties = $reflect->getProperties();

        return array_reduce($properties, function ($acc, ReflectionProperty $property) use ($user) {
            $property->setAccessible(true);

            $acc[$property->getName()] = $property->getValue($user);

            return $acc;
        }, []);
    }

    private function denormalise(array $user): User
    {
        $reflect = new ReflectionClass(User::class);
        $properties = $reflect->getProperties();

        $userObject = $reflect->newInstanceWithoutConstructor();
        array_walk($properties, function (ReflectionProperty $property) use ($user, $userObject) {
            $property->setAccessible(true);

            $property->setValue($userObject, $user[$property->getName()]);
        });

        return $userObject;
    }
}
