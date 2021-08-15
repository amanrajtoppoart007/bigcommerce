<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class RoleAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Admin::findOrFail(1)->roles()->sync(1);
         Admin::findOrFail(2)->roles()->sync(1);
    }
}
