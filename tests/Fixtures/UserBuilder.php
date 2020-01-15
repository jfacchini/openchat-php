<?php

namespace App\Tests\Fixtures;

use App\Domain\Users\User;
use App\Domain\Users\UserId;

class UserBuilder implements Builder
{
    private UserId $id;

    private string $username;

    private string $password;

    private string $about;

    public function __construct()
    {
        $this->id = UserId::new('4c81cecc-03f3-4714-8f7b-2db5e68f1c1d');
        $this->username = 'Username';
        $this->password = 'Password';
        $this->about = 'About Username';
    }

    public function build(): User
    {
        return new User($this->id, $this->username, $this->password, $this->about);
    }

    public function withUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function withPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function withAbout(string $about): self
    {
        $this->about = $about;

        return $this;
    }

    public function withId(UserId $id): self
    {
        $this->id = $id;

        return $this;
    }
}
