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

        // Super Admin
        $superAdmin = new User;
        $superAdmin->name = 'Super Admin';
        $superAdmin->email = 'superadmin@gmail.com';
        $superAdmin->is_admin = true;
        $superAdmin->super_admin = true;
        $superAdmin->password = bcrypt('123456');
        $superAdmin->avatar = null;
        $superAdmin->save();

        // Admin thường
        $admin = new User;
        $admin->name = 'Admin';
        $admin->email = 'admin@gmail.com';
        $admin->is_admin = true;
        $admin->super_admin = false;
        $admin->password = bcrypt('123456');
        $admin->avatar = null;
        $admin->save();
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Người dùng thường
        $user = new User;
        $user->name = 'User';
        $user->email = 'user@gmail.com';
        $user->is_admin = false;
        $user->super_admin = false;
        $user->password = bcrypt('123456');
        $user->avatar = null;
        $user->save();

        $this->call([
            ThanhPhoSeeder::class,
            QuanHuyenSeeder::class,
            PhuongXaSeeder::class,
            DanhMucSeeder::class,
            SanPhamSeeder::class,   
            CarouselImagesSeeder::class,
            // ImportDiaChiSeeder::class,
        ]);
    }
}
