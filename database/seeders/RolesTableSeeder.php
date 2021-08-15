<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'title' => 'Admin',
            ],
             [
                'id'    => 2,
                'title' => 'Franchisee',
            ],
            [
                'id'    => 3,
                'title' => 'Help Center',
            ],
            [
                'id'    => 4,
                'title' => 'Vendor',
            ],
            [
                'id'    => 5,
                'title' => 'Logistics',
            ],
            [
                'id'    => 6,
                'title' => 'Moderator',
            ],
        ];

        Role::insert($roles);
    }
}
