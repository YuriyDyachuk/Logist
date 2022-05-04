<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert([

            /* Owner */
            ['id' => 1, 'name' => 'admin.profile'],
            ['id' => 2, 'name' => 'admin.add'],
            ['id' => 3, 'name' => 'company.edit'],
            ['id' => 21, 'name' => 'owner'],

            /* Admin */
            ['id' => 4, 'name' => 'staff.all'],
            ['id' => 5, 'name' => 'staff.crud'],
            ['id' => 6, 'name' => 'staff.crud'],
            ['id' => 7, 'name' => 'staff.position'],
            ['id' => 8, 'name' => 'staff.logout'],
            ['id' => 9, 'name' => 'staff.department.create'],
            ['id' => 10, 'name'     => 'staff.department.edit'],
            ['id' => 11, 'name'     => 'staff.access'],


            /* Manager */
            ['id' => 12, 'name' => 'personal.edit'],
            ['id' => 13, 'name' => 'staff.structure'],

            /* Top Manager */

            /* Logist */
            ['id' => 14, 'name' => 'profile.my'],
            ['id' => 15, 'name' => 'orders.all'],
            ['id' => 16, 'name' => 'clients.all'],
            ['id' => 17, 'name' => 'transport.all'],
            ['id' => 18, 'name' => 'locations.all'],
            ['id' => 19, 'name' => 'analytic.all'],
            ['id' => 20, 'name' => 'company.my'],
            /* Driver */
        ]);
        
        
    }
}