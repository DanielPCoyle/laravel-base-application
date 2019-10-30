<?php

use Illuminate\Database\Seeder;

class CompetenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('behavior_competencies')->delete();
        DB::table('competencies')->delete();

        $competencies = [
            [
                'id'          => 1,
                'name'        => 'Accountability',
                'proficiency' => 75,
                'is_rate'     => 0,
                'created_at'  => new DateTime(),
                'updated_at'  => new DateTime(),
                'deleted_at'  => null,
            ],
            [
                'id'          => 2,
                'name'        => 'Change Agent',
                'proficiency' => 75,
                'is_rate'     => 0,
                'created_at'  => new DateTime(),
                'updated_at'  => new DateTime(),
                'deleted_at'  => null,
            ],
            [
                'id'          => 3,
                'name'        => 'Change Leader',
                'proficiency' => 75,
                'is_rate'     => 0,
                'created_at'  => new DateTime(),
                'updated_at'  => new DateTime(),
                'deleted_at'  => null,
            ],
            [
                'id'          => 4,
                'name'        => 'Emotional Intelligence',
                'proficiency' => 75,
                'is_rate'     => 0,
                'created_at'  => new DateTime(),
                'updated_at'  => new DateTime(),
                'deleted_at'  => null,
            ],
            [
                'id'          => 5,
                'name'        => 'Foundational Leader',
                'proficiency' => 75,
                'is_rate'     => 0,
                'created_at'  => new DateTime(),
                'updated_at'  => new DateTime(),
                'deleted_at'  => null,
            ],
            [
                'id'          => 6,
                'name'        => 'High Performance Conflict',
                'proficiency' => 75,
                'is_rate'     => 0,
                'created_at'  => new DateTime(),
                'updated_at'  => new DateTime(),
                'deleted_at'  => null,
            ],
            [
                'id'          => 7,
                'name'        => 'Listening Skills',
                'proficiency' => 75,
                'is_rate'     => 0,
                'created_at'  => new DateTime(),
                'updated_at'  => new DateTime(),
                'deleted_at'  => null,
            ],
            [
                'id'          => 8,
                'name'        => 'Performance Manager',
                'proficiency' => 75,
                'is_rate'     => 0,
                'created_at'  => new DateTime(),
                'updated_at'  => new DateTime(),
                'deleted_at'  => null,
            ],
            [
                'id'          => 9,
                'name'        => 'Talent Developer',
                'proficiency' => 75,
                'is_rate'     => 0,
                'created_at'  => new DateTime(),
                'updated_at'  => new DateTime(),
                'deleted_at'  => null,
            ],
            [
                'id'          => 10,
                'name'        => 'Top Performer',
                'proficiency' => 75,
                'is_rate'     => 0,
                'created_at'  => new DateTime(),
                'updated_at'  => new DateTime(),
                'deleted_at'  => null,
            ],
            [
                'id'          => 11,
                'name'        => 'Trust',
                'proficiency' => 75,
                'is_rate'     => 0,
                'created_at'  => new DateTime(),
                'updated_at'  => new DateTime(),
                'deleted_at'  => null,
            ],
        ];

        DB::table('competencies')->insert($competencies);
    }
}
