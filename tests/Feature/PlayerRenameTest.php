<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerRenameTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccess()
    {
        $this->playerRename()
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'hash' => true,
                ],
            ]);
    }
}
