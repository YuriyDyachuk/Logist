<?php

use App\Models\Module;
use App\Models\Role;
use App\Models\RoleModule;
use Illuminate\Database\Seeder;

class MailerPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $module = Module::create([
            'name' => 'mailer',
            'description' => 'Mailer'
        ]);

        $roles = ['logistic', 'client', 'logist', 'manager'];
        foreach ($roles as $roleName) {
            $role = Role::where('name', $roleName)->first();
            if (!$role) {
                continue;
            }

            RoleModule::create([
                'role_id'   => $role->id,
                'module_id' => $module->id,
                'create'    => 1,
                'read'      => 1,
                'update'    => 1,
                'delete'    => 1,
            ]);
        }
    }
}
