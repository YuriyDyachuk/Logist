<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;


class RoleModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('role_modules')->truncate();

        $roles_id = [
            'logistic'  => 1,
            'client'    => 2,
            'driver'    => 3,
            'logist'    => 4,
        ];

        $modules_ids = [
            'analytics' => 1,
            'clients'   => 2,
            'documents' => 3,
            'profile'   => 4,
            'finance'   => 5,
            'location'  => 6,
            'orders'    => 7,
            'requests'  => 8,
            'transport' => 9,
            'settings'  => 10,
            'pay'       => 11
        ];

        $data = [
            'analytics' => [
                'logistic' =>   ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
                'client' =>     ['c'=>0, 'r'=>0, 'u'=>0, 'd'=>0],
                'driver' =>     [],
                'logist' =>     ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
            ],
            'clients' => [
                'logistic' =>   ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
                'client' =>     [],
                'driver' =>     [],
                'logist' =>     ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
            ],
            'documents' => [
                'logistic' =>   ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
                'client' =>     ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
                'driver' =>     [],
                'logist' =>     ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
            ],
            'profile' => [
                'logistic' =>   ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
                'client' =>     [],
                'driver' =>     [],
                'logist' =>     ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
            ],
            'finance' => [
                'logistic' =>   ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
                'client' =>     [],
                'driver' =>     [],
                'logist' =>     ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
            ],
            'location' => [
                'logistic' =>   ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
                'client' =>     ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
                'driver' =>     [],
                'logist' =>     ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
            ],
            'orders' => [
                'logistic' =>   ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
                'client' =>     ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
                'driver' =>     [],
                'logist' =>     ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
            ],
            'requests' => [
                'logistic' =>   ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
                'client' =>     [],
                'driver' =>     [],
                'logist' =>     ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
            ],
            'transport' => [
                'logistic' =>   ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
                'client' =>     [],
                'driver' =>     [],
                'logist' =>     ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
            ],
            'settings' => [
                'logistic' =>   ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
                'client' =>     ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
                'driver' =>     [],
                'logist' =>     ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
            ],
            'pay' => [
                'logistic' =>   ['c'=>1, 'r'=>1, 'u'=>1, 'd'=>1],
                'client' =>     [],
                'driver' =>     [],
                'logist' =>     [],
            ],
        ];

        $id = 1;
        foreach ($data as $name=>$item){
            foreach ($item as $name2 => $item2){
                if(!empty($item2)){
                    $this->insert_data($roles_id[$name2], $modules_ids[$name], $item2['c'], $item2['r'], $item2['u'], $item2['d']);
                }
                else {
                    $this->insert_data($roles_id[$name2], $modules_ids[$name]);
                }
            }
            $id++;
        }
    }

    private function insert_data($role_id, $module_id, $c=0, $r=0, $u=0, $d=0){
        $now = Carbon::now();
        \DB::table('role_modules')->insert([
            'role_id' => $role_id,
            'module_id' => $module_id,
            'create' => $c,
            'read' => $r,
            'update' => $u,
            'delete' => $d,
            'created_at' => $now,
            'updated_at' => $now,

        ]);
    }
}
