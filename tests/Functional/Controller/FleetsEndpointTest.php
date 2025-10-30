<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FleetsEndpointTest extends WebTestCase
{
    public function testFleetsListEndpoint(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/fleets');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($client->getResponse()->getContent());
    }
}
