<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Request as RequestModel;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // add dummy request for superadmin

        //accepted
        for ($i=2; $i <= 10; $i++) { 
            $data[] = [
                'from_user_id' => $i,
                'to_user_id' => 1,
                'status' => 'accepted',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        //received
        for ($i=11; $i <= 30; $i++) { 
            $data[] = [
                'from_user_id' => $i,
                'to_user_id' => 1,
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        //sent
        for ($i=31; $i <= 40; $i++) { 
            $data[] = [
                'from_user_id' => 1,
                'to_user_id' => $i,
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        RequestModel::insert($data);
    }
}
