<?php

use Illuminate\Database\Seeder;

class PartnerStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('partners_status')->delete();

        \DB::table('partners_status')->insert([
            [
                'name' => 'pending',
            ],
            [
                'name' => 'accepted',
            ],
            [
                'name' => 'declined',
            ],
            [
                'name' => 'blocked',
            ],
        ]);
    }
}
