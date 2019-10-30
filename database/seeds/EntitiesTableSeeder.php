<?php

use Illuminate\Database\Seeder;

class EntitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws
     *
     * @return void
     */
    public function run()
    {
        DB::table('entities')->delete();

        $entities = [
            [
                'id'                    => 1,
                'parent_id'             => 0,
                'name'                  => 'Sales',
                'description'           => 'The process of our company\'s sales',
                'active'                => 1,
                'visibility'            => 'public',
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],
            [
                'id'                    => 2,
                'parent_id'             => 0,
                'name'                  => 'Continuous Pilot Feedback',
                'description'           => 'A test entity to run test queries',
                'active'                => 1,
                'visibility'            => 'public',
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],

        ];

        DB::table('entities')->insert($entities);
    }
}
