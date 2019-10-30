<?php

use Illuminate\Database\Seeder;

class RelationshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('relationships')->delete();

        $relationships = [
            [
                'id'                     => 1,
                'name'                   => 'Direct Report',
                'active'                 => 1,
                'is_manual'              => 0,
                'integration_order'      => 0,
                'master_relationship_id' => 0,
                'created_at'             => new DateTime(),
                'updated_at'             => new DateTime(),
                'deleted_at'             => null,
            ],
            [
                'id'                     => 2,
                'name'                   => 'Peer',
                'active'                 => 1,
                'is_manual'              => 0,
                'integration_order'      => 0,
                'master_relationship_id' => 0,
                'created_at'             => new DateTime(),
                'updated_at'             => new DateTime(),
                'deleted_at'             => null,
            ],
            [
                'id'                     => 3,
                'name'                   => 'Supervisor',
                'active'                 => 1,
                'is_manual'              => 0,
                'integration_order'      => 0,
                'master_relationship_id' => 0,
                'created_at'             => new DateTime(),
                'updated_at'             => new DateTime(),
                'deleted_at'             => null,
            ],
        ];

        DB::table('relationships')->insert($relationships);
    }
}
