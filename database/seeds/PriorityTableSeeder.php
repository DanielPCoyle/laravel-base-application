<?php

use Illuminate\Database\Seeder;

class PriorityTableSeeder extends Seeder
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
        DB::table('priorities')->delete();

        $priorities = [
            [
                'id'                    => 1,
                'value'                 => 'High',
                'weight'                => 3,
                'user_id'               => 1,
                'badge_color'           => '#FCD5DB',
                'badge_text_color'      => '#F1556C',
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],
            [
                'id'                    => 2,
                'value'                 => 'Medium',
                'weight'                => 2,
                'user_id'               => 1,
                'badge_color'           => '#FDEDD3',
                'badge_text_color'      => '#F7B84B',
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],
            [
                'id'                    => 3,
                'value'                 => 'Low',
                'weight'                => 1,
                'user_id'               => 1,
                'badge_color'           => '#DADCDE',
                'badge_text_color'      => '#6C757D',
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],

        ];

        DB::table('priorities')->insert($priorities);
    }
}
