<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->getJson('/api/transactions');

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $response = $this->postJson('/api/transactions',[
            'nsu' => 220788,
            'authorizationNumber' => 010203,
            'amount' => 22.88,
            'transactionDate' => date('Y-m-d H:i:s'),
            'type' => 'CARD'
        ]);

        $response->assertOk();
    }

    public function testShow()
    {
        $response = $this->get('/api/transactions/2');

        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $response = $this->putJson('/api/transactions/2', [
            'id' => 1,
            'nsu' => 112233,
            'authorizationNumber' => 030201,
            'amount' => 50.22,
            //'transactionDate' => date('Y-m-d H:i:s'),
            'type' => 'MONEY'
        ]);


        $response->assertOk();
    }

    public function testDestroy()
    {
        $response = $this->json('DELETE','/api/transactions/2');

        $response->assertStatus(200);
    }

    public function testStatistics()
    {
        $response = $this->getJson('/api/transactions/statistics');

        $response->assertStatus(200);
    }
}
