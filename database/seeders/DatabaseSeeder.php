<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,

            UsersTableSeeder::class,
            AdminsTableSeeder::class,
            HelpCenterTableSeeder::class,
            VendorTableSeeder::class,
            LogisticsTableSeeder::class,
            FranchiseeTableSeeder::class,

            RoleAdminTableSeeder::class,
            RoleUserTableSeeder::class,
            RoleFranchiseeTableSeeder::class,
            RoleLogisticsTableSeeder::class,
            RoleVendorTableSeeder::class,
            RoleHelpCenterTableSeeder::class,

            StateDistrictTableSeeder::class
        ]);
    }
}
