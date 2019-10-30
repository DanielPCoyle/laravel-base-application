<?php

use Illuminate\Database\Seeder;

class RelationshipBehaviorPivotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //     DB::table('relationship_behaviors')->delete();

    //     $relationship_behaviors = array(
    //         array(
    //             'id'              => 1,
    //             'relationship_id' => 1,
    //             'behavior_id'     => 1,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 2,
    //             'relationship_id' => 2,
    //             'behavior_id'     => 1,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 3,
    //             'relationship_id' => 3,
    //             'behavior_id'     => 1,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 4,
    //             'relationship_id' => 1,
    //             'behavior_id'     => 10,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 5,
    //             'relationship_id' => 2,
    //             'behavior_id'     => 9,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 6,
    //             'relationship_id' => 3,
    //             'behavior_id'     => 9,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 7,
    //             'relationship_id' => 2,
    //             'behavior_id'     => 8,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 8,
    //             'relationship_id' => 3,
    //             'behavior_id'     => 8,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 9,
    //             'relationship_id' => 2,
    //             'behavior_id'     => 7,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 10,
    //             'relationship_id' => 3,
    //             'behavior_id'     => 7,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 11,
    //             'relationship_id' => 1,
    //             'behavior_id'     => 6,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 12,
    //             'relationship_id' => 1,
    //             'behavior_id'     => 5,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 13,
    //             'relationship_id' => 3,
    //             'behavior_id'     => 5,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 14,
    //             'relationship_id' => 2,
    //             'behavior_id'     => 5,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 15,
    //             'relationship_id' => 1,
    //             'behavior_id'     => 4,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 16,
    //             'relationship_id' => 2,
    //             'behavior_id'     => 4,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 17,
    //             'relationship_id' => 3,
    //             'behavior_id'     => 4,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 18,
    //             'relationship_id' => 1,
    //             'behavior_id'     => 3,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 19,
    //             'relationship_id' => 1,
    //             'behavior_id'     => 12,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 20,
    //             'relationship_id' => 2,
    //             'behavior_id'     => 2,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 21,
    //             'relationship_id' => 3,
    //             'behavior_id'     => 2,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 22,
    //             'relationship_id' => 2,
    //             'behavior_id'     => 11,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 23,
    //             'relationship_id' => 3,
    //             'behavior_id'     => 11,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 24,
    //             'relationship_id' => 1,
    //             'behavior_id'     => 13,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 25,
    //             'relationship_id' => 1,
    //             'behavior_id'     => 14,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 26,
    //             'relationship_id' => 2,
    //             'behavior_id'     => 15,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 27,
    //             'relationship_id' => 3,
    //             'behavior_id'     => 15,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         /*array(
    //             'id'              => 28,
    //             'relationship_id' => 1,
    //             'behavior_id'     => 6,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),*/
    //         array(
    //             'id'              => 29,
    //             'relationship_id' => 2,
    //             'behavior_id'     => 17,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 30,
    //             'relationship_id' => 3,
    //             'behavior_id'     => 17,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 31,
    //             'relationship_id' => 1,
    //             'behavior_id'     => 18,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 32,
    //             'relationship_id' => 2,
    //             'behavior_id'     => 19,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 33,
    //             'relationship_id' => 3,
    //             'behavior_id'     => 19,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 34,
    //             'relationship_id' => 2,
    //             'behavior_id'     => 20,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 35,
    //             'relationship_id' => 3,
    //             'behavior_id'     => 20,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 36,
    //             'relationship_id' => 1,
    //             'behavior_id'     => 21,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 37,
    //             'relationship_id' => 1,
    //             'behavior_id'     => 22,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 38,
    //             'relationship_id' => 1,
    //             'behavior_id'     => 23,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 39,
    //             'relationship_id' => 1,
    //             'behavior_id'     => 24,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 40,
    //             'relationship_id' => 2,
    //             'behavior_id'     => 25,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 41,
    //             'relationship_id' => 2,
    //             'behavior_id'     => 26,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 42,
    //             'relationship_id' => 2,
    //             'behavior_id'     => 27,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         ),
    //         array(
    //             'id'              => 43,
    //             'relationship_id' => 3,
    //             'behavior_id'     => 27,
    //             'created_at'      => new DateTime,
    //             'updated_at'      => new DateTime,
    //             'deleted_at'      => null
    //         )
    //     );

    //     DB::table('relationship_behaviors')->insert( $relationship_behaviors );
    }
}
