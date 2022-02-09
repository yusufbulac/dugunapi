<?php

namespace App\Tests\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{

    public function testIndex()
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8001',
            'headers' => [
                'Content-Type'     => 'application/json',
            ]
        ]);

        $response = $client->get('/products');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCreate()
    {
        $testCreateObjectName = 'Test Object #1';
        $testCreateObjectPrice = 100;
        $testCreateObjectStatus = 'active';

        $client = new \GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8001',
            'headers' => [
                'Content-Type'     => 'application/json',
            ]
        ]);

        $response = $client->post(
            '/products',
            [
                'json' => [
                    'name' => $testCreateObjectName,
                    'price' => $testCreateObjectPrice,
                    'status' => $testCreateObjectStatus,
                ],
            ]
        );

        $responseContent = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertArrayHasKey('name', $responseContent);
        $this->assertArrayHasKey('price', $responseContent);
        $this->assertArrayHasKey('status', $responseContent);
        $this->assertEquals($testCreateObjectName, $responseContent['name']);
        $this->assertEquals($testCreateObjectPrice, $responseContent['price']);
        $this->assertEquals($testCreateObjectStatus, $responseContent['status']);
    }

    public function testUpdate()
    {
        $testUpdateObjectName = 'Test Object #1 Updated';
        $testUpdateObjectPrice = 200;
        $testUpdateObjectStatus = 'active';

        $client = new \GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8001',
            'headers' => [
                'Content-Type'     => 'application/json',
            ]
        ]);

        $response = $client->put(
            '/products/6',
            [
                'json' => [
                    'name' => $testUpdateObjectName,
                    'price' => $testUpdateObjectPrice,
                    'status' => $testUpdateObjectStatus,
                ],
            ]
        );

        $responseContent = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('name', $responseContent);
        $this->assertArrayHasKey('price', $responseContent);
        $this->assertArrayHasKey('status', $responseContent);
        $this->assertEquals($testUpdateObjectName, $responseContent['name']);
        $this->assertEquals($testUpdateObjectPrice, $responseContent['price']);
        $this->assertEquals($testUpdateObjectStatus, $responseContent['status']);
    }


    public function testDelete()
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8001',
            'headers' => [
                'Content-Type'     => 'application/json',
            ]
        ]);

        $response = $client->delete(
            '/products/7'
        );

        $this->assertEquals(204, $response->getStatusCode());
    }



}
