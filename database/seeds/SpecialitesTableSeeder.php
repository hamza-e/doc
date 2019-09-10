<?php

use Illuminate\Database\Seeder;
use App\Specialite;
use \carbon\carbon;

class SpecialitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$specialites = [
            [
	            'libelle' => 'Chirurgien-dentiste',
	            'created_at' => carbon::now(),
	            'updated_at' => carbon::now(),
	        ],[
	            'libelle' => 'Cardiologue',
	            'created_at' => carbon::now(),
	            'updated_at' => carbon::now(),
	        ],[
	            'libelle' => 'Dermatologue',
	            'created_at' => carbon::now(),
	            'updated_at' => carbon::now(),
	        ],[
	            'libelle' => 'Sage-femme',
	            'created_at' => carbon::now(),
	            'updated_at' => carbon::now(),
	        ],[
	            'libelle' => 'Ostéopathe',
	            'created_at' => carbon::now(),
	            'updated_at' => carbon::now(),
	        ]
        ];

        Specialite::insert($specialites);
    }
}
