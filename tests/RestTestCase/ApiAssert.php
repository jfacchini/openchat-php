<?php

namespace App\Tests\RestTestCase;

use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiAssert
{
    /**
     * @param string   $expected
     * @param Response $response
     */
    public static function assertContentType(string $expected, Response $response): void
    {
        Assert::assertSame($expected, $response->headers->get('Content-Type'));
    }

    /**
     * @param int      $expected
     * @param Response $response
     */
    public static function assertStatusCode(int $expected, Response $response): void
    {
        Assert::assertSame($expected, $response->getStatusCode(), sprintf(
            'Expected status code "%s" but got "%s" with body "%s"',
            $expected,
            $response->getStatusCode(),
            $response->getContent(),
        ));
    }
}
