<?php

namespace App\Tests\RestTestCase;

use App\Tests\RestTestCase\Then;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

class When
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $body;

    /**
     * @var Response
     */
    private $response;

    public function __construct(Client $client, string $body)
    {
        $this->client = $client;
        $this->body = $body;
    }

    public function post(string $uri): self
    {
        $this->client->request(
            Request::METHOD_POST,
            $uri,
            [],
            [],
            [],
            $this->body
        );

        $this->response = $this->client->getResponse();

        return $this;
    }

    public function then(): Then
    {
        Assert::notNull($this->response, 'Http Response is empty, please perform a request');

        return new Then($this->response);
    }
}
