<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Admin',
                'username' => 'admin',
                'password' => 'admin',
                'level' => 0,
                'status' => 1,
                'created_at' => '2020-09-18',
                'updated_at' => '2020-09-18',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Ina',
                'username' => 'prodi',
                'password' => 'prodi',
                'level' => 1,
                'status' => 1,
                'created_at' => '2020-09-18',
                'updated_at' => '2020-09-18',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Indra',
                'username' => '10515211',
                'password' => '10515211',
                'level' => 2,
                'status' => 1,
                'created_at' => '2020-09-18',
                'updated_at' => '2020-09-18',
            ),
        ));
        
        
    }
}