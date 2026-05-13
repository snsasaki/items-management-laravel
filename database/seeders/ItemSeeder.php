<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::create([
            'name' => 'mac',
            'category' => 'PC',
            'location' => '倉庫',
            'status' => 'in_use',
            'note' => 'M4 Pro',
        ]);
        Item::create([
            'name' => 'windows',
            'category' => 'PC',
            'location' => '倉庫',
            'status' => 'in_use',
            'note' => 'windows 11',
        ]);
        Item::create([
            'name' => 'USBhub',
            'category' => 'デバイス',
            'location' => '倉庫',
            'status' => 'available',
            'note' => '',
        ]);
        Item::create([
            'name' => 'USBhub2',
            'category' => 'デバイス',
            'location' => '倉庫',
            'status' => 'available',
            'note' => '',
        ]);
        Item::create([
            'name' => 'pen',
            'category' => '備品',
            'location' => '資料室',
            'status' => 'maintenance',
            'note' => '',
        ]);
        Item::create([
            'name' => 'notebook',
            'category' => 'PC',
            'location' => '資料室',
            'status' => 'maintenance',
            'note' => '',
        ]);
    }
}
