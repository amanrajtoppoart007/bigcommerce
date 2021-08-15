<?php

namespace Database\Seeders;

use App\Models\Logistic;
use Illuminate\Database\Seeder;

class LogisticsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $logistics = [
            [
                'id'                 => 1,
                'name'               => 'Logistics',
                'email'              => 'logistics@krishakvikas.com',
                'password'           => bcrypt('password'),
                'remember_token'     => null,
                'approved'           => 1,
                'verified'           => 1,
                'verified_at'        => '2021-01-26 15:07:08',
                'verification_token' => '',
                'mobile'             => '',
            ],
        ];

        Logistic::insert($logistics);
    }
}
