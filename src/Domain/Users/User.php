<?php

namespace App\Domain\Users;

final class User
{
    private string $id;

    private string $username;

    private string $password;

    private string $about;

    public function __construct(UserId $id, string $username, string $password, string $about)
    {
        $this->username = $username;
        $this->password = $password;
        $this->about = $about;
        $this->id = $id->toString();
    }

    public function id(): UserId
    {
        return UserId::new($this->id);
    }

    public function username(): string
    {
        return $this->username;
    }

    public function about(): string
    {
        return $this->about;
    }
}
