<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\PermissionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * @return void
     */
    public function run(): void
    {
        $this->call([
            BrandSeeder::class,
            CategorySeeder::class,
            UserSeeder::class,
            ProductSeeder::class,
            PermissionSeeder::class,
        ]);

    }
}
