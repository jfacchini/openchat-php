<?php

namespace App\Domain\Users;

use Webmozart\Assert\Assert;

/**
 * UserId Value object.
 */
final class UserId
{
    /**
     * @var string userId as string value
     *
     * Would it be better here as string or as Uuid??
     */
    private $id;

    // Private as this is a value object, we want to use named constructor
    // that we can simulate by using static functions.
    private function __construct()
    {
    }

    public static function new(string $id): self
    {
        Assert::uuid($id);

        $userId = new self();
        $userId->id = $id;

        return $userId;
    }

    public function toString(): string
    {
        return $this->id;
    }
}
