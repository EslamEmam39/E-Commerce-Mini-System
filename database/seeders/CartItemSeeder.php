<?php

namespace Database\Seeders;

use App\Models\CartItem;
use Database\Factories\CartItemFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          CartItem::factory()
          ->count(20)
          ->create();
    }
}
