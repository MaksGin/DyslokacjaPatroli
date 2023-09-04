<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'product-2',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'permission-create',
            'permission-delete',
            'patrol-create',
            'patrol-edit',
            'wydzial-list',
            'wydzial-delete',
            'wydzial-add',
            'all-patrols-list',
            'sklad-create',
             'sklad-edit',
             'sklad-delete'
         ];

        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
