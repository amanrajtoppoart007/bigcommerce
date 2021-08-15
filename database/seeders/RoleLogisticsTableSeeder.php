<?php

namespace Database\Seeders;

use App\Models\Logistic;
use Illuminate\Database\Seeder;

class RoleLogisticsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Logistic::findOrFail(1)->roles()->sync(5);
    }
}
