<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerGetTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccess()
    {
        $this->playerGet()
            ->assertStatus(200)
            ->assertJson([
                'data' => true,
            ]);
    }
}
