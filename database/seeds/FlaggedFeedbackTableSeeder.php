<?php

use Illuminate\Database\Seeder;

class FlaggedFeedbackTableSeeder extends Seeder
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
        // Create flagged feedback

        DB::table('flagged_feedback')->delete();

        $flagged_feedback = [
            [
                'id'                    => 1,
                'slack_user'            => 'natalie.miller', // Natalie
                'feedback_id'           => null,
                'entity_feedback_id'    => 1,
                'comments'              => 'This is great feedback, don\'t forget it!',
                'acknowledged'          => 0,
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],

        ];

        DB::table('flagged_feedback')->insert($flagged_feedback);
    }
}
