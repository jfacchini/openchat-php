<?php

namespace App\Tests\RestTestCase;

use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

class Then
{
    /**
     * @var Response
     */
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function statusCode(int $statusCode): self
    {
        ApiAssert::assertStatusCode($statusCode, $this->response);

        return $this;
    }

    public function contentType(string $type): self
    {
        ApiAssert::assertContentType($type, $this->response);

        return $this;
    }

    public function body(string $key, callable $assert): self
    {
        $body = json_decode($this->response->getContent(), true);

        if (isset($body[$key])) {
            $assert($body[$key]);
        } else {
            Assert::fail("Json body does not contain any '$key' key.");
        }

        return $this;
    }
}
