<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $viewUsers = Permission::where('name', 'View Users')->first();
        $createUsers = Permission::where('name', 'Create Users')->first();
        $updateUsers = Permission::where('name', 'Update Users')->first();
        $deleteUsers = Permission::where('name', 'Delete Users')->first();
        $viewProducts = Permission::where('name', 'View Products')->first();
        $createProducts = Permission::where('name', 'Create Products')->first();
        $updateProducts = Permission::where('name', 'Update Products')->first();
        $deleteProducts = Permission::where('name', 'Delete Products')->first();
        $viewCategories = Permission::where('name', 'View Categories')->first();
        $createCategories = Permission::where('name', 'Create Categories')->first();
        $updateCategories = Permission::where('name', 'Update Categories')->first();
        $deleteCategories = Permission::where('name', 'Delete Categories')->first();

        // Retrieve roles
        $owner = Role::where('name', 'Owner')->first();
        $superAdmin = Role::where('name', 'Super-admin')->first();
        $admin = Role::where('name', 'Admin')->first();
        $supervisor = Role::where('name', 'Supervisor')->first();

        // Attach permissions to roles
        $owner->permissions()->attach([$viewUsers->id, $createUsers->id, $updateUsers->id, $deleteUsers->id, $viewProducts->id, $createProducts->id, $updateProducts->id, $deleteProducts->id, $viewCategories->id, $createCategories->id, $updateCategories->id, $deleteCategories->id]);
        $superAdmin->permissions()->attach([$viewUsers->id, $createUsers->id, $updateUsers->id, $deleteUsers->id, $viewProducts->id, $createProducts->id, $updateProducts->id, $deleteProducts->id, $viewCategories->id, $createCategories->id, $updateCategories->id, $deleteCategories->id]);
        $admin->permissions()->attach([$viewUsers->id, $createUsers->id, $updateUsers->id, $deleteUsers->id, $viewProducts->id, $createProducts->id, $updateProducts->id, $deleteProducts->id, $viewCategories->id, $createCategories->id, $updateCategories->id, $deleteCategories->id]);
        $supervisor->permissions()->attach([$viewProducts->id, $createProducts->id, $updateProducts->id, $deleteProducts->id, $viewCategories->id, $createCategories->id, $updateCategories->id, $deleteCategories->id]);
    }
}
