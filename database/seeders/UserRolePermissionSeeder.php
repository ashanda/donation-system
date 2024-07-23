<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define all permissions
        $permissions = [
            'view role',
            'create role',
            'update role',
            'delete role',
            'restore role',

            'view permission',
            'create permission',
            'update permission',
            'delete permission',
            'restore permission',

            'view user',
            'create user',
            'update user',
            'delete user',
            'manage users',

            'view product',
            'create product',
            'update product',
            'delete product',
            'restore product',

            'view inventory item',
            'add inventory',
            'edit / update inventory items',
            'delete inventory item',
            'restore inventory iteams',
            'manage inventory',

            'create donate',
            'update donate',
            'delete donate',
            'edit / update donation items',
            'delete donation items',
            'create donation',

            'create issue',
            'update issue',
            'delete issue',
            'create good issue',
            'edit / update good issue',
            'delete good issue',

            'manage donators',
            'manage issuers',
            'manage products',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $donatorRole = Role::firstOrCreate(['name' => 'donator']);
        $issuerRole = Role::firstOrCreate(['name' => 'issuer']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assign all permissions to super-admin role
        $superAdminRole->syncPermissions(Permission::all());

        // Assign specific permissions to admin role
        $adminRole->syncPermissions([
            'create role', 'view role', 'update role',
            'create permission', 'view permission',
            'create user', 'view user', 'update user',
            'create product', 'view product', 'update product'
        ]);

        // Create users and assign roles
        $superAdminUser = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('12345678'),
            ]
        );
        $superAdminUser->assignRole($superAdminRole);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
            ]
        );
        $adminUser->assignRole($adminRole);

        $donatorUser = User::firstOrCreate(
            ['email' => 'donator@gmail.com'],
            [
                'name' => 'Donator',
                'password' => Hash::make('12345678'),
            ]
        );
        $donatorUser->assignRole($donatorRole);

        $issuerUser = User::firstOrCreate(
            ['email' => 'issuer@gmail.com'],
            [
                'name' => 'Issuer',
                'password' => Hash::make('12345678'),
            ]
        );
        $issuerUser->assignRole($issuerRole);
    }
}
