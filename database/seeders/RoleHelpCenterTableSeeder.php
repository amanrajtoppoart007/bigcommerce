<?php

namespace Database\Seeders;

use App\Models\HelpCenter;
use Illuminate\Database\Seeder;

class RoleHelpCenterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HelpCenter::findOrFail(1)->roles()->sync(3);
    }
}
