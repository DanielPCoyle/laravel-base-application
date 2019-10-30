<?php

use Illuminate\Database\Seeder;

class BehaviorCompetencyPivotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('behavior_competencies')->delete();

        $behavior_competencies = [
            [
                'id'            => 1,
                'behavior_id'   => 1,
                'competency_id' => 4,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 2,
                'behavior_id'   => 2,
                'competency_id' => 11,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 3,
                'behavior_id'   => 3,
                'competency_id' => 9,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 4,
                'behavior_id'   => 4,
                'competency_id' => 4,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 5,
                'behavior_id'   => 5,
                'competency_id' => 7,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 6,
                'behavior_id'   => 6,
                'competency_id' => 9,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 7,
                'behavior_id'   => 7,
                'competency_id' => 10,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 8,
                'behavior_id'   => 8,
                'competency_id' => 1,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 9,
                'behavior_id'   => 9,
                'competency_id' => 10,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 10,
                'behavior_id'   => 10,
                'competency_id' => 6,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 11,
                'behavior_id'   => 11,
                'competency_id' => 6,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 12,
                'behavior_id'   => 12,
                'competency_id' => 8,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 13,
                'behavior_id'   => 13,
                'competency_id' => 5,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 14,
                'behavior_id'   => 14,
                'competency_id' => 5,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 15,
                'behavior_id'   => 15,
                'competency_id' => 10,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 16,
                'behavior_id'   => 16,
                'competency_id' => 5,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 17,
                'behavior_id'   => 17,
                'competency_id' => 2,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 18,
                'behavior_id'   => 18,
                'competency_id' => 3,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 19,
                'behavior_id'   => 19,
                'competency_id' => 6,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 20,
                'behavior_id'   => 20,
                'competency_id' => 6,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 21,
                'behavior_id'   => 21,
                'competency_id' => 6,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 22,
                'behavior_id'   => 22,
                'competency_id' => 9,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 23,
                'behavior_id'   => 23,
                'competency_id' => 3,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 24,
                'behavior_id'   => 24,
                'competency_id' => 8,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 25,
                'behavior_id'   => 25,
                'competency_id' => 10,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 26,
                'behavior_id'   => 26,
                'competency_id' => 10,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
            [
                'id'            => 27,
                'behavior_id'   => 27,
                'competency_id' => 6,
                'created_at'    => new DateTime(),
                'updated_at'    => new DateTime(),
                'deleted_at'    => null,
            ],
        ];

        DB::table('behavior_competencies')->insert($behavior_competencies);
    }
}
