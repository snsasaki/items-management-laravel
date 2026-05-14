<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'PC',
            'description' => '作業用PC（Windows/Mac）',
            'is_active' => true,
        ]);
        Category::create([
            'name' => '携帯',
            'description' => '社内用スマホ',
            'is_active' => true,
        ]);
        Category::create([
            'name' => 'サウンド機器',
            'description' => 'イヤホンやスピーカーなどのオーディオ機器',
            'is_active' => false,
        ]);
    }
}
