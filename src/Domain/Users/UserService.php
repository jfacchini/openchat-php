<?php

namespace App\Domain\Users;

class UserService
{
    public function createUser(RegistrationData $registrationData): User
    {
        throw new \RuntimeException('Not Implemented.');
    }
}
