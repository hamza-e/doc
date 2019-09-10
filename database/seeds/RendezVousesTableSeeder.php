<?php

use Illuminate\Database\Seeder;
use App\RendezVous;
use \carbon\carbon;

class RendezVousesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     	$rendez_vous = [
     		[
     			'date' 		=>	"2018-12-03 10:00",
     			'traite'	=>	false,
     			'medecin_id'=>	1,
     			'patient_id'=>	1,
     			'created_at' => carbon::now(),
	            'updated_at' => carbon::now(),
     		],
     		[
     			'date' 		=>	"2018-12-03 10:30",
     			'traite'	=>	false,
     			'medecin_id'=>	1,
     			'patient_id'=>	2,
     			'created_at' => carbon::now(),
	            'updated_at' => carbon::now(),
     		],
     		[
     			'date' 		=>	"2018-12-03 14:00",
     			'traite'	=>	false,
     			'medecin_id'=>	1,
     			'patient_id'=>	4,
     			'created_at' => carbon::now(),
	            'updated_at' => carbon::now(),
     		],
     		[
     			'date' 		=>	"2018-12-03 15:00",
     			'traite'	=>	false,
     			'medecin_id'=>	2,
     			'patient_id'=>	3,
     			'created_at' => carbon::now(),
	            'updated_at' => carbon::now(),
     		],
            [
                'date'      =>  "2018-12-05 14:00",
                'traite'    =>  false,
                'medecin_id'=>  1,
                'patient_id'=>  4,
                'created_at' => carbon::now(),
                'updated_at' => carbon::now(),
            ],
            [
                'date'      =>  "2018-12-06 14:00",
                'traite'    =>  false,
                'medecin_id'=>  1,
                'patient_id'=>  4,
                'created_at' => carbon::now(),
                'updated_at' => carbon::now(),
            ],
     	];

     	RendezVous::insert($rendez_vous);
    }
}
