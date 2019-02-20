<?php

namespace App\Domain\Users;

class UserRepository
{
    public function add(User $user): void
    {
        throw new \RuntimeException('Not Implemented.');
    }

    public function isUsernameTaken(string $username): bool
    {
        throw new \RuntimeException('Not Implemented.');
    }
}
