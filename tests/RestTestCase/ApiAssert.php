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
        $actual = $response->headers->get('Content-Type');

        Assert::assertSame($expected, $actual, sprintf(
            'Expected Response Content-Type to be "%s", but got "%s".',
            $expected,
            $actual,
        ));
    }

    /**
     * @param int      $expected
     * @param Response $response
     */
    public static function assertStatusCode(int $expected, Response $response): void
    {
        $actual = $response->getStatusCode();

        Assert::assertSame($expected, $actual, sprintf(
            'Expected status code "%s" but got "%s" with body "%s"',
            $expected,
            $actual,
            $response->getContent(),
        ));
    }
}
