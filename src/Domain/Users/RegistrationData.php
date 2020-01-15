<?php

namespace App\Domain\Users;

final class RegistrationData
{
    private string $username;

    private string $password;

    private string $about;

    public function __construct(string $username, string $password, string $about)
    {
        $this->username = $username;
        $this->password = $password;
        $this->about = $about;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function about(): string
    {
        return $this->about;
    }
}
