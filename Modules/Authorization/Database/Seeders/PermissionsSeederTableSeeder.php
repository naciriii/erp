<?php

namespace Modules\Authorization\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Permission;

class PermissionsSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        $perms = [];
        for($i=0; $i<=45; $i++) {
            $perms []= ['name' => 'permission_'.$i,'guard_name' => 'web'];
        }
        Permission::insert($perms);
    }
}
