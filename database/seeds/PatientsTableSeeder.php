<?php

use Illuminate\Database\Seeder;
use App\Patient;
use \carbon\carbon;

class PatientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	$patients = [
       		[
       			'nom' 		=>	'Mark',
       			'prenom'	=>	'Jason',
       			'telephone'	=>	'0032423402340',
       			'sexe'		=>	'Homme',
       			'age'		=>	'34',
       			'created_at' => carbon::now(),
	            'updated_at' => carbon::now(),
       		],[
       			'nom' 		=>	'Sam',
       			'prenom'	=>	'Smith',
       			'telephone'	=>	'0032423402340',
       			'sexe'		=>	'Homme',
       			'age'		=>	'36',
       			'created_at' => carbon::now(),
	            'updated_at' => carbon::now(),
       		],[
       			'nom' 		=>	'Carmen',
       			'prenom'	=>	'Sue',
       			'telephone'	=>	'0023424323',
       			'sexe'		=>	'Homme',
       			'age'		=>	'50',
       			'created_at' => carbon::now(),
	            'updated_at' => carbon::now(),
       		],
       		[
       			'nom' 		=>	'Omar',
       			'prenom'	=>	'Simo',
       			'telephone'	=>	'0021223402340',
       			'sexe'		=>	'Homme',
       			'age'		=>	'44',
       			'created_at' => carbon::now(),
	            'updated_at' => carbon::now(),
       		]
       	];

       	Patient::insert($patients);
    }
}
