<?php

namespace Tests\Feature\Api;

use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_item_list(): void
    {

        Item::factory()
            ->count(5)
            ->create();

        $response = $this->getJson('/api/items');

        $response
            ->assertStatus(200)
            ->assertJsonCount(5, 'data');
    }

    public function test_item_list_has_expected_json_structure(): void
    {

        Item::factory()
            ->count(3)
            ->create();

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
