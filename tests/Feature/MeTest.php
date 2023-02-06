<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MeTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccess()
    {
        $response = $this->json('GET', $this->api.'me');

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => true,
                    'email' => true,
                ],
            ]);
    }
}
