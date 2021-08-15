<?php

namespace Database\Seeders;

use App\Models\Franchisee;
use Illuminate\Database\Seeder;

class FranchiseeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $franchisees = [
            [
                'id'                 => 1,
                'name'               => 'Franchisee',
                'email'              => 'franchisee@krishakvikas.com',
                'password'           => bcrypt('password'),
                'remember_token'     => null,
                'approved'           => 1,
                'verified'           => 1,
                'verified_at'        => '2021-01-26 15:07:08',
                'verification_token' => '',
                'mobile'             => '',
            ],
        ];

        Franchisee::insert($franchisees);
    }
}
