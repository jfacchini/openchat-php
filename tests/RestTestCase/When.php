<?php

namespace App\Tests\RestTestCase;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

class When
{
    private KernelBrowser $client;

    private string $body;

    private Response $response;

    public function __construct(KernelBrowser $client, string $body)
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
            $this->body,
        );

        $this->response = $this->client->getResponse();

        return $this;
    }

    public function get(string $uri): Response
    {
        $this->client->request(
            Request::METHOD_GET,
            $uri,
            [],
            [],
            [],
            null,
        );

        return $this->client->getResponse();
    }

    public function then(): Then
    {
        Assert::notNull($this->response, 'Http Response is empty, please perform a request');

        return new Then($this->response);
    }
}
