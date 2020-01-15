<?php

namespace App\Tests\RestTestCase;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class Given
{
    private KernelBrowser $client;

    /**
     * @var string
     */
    private string $body;

    public function __construct(KernelBrowser $client)
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
