<?php

use Illuminate\Database\Seeder;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
             'admin',
             'user'
        ];

        foreach($roles as $name) {
            $r_obj = new \App\UserRole();
            $r_obj->name = $name;
            $r_obj->save();
        }
    }
}
