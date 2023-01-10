<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateClientUserSeeder extends Seeder
{
    /**
     * Запустить начальные данные базы данных.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::findOrCreate('Client');

        $permissions = Permission::where('name', '=', 'task-create')->pluck('id', 'id')->all();

        $role->syncPermissions($permissions);
    }

}
