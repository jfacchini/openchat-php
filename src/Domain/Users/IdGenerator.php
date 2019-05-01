<?php

namespace App\Domain\Users;

use App\Domain\Uuid;

final class IdGenerator implements UserIdGenerator
{
    public function next(): UserId
    {
        return UserId::new(Uuid::next()->toString());
    }
}
