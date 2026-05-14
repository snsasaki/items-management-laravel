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
                        'status_label',
                        'note',
                        'created_date',
                        'updated_date',
                    ],
                ],
            ]);
    }
    public function test_can_get_item_detail(): void
    {
        $item = Item::factory()->create([
            'name' => 'テスト用PC',
            'category' => 'PC',
            'location' => '東京本社',
            'status' => 'available',
            'note' => '詳細取得テスト用',
        ]);

        $response = $this->getJson("/api/items/{$item->id}");

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.id', $item->id)
            ->assertJsonPath('data.name', 'テスト用PC')
            ->assertJsonPath('data.category', 'PC')
            // ->assertJsonPath('data.status', 'available')
            ->assertJsonPath('data.status_label', '利用可能');
    }
    public function test_factory_creates_item_in_database(): void
    {
        Item::factory()->create([
            'name' => 'DB確認用備品',
            'category' => '周辺機器',
            'status' => 'available',
        ]);

        $this->assertDatabaseHas('items', [
            'name' => 'DB確認用備品',
            'category' => '周辺機器',
            'status' => 'available',
        ]);
    }
}
