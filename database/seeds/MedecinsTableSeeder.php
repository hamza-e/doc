<?php

use Illuminate\Database\Seeder;
use App\Medecin;
use \carbon\carbon;

class MedecinsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $medecins = [
            [
	            'nom' => 'Abdul',
	            'prenom' => 'Weissnat',
	            'sexe' => 'Homme',
	            'image' => 'img/medecins/images01.jpg',
	            'adresse' => 'guiliz marrakech',
	            'bio' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
	            'telephone' => '+21252443313',
	            'langues' => 'arabe',
	            'city' => 'marrakech',
	            'tarif_de' => '200',
	            'tarif_a' => '1000',
	            'user_id' => '2',
	            'specialite_id' => '1',
	            'created_at' => carbon::now(),
	            'updated_at' => carbon::now(),
	        ],[
	            'nom' => 'mohammed',
	            'prenom' => 'hajouji',
	            'sexe' => 'Homme',
	            'image' => 'img/medecins/images01.jpg',
	            'adresse' => 'guiliz marrakech',
	            'bio' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
	            'telephone' => '+21252443313',
	            'langues' => 'arabe',
	            'city' => 'marrakech',
	            'tarif_de' => '100',
	            'tarif_a' => '1000',
	            'user_id' => '3',
	            'specialite_id' => '1',
	            'created_at' => carbon::now(),
	            'updated_at' => carbon::now(),
	        ],[
	            'nom' => 'sanae',
	            'prenom' => 'safawi',
	            'sexe' => 'Femme',
	            'image' => 'img/medecins/images01.jpg',
	            'adresse' => 'guiliz marrakech',
	            'bio' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
	            'telephone' => '+21252443313',
	            'langues' => 'francais',
	            'city' => 'marrakech',
	            'tarif_de' => '200',
	            'tarif_a' => '1000',
	            'user_id' => '4',
	            'specialite_id' => '2',
	            'created_at' => carbon::now(),
	            'updated_at' => carbon::now(),
	        ],[
	            'nom' => 'amine',
	            'prenom' => 'taji',
	            'sexe' => 'Homme',
	            'image' => 'img/medecins/images01.jpg',
	            'adresse' => 'guiliz marrakech',
	            'bio' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
	            'telephone' => '+21252443313',
	            'langues' => 'francais',
	            'city' => 'marrakech',
	            'tarif_de' => '400',
	            'tarif_a' => '1000',
	            'user_id' => '5',
	            'specialite_id' => '3',
	            'created_at' => carbon::now(),
	            'updated_at' => carbon::now(),
	        ]
        ];

        Medecin::insert($medecins);
    }
}
