<?php

namespace Database\Seeders;

use App\Models\Franchisee;
use Illuminate\Database\Seeder;

class RoleFranchiseeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Franchisee::findOrFail(1)->roles()->sync(2);
    }
}
