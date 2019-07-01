<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $user   = new \App\User();
        $user->name = 'Admin';
        $user->email = 'admin@canwatch.com';
        $user->password = bcrypt('admin');
        $user->save();
    }
}
