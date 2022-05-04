<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('modules')->truncate();

        $now = Carbon::now();

        $data = [
            ['analytics', 'Analytics', $now, $now],
            ['clients', 'clients', $now, $now],
            ['documents', 'documents', $now, $now],
            ['profile', 'profile', $now, $now],
            ['finance', 'finance', $now, $now],
            ['location', 'location', $now, $now],
            ['orders', 'orders', $now, $now],
            ['requests', 'requests', $now, $now],
            ['transport', 'transport', $now, $now],
            ['settings', 'settings', $now, $now],
            ['pay', 'pay', $now, $now],
            ['partners', 'partners', $now, $now],
        ];

        foreach ($data as $item){
            \DB::table('modules')->insert([
                'name' => $item[0],
                'description' => $item[1],
                'created_at' => $item[2],
                'updated_at' => $item[3],
            ]);
        }
    }
}
