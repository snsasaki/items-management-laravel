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

        // それぞれのキーの値が含まれることを確認している
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'category',
                        'location',
                        'status',
                        'status_label',
                        'note',
                        'created_date',
                        'updated_date',
                    ],
                ],
            ]);
    }
}
