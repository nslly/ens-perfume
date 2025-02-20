<?php

namespace Database\Seeders;

use App\Models\Admin\Admin;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{


    /**
     * Seeding sample user for admin, merchant, user
     * 
     * @return array
     */
    protected function sampleUser(): array
    {
        return [
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Merchant',
                'email' => 'merchant@merchant.com',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'email_verified_at' => now(),
            ],
        ];
    }



    /**
     * Run the database seeds.
     * 
     * @return void
     */
    public function run(): void
    {
        Admin::query()->truncate();

        foreach ($this->sampleUser() as $data) {

            Admin::query()->create($data);
        }
    }
}
