<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameStartTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccess()
    {
        $this->startGame()
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => true,
                    'hash' => true,
                    'code' => true,
                ],
            ]);
    }
}
