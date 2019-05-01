<?php

namespace App\Domain\Users;

final class User
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
