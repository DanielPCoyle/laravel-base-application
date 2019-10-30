<?php

use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teams')->delete();

        $teams = [
             [
                 'id'                => 1,
                 'parent_id'         => 0,
                 'name'              => 'Leadership Group',
                 'enrollment_style'  => 0,
                 'enrollment_code'   => 'join-leadership-group',
                 'active'            => 1,
                 'default'           => 1,
                 'created_at'        => new DateTime(),
                 'updated_at'        => new DateTime(),
                 'deleted_at'        => null,
             ], [
                'id'                => 2,
                'parent_id'         => 0,
                'name'              => 'Sales',
                'enrollment_style'  => 0,
                'enrollment_code'   => 'join-sales',
                'active'            => 1,
                'default'           => 1,
                'created_at'        => new DateTime(),
                'updated_at'        => new DateTime(),
                'deleted_at'        => null,
            ],
            [
                'id'                => 3,
                'parent_id'         => 0,
                'name'              => 'Marketing',
                'enrollment_style'  => 0,
                'enrollment_code'   => 'join-marketing',
                'active'            => 1,
                'default'           => 1,
                'created_at'        => new DateTime(),
                'updated_at'        => new DateTime(),
                'deleted_at'        => null,
            ],
            [
                'id'                => 4,
                'parent_id'         => 0,
                'name'              => 'Data',
                'enrollment_style'  => 0,
                'enrollment_code'   => 'join-data',
                'active'            => 1,
                'default'           => 1,
                'created_at'        => new DateTime(),
                'updated_at'        => new DateTime(),
                'deleted_at'        => null,
            ],
            [
                'id'                => 5,
                'parent_id'         => 0,
                'name'              => 'Product Development',
                'enrollment_style'  => 0,
                'enrollment_code'   => 'join-product-development',
                'active'            => 1,
                'default'           => 1,
                'created_at'        => new DateTime(),
                'updated_at'        => new DateTime(),
                'deleted_at'        => null,
            ], [
                'id'                => 6,
                'parent_id'         => 0,
                'name'              => 'Engineering',
                'enrollment_style'  => 0,
                'enrollment_code'   => 'join-engineering',
                'active'            => 1,
                'default'           => 1,
                'created_at'        => new DateTime(),
                'updated_at'        => new DateTime(),
                'deleted_at'        => null,
            ],
         ];

        DB::table('teams')->insert($teams);
    }
}
