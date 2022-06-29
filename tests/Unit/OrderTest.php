<?php

namespace Tests\Unit;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_ordered_success()
    {
        $order = [
            'product_id' => 1,
            'quantity' => 100,
            'user_id' => 1,
        ];

        $response = $this->postJson('/api/order', $order);
 
        $response->assertStatus(201)
            ->assertJson([
                'message' => 'You have successfully ordered this product.'
            ]);
    }

    public function test_ordered_failed()
    {
        $order = [
            'product_id' => 1,
            'quantity' => 100,
            'user_id' => 1,
        ];

        $response = $this->postJson('/api/order', $order);
 
        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Failed to order this product due to unavailability of the stock.'
            ]);
    }
}
