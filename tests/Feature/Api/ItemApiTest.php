<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_item_list(): void
    {
        $response = $this->getJson('/api/items');

        // json型のオブジェクト,data が存在することを確認している
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ]);
    }
}
