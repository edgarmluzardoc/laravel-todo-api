<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Constants for this seeder
     */
    const DEFAULT_USERS_SEEDS = 5;
    const DEFAULT_USERS_PASSWORD = '123456';
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creating Users
        for ($userNumber = 1; $userNumber <= self::DEFAULT_USERS_SEEDS; $userNumber++) {
            $user = new User([
                'email' => "user$userNumber@example.com",
                'password' => Hash::make(self::DEFAULT_USERS_PASSWORD)
            ]);
            $user->save();
        }
    }
}
