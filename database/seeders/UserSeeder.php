<?php

namespace Database\Seeders;

use App\Models\User;
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
                'phone_number' => '09145248745',
                'address' => 'Manila, Metro Manila',
                'remember_token' => Str::random(10),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Merchant',
                'email' => 'merchant@merchant.com',
                'password' => Hash::make('password'),
                'phone_number' => '09145242414',
                'address' => 'Manila, Metro Manila',
                'remember_token' => Str::random(10),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'phone_number' => '09145244561',
                'address' => 'Manila, Metro Manila',
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
        User::query()->truncate();

        foreach($this->sampleUser() as $data)
        {
            User::query()->create($data);
        }
        
    }
}
