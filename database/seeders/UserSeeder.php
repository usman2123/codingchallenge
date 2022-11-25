<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Superadmin
        User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@admin.com',
            'password' => Hash::make('123456'),
            'email_verified_at' => Carbon::now()
        ]);

        $users = User::factory()->count(50)->create();
    }
}
