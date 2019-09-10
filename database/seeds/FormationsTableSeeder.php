<?php

use Illuminate\Database\Seeder;
use App\Formation;
use \carbon\carbon;

class FormationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formations = [
            [
	            'libelle' => 'DU Implantologie',
	            'datedebut' => '2012-12-12',
	            'datefin' => '2011-12-12',
	            'adresse' => 'Hôpital Cochin',
	            'medecin_id' => '2',
	            'created_at' => carbon::now(),
	            'updated_at' => carbon::now(),
	        ],[
	            'libelle' => 'Chirurgien dentiste',
	            'datedebut' => '2013-12-12',
	            'datefin' => '2015-12-12',
	            'adresse' => 'Université Paris Descartes - Paris V',
	            'medecin_id' => '2',
	            'created_at' => carbon::now(),
	            'updated_at' => carbon::now(),
	        ],[
	            'libelle' => 'DU Implantologie',
	            'datedebut' => '2013-12-12',
	            'datefin' => '2015-12-12',
	            'adresse' => 'Hôpital Cochin',
	            'medecin_id' => '3',
	            'created_at' => carbon::now(),
	            'updated_at' => carbon::now(),
	        ],[
	            'libelle' => 'DU Implantologie',
	            'datedebut' => '2013-12-12',
	            'datefin' => '2015-12-12',
	            'adresse' => 'Hôpital Cochin',
	            'medecin_id' => '4',
	            'created_at' => carbon::now(),
	            'updated_at' => carbon::now(),
	        ]
        ];

        Formation::insert($formations);
    }
}
