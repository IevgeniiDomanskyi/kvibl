<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerRemoveTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccess()
    {
        $this->playerRemove()
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'hash' => true
                ],
            ]);
    }
}
