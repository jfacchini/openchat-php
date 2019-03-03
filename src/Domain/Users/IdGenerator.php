<?php

namespace App\Domain\Users;

use Ramsey\Uuid\Uuid;

class IdGenerator
{
    public function next(): string
    {
        return Uuid::uuid4()->toString();
    }
}
