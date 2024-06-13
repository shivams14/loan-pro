<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('users')->insert([
			'name'          => 'Admin',
			'user_role'     => UserRole::SUPERADMIN,
            'email'         => 'proAdmin@yopmail.com',
            'password'      => bcrypt('admin@123#'),
			'active_status' => Status::ENABLE,
        ]);
    }
}
