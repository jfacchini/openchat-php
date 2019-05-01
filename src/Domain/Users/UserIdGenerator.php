<?php

namespace App\Domain\Users;

interface UserIdGenerator
{
    public function next(): UserId;
}
