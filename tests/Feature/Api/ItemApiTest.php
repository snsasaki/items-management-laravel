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
            ->assertJsonPath('data.status', 'available')
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
    public function test_store_returns_validation_errors(): void
    {
        $response = $this->postJson('/api/items', [
            'name' => '',
            'category' => '',
            'status' => 'broken',
        ]);

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name',
                'category',
                'status',
            ]);
    }
    public function test_invalid_item_is_not_saved(): void
    {
        $this->postJson('/api/items', [
            'name' => '',
            'category' => '',
            'status' => 'broken',
        ]);

        $this->assertDatabaseCount('items', 0);
    }
    public function test_store_accepts_valid_item_data(): void
    {
        $response = $this->postJson('/api/items', [
            'name' => 'テスト用PC',
            'category' => 'PC',
            'location' => '東京本社',
            'status' => 'available',
            'note' => 'バリデーション正常系テスト',
        ]);

        $response
            ->assertCreated()
            ->assertJsonPath('data.name', 'テスト用PC')
            ->assertJsonPath('data.status', 'available');

        $this->assertDatabaseHas('items', [
            'name' => 'テスト用PC',
            'category' => 'PC',
            'status' => 'available',
        ]);
    }
    public function test_update_returns_validation_errors(): void
    {
        $item = Item::factory()->create();

        $response = $this->patchJson("/api/items/{$item->id}", [
            'name' => '',
            'status' => 'broken',
        ]);

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name',
                'status',
            ]);
    }
    public function test_invalid_update_does_not_change_item(): void
    {
        $item = Item::factory()->create([
            'name' => '変更前の備品',
            'category' => 'PC',
            'status' => 'available',
        ]);

        $this->patchJson("/api/items/{$item->id}", [
            'name' => '',
            'status' => 'broken',
        ]);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'name' => '変更前の備品',
            'category' => 'PC',
            'status' => 'available',
        ]);
    }
    public function test_status_must_be_allowed_value(): void
    {
        $response = $this->postJson('/api/items', [
            'name' => 'テスト備品',
            'category' => 'PC',
            'status' => 'unknown',
        ]);

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'status',
            ]);
    }
    public function test_returns_404_when_item_not_found(): void
    {
        $response = $this->getJson('/api/items/999999');

        $response->assertNotFound();
    }
    public function test_can_create_item(): void
    {
        $response = $this->postJson('/api/items', [
            'name' => 'テストモニター',
            'category' => '周辺機器',
            'location' => '東京本社',
            'status' => 'available',
            'note' => '追加課題用',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.name', 'テストモニター');

        $this->assertDatabaseHas('items', [
            'name' => 'テストモニター',
            'category' => '周辺機器',
            'status' => 'available',
        ]);
    }
    public function test_can_update_item(): void
    {
        $item = Item::factory()->create([
            'name' => '変更前備品',
            'status' => 'available',
        ]);

        $response = $this->patchJson("/api/items/{$item->id}", [
            'name' => '変更後備品',
            'status' => 'in_use',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('data.name', '変更後備品')
            ->assertJsonPath('data.status', 'in_use');

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'name' => '変更後備品',
            'status' => 'in_use',
        ]);
    }
}
