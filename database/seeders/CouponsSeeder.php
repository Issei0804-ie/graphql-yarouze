<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Seeder;

class CouponsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Products::factory(10)->create();
    }
}
