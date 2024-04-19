<?php

namespace Database\Seeders;

use App\{Models\Permission, Models\Role};
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::firstOrCreate(['name' => 'permission.view'],['name' => 'permission.view']);
        Permission::firstOrCreate(['name' => 'permission.create'],['name' => 'permission.create']);
        Permission::firstOrCreate(['name' => 'permission.edit'],['name' => 'permission.edit']);
        Permission::firstOrCreate(['name' => 'permission.delete'],['name' => 'permission.delete']);

        Permission::firstOrCreate(['name' => 'role.view'],['name' => 'role.view']);
        Permission::firstOrCreate(['name' => 'role.create'],['name' => 'role.create']);
        Permission::firstOrCreate(['name' => 'role.edit'],['name' => 'role.edit']);
        Permission::firstOrCreate(['name' => 'role.delete'],['name' => 'role.delete']);

        Permission::firstOrCreate(['name' => 'user.view'],['name' => 'user.view']);
        Permission::firstOrCreate(['name' => 'user.create'],['name' => 'user.create']);
        Permission::firstOrCreate(['name' => 'user.edit'],['name' => 'user.edit']);
        Permission::firstOrCreate(['name' => 'user.delete'],['name' => 'user.delete']);

        Permission::firstOrCreate(['name' => 'language.view'],['name' => 'language.view']);
        Permission::firstOrCreate(['name' => 'language.create'],['name' => 'language.create']);
        Permission::firstOrCreate(['name' => 'language.edit'],['name' => 'language.edit']);
        Permission::firstOrCreate(['name' => 'language.delete'],['name' => 'language.delete']);

        Permission::firstOrCreate(['name' => 'category.view'],['name' => 'category.view']);
        Permission::firstOrCreate(['name' => 'category.create'],['name' => 'category.create']);
        Permission::firstOrCreate(['name' => 'category.edit'],['name' => 'category.edit']);
        Permission::firstOrCreate(['name' => 'category.delete'],['name' => 'category.delete']);

        Permission::firstOrCreate(['name' => 'product.view'],['name' => 'product.view']);
        Permission::firstOrCreate(['name' => 'product.create'],['name' => 'product.create']);
        Permission::firstOrCreate(['name' => 'product.edit'],['name' => 'product.edit']);
        Permission::firstOrCreate(['name' => 'product.delete'],['name' => 'product.delete']);

        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['name' => 'admin']
        );

        $adminRole->givePermissionTo([
            'permission.view',
            'permission.create',
            'permission.edit',
            'permission.delete',
            'role.view',
            'role.create',
            'role.edit',
            'role.delete',
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',
            'language.view',
            'language.create',
            'language.edit',
            'language.delete',
            'category.view',
            'category.create',
            'category.edit',
            'category.delete',
            'product.view',
            'product.create',
            'product.edit',
            'product.delete',
        ]);
    }
}
