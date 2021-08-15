<?php

namespace Database\Seeders;

use App\Models\HelpCenter;
use Illuminate\Database\Seeder;

class HelpCenterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $admins = [
            [
                'id'                 => 1,
                'name'               => 'Creatrix Help Center',
                'email'              => 'helpcenter@krishakvikas.com',
                'password'           => bcrypt('password'),
                'remember_token'     => null,
                'approved'           => 1,
                'verified'           => 1,
                'verified_at'        => '2021-01-26 15:07:08',
                'verification_token' => '',
                'mobile'             => '',
            ],
        ];

        HelpCenter::insert($admins);
    }
}
