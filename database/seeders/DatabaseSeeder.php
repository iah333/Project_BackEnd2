<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $user = new User;
        $user->name ='Admin';
        $user->email = 'admin@gmail.com';
        $user->is_admin = true;
        $user->password = bcrypt('123456');
        $user->phone = null;
        $user->address = null;
        $user->picture = null;
        $user->save();

        // $user = new User;
        // $user->name ='User';
        // $user->email = 'user@gmail.com';
        // $user->is_admin = false;
        // $user->password = bcrypt('123456');
        // $user->save();
    }
}
