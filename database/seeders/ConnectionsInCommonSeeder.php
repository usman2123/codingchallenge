<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Request as RequestModel;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConnectionsInCommonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // add connections in common

        //accepted
        for ($i=6; $i <= 10; $i++) { 
            $data[] = [
                'from_user_id' => $i,
                'to_user_id' => 2,
                'status' => 'accepted',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        RequestModel::insert($data);
    }
}
