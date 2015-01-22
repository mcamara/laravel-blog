<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        if ( getenv("APP_ENV") !== 'local' )
            exit( 'I just stopped you wiping the database' );

        Model::unguard();

        $tables = [
            'users'
        ];

        foreach ( $tables as $table )
        {
            DB::table($table)->truncate();
        }

        $this->call('UserTableSeeder');
    }

}
