<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
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
        DB::table('statuses')->delete();

        $statuses = [
            [
                'id'                    => 1,
                'value'                 => 'Open',
                'workflow_status'       => 'open',
                'user_id'               => 1,
                'badge_color'           => '#1ABC9C',
                'badge_text_color'      => '#ffffff',
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],
            [
                'id'                    => 2,
                'value'                 => 'In Progress',
                'workflow_status'       => 'in_progress',
                'user_id'               => 1,
                'badge_color'           => '#F7B84B',
                'badge_text_color'      => '#ffffff',
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],
            [
                'id'                    => 3,
                'value'                 => 'Closed',
                'workflow_status'       => 'closed',
                'user_id'               => 1,
                'badge_color'           => '#6C757D',
                'badge_text_color'      => '#ffffff',
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],

        ];

        DB::table('statuses')->insert($statuses);
    }
}
