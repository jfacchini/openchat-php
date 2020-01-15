<?php

namespace App\Domain;

use Ramsey\Uuid\Uuid as RamseyUuid;
use Throwable;
use Webmozart\Assert\Assert;

class Uuid
{
    private string $value;

    private function __construct()
    {
    }

    public static function next(): self
    {
        try {
            $uuid = new self();
            $uuid->value = RamseyUuid::uuid4()->toString();

            return $uuid;
        } catch (Throwable $e) {
            throw UnableToCreateUuid::dueToException($e);
        }
    }

    public static function new(string $value): self
    {
        Assert::uuid($value);

        $uuid = new self();
        $uuid->value = $value;

        return $uuid;
    }

    public function toString(): string
    {
        return $this->value;
    }
}
