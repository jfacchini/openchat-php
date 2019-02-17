<?php

namespace App\Tests\RestTestCase;

use Symfony\Bundle\FrameworkBundle\Client;

class Given
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $body;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->body = '';
    }

    public function body(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function when(): When
    {
        return new When($this->client, $this->body);
    }
}
