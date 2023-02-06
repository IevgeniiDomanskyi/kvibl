<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerAddTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccess()
    {
        $this->playerAdd()
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'hash' => true
                ],
            ]);
    }
}
