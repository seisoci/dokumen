<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user = User::create([
          'name' => 'Super Admin',
          'username' => 'admin',
          'email' => 'admin@gmail.com',
          'password' => bcrypt('sealonline'),
          'email_verified_at' => now(),
          'image' => NULL,
          'active' => 1,
          'remember_token' => Str::random(10)
      ]);

      $roles = [
          'admin',
          'employee',
      ];


      $role = Role::create(['name' => 'super-admin']);
      $permissions = Permission::pluck('id','id')->all();
      $role->syncPermissions($permissions);
      $user->assignRole([$role->id]);

      foreach ($roles as $item) {
        $role = Role::create(['name' => $item]);
      }
    }
}
