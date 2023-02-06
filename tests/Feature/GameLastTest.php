<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameLastTest extends TestCase
{
    use RefreshDatabase;

    protected $game = '';

    public function setUp(): void
    {
        parent::setUp();

        $result = $this->jsonAuth('POST', $this->api.'game');
        $this->game = $result['data'];
        $this->jsonAuth('POST', $this->api.'game/connect', ['code' => $this->game['code']]);
    }

    public function testWithLast()
    {
        $this->json('GET', $this->api.'game/last')
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
