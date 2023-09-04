<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         // \App\Models\User::factory(10)->create();
         $user = User::create([
        	'name' => 'Maksymilian Gintner',
        	'email' => 'maks@maks.com',
        	'password' => bcrypt('Haslo123')
        ]);
        $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        DB::table('model_has_roles')->insert(['role_id' => 1, 'model_type' => 'App\Models\User' ,'model_id' => 1]);
    }

}
