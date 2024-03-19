<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'View Users'],
            ['name' => 'Create Users'],
            ['name' => 'Update Users'],
            ['name' => 'Delete Users'],
            ['name' => 'View Products'],
            ['name' => 'Create Products'],
            ['name' => 'Update Products'],
            ['name' => 'Delete Products'],
            ['name' => 'View Categories'],
            ['name' => 'Create Categories'],
            ['name' => 'Update Categories'],
            ['name' => 'Delete Categories'],
        ];

        foreach ($permissions as $permissionData) {
            Permission::firstOrCreate(['name' => $permissionData['name']]);
        }
    }
}
