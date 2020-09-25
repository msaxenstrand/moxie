<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Ronny Siggelin',
            'email' => 'ronny.siggelin@moxietech.se',
            'password' => bcrypt('SecretPassword')
        ]);
    }
}
