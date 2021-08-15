<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendors = [
            [
                'id'                 => 1,
                'name'               => 'Demo Vendor',
                'email'              => 'vendor@krishakvikas.com',
                'password'           => bcrypt('password'),
                'remember_token'     => null,
                'approved'           => 1,
                'verified'           => 1,
                'verified_at'        => '2021-01-26 15:07:08',
                'verification_token' => '',
                'mobile'             => '',
            ],
        ];

        Vendor::insert($vendors);
    }
}
