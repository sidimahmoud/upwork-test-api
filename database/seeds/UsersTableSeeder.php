<?php

use Illuminate\Database\Seeder;
use App\Modules\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class, 20)->create();
    }
}
