<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{

    private string $guard_name = 'admin';

    /**
     * Run the database seeds.
     * 
     * @return void
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view products',
            'create products',
            'edit products',
            'delete products',
            'view orders',
            'create orders',
            'edit orders',
            'delete orders',
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'view brands',
            'create brands',
            'edit brands',
            'delete brands',
            'view coupons',
            'create coupons',
            'edit coupons',
            'delete coupons',
            'view reviews',
            'create reviews',
            'edit reviews',
            'delete reviews',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => $this->guard_name,
            ]);
        }

        $adminRole = Role::create([
            'name' => 'Admin',
            'guard_name' => $this->guard_name,
        ]);
        $adminRole->givePermissionTo(Permission::all());

        $merchantRole = Role::create([
            'name' => 'Merchant',
            'guard_name' => $this->guard_name,
        ]);
        $merchantRole->givePermissionTo([
            'view products',
            'create products',
            'edit products',
            'delete products',
            'view orders',
            'create orders',
            'edit orders',
            'view categories',
            'view brands',
            'view coupons',
            'view reviews',
        ]);

        $userRole = Role::create([
            'name' => 'User',
            'guard_name' => $this->guard_name,
        ]);
        $userRole->givePermissionTo([
            'view products',
            'view orders',
            'create orders',
            'view categories',
            'view brands',
            'view coupons',
            'view reviews',
            'create reviews',
        ]);

        $admin = Admin::where('email', 'admin@admin.com')->first();
        if ($admin) {
            $admin->assignRole($adminRole);
        }
        $merchant = Admin::where('email', 'merchant@merchant.com')->first();
        if ($merchant) {
            $merchant->assignRole($merchantRole);
        }
        $user = Admin::where('email', 'john@example.com')->first();

        if ($user) {
            $user->assignRole($userRole);
        }
    }
}
