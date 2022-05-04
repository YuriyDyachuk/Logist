<?php

use Illuminate\Database\Seeder;

class ExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    \DB::table('expenses')->delete();

	    \DB::table('expenses')->insert([
			    [
				    'slug' => 'fuel',
				    'description' => 'Топливо'
			    ],
			    [
				    'slug' => 'parking',
				    'description' => 'Стоянка'
			    ],
			    [
				    'slug' => 'parts',
				    'description' => 'Запчасти'
			    ],
			    [
				    'slug' => 'other',
				    'description' => 'Другое'
			    ],
		    ]);
    }
}
