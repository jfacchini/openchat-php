<?php

namespace App\Tests\Fixtures;

use App\Domain\Users\User;

class UserBuilder implements Builder
{
    /**
     * @var string
     */
    private $id;

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

    public function __construct()
    {
        $this->id = '4c81cecc-03f3-4714-8f7b-2db5e68f1c1d';
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

    public function withId(string $id): self
    {
        $this->id = $id;

        return $this;
    }
}
