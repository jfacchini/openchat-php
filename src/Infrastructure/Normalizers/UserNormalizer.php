<?php

namespace App\Infrastructure\Normalizers;

use App\Domain\Users\User;

class UserNormalizer
{
    public static function normalize(User $user): array
    {
        return [
            'id' => $user->id(),
            'username' => $user->username(),
            'about' => $user->about(),
        ];
    }
}
