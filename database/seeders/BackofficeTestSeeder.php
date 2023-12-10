<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class BackofficeTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['userId' => Uuid::uuid4(), 'fullName' => 'John', 'email' => 'john@test.loc', 'merchantId' => ''],
            ['userId' => Uuid::uuid4(), 'fullName' => 'Frank', 'email' => 'frank@test.loc', 'merchantId' => ''],
        ];

        DB::table('users')->insert($users);

        $merchants = [
            ['merchantId' => 'mid123', 'name' => 'Merchant 1'],
            ['merchantId' => 'mid456', 'name' => 'Merchant 2'],
        ];

        DB::table('merchants')->insert($merchants);

        DB::table('accounts')->insert([
            ['accountId' => Uuid::uuid4(), 'userId' => $users[0]['userId'], 'balance' => 1000],
            ['accountId' => Uuid::uuid4(), 'userId' => $users[1]['userId'], 'balance' => 1000],
        ]);

        DB::table('payments')->insert([
            [
                'paymentId' => Uuid::uuid4(),
                'userId' => $users[0]['userId'],
                'merchantId' => $merchants[0]['merchantId'],
                'amount' => 10,
                'created_at' => Carbon::now()->subDay(),
            ],
            [
                'paymentId' => Uuid::uuid4(),
                'userId' => $users[0]['userId'],
                'merchantId' => $merchants[1]['merchantId'],
                'amount' => 20,
                'created_at' => Carbon::now()->subDays(2),
            ],[
                'paymentId' => Uuid::uuid4(),
                'userId' => $users[0]['userId'],
                'merchantId' => $merchants[1]['merchantId'],
                'amount' => 30,
                'created_at' => Carbon::now()->subDay(),
            ],[
                'paymentId' => Uuid::uuid4(),
                'userId' => $users[1]['userId'],
                'merchantId' => $merchants[1]['merchantId'],
                'amount' => 40,
                'created_at' => Carbon::now()->subDays(2),
            ],
        ]);
    }
}
