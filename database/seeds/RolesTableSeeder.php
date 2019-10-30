<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        $roles = [
            [
                'id'            => 1,
                'name'          => 'owner',
                'friendly_name' => 'Owner',
                'type'          => 'entity',
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
            ],
            [
                'id'            => 2,
                'name'          => 'admin',
                'friendly_name' => 'Admin',
                'type'          => 'entity',
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
            ],
            [
                'id'            => 3,
                'name'          => 'member',
                'friendly_name' => 'Member',
                'type'          => 'entity',
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
            ],
            [
                'id'            => 4,
                'name'          => 'owner',
                'friendly_name' => 'Owner',
                'type'          => 'team',
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
            ],
            [
                'id'            => 5,
                'name'          => 'admin',
                'friendly_name' => 'Admin',
                'type'          => 'team',
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
            ],
            [
                'id'            => 6,
                'name'          => 'member',
                'friendly_name' => 'Member',
                'type'          => 'team',
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
            ],
            [
                'id'            => 7,
                'name'          => 'admin',
                'friendly_name' => 'Admin',
                'type'          => 'system',
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
            ],
            [
                'id'            => 8,
                'name'          => 'manager',
                'friendly_name' => 'Manager',
                'type'          => 'system',
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
            ],
        ];

        DB::table('roles')->insert($roles);
    }
}
