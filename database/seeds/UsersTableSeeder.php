<?php

use Illuminate\Database\Seeder;
use App\Typequestion;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt("admin12345"),
                'remember_token' => Str::random(10),
            ]
        );
    }
}
