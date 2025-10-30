<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrdersEndpointTest extends WebTestCase
{
    public function testOrdersListEndpoint(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/orders');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($client->getResponse()->getContent());
    }
}
