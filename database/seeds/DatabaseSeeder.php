<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Make roles and permissions
	    Role::create(['name' => 'user']); // normal register user
	    Role::create(['name' => 'owner']); // owner club user
	    Role::create(['name' => 'manager']); // portal manager
	    Role::create(['name' => 'admin']); // admin with full permission

        //Start other seeders.
        $this->call([
            MusicTypesTableSeeder::class,
	        VoivodeshipsTableSeeder::class,
	        CitiesTableSeeder::class,
            UsersTableSeeder::class,
	        ClubsTableSeeder::class,
	        EventsTableSeeder::class,
	        UserSettingsSeeder::class
        ]);

    }
}
