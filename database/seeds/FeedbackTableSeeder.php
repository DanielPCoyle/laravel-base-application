<?php

use Illuminate\Database\Seeder;

class FeedbackTableSeeder extends Seeder
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
        // Create feedback

        DB::table('feedback')->delete();

        $feedback = [
            [
                'id'                    => 1,
                'user_id'               => 3, // Cliff
                'recipient_id'          => 8, // Natalie
                'team_id'               => 1,
                'relationship_id'       => 3, // Supervisor
                'anonymous'             => 1,
                'status_id'             => 1,
                'assignee_id'           => 1,
                'is_rate'               => 1,
                'reference_type'        => 'direct', // or 'link'
                'reference_id'          => 1,
                'is_rated_id'           => 1,
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],

        ];

        DB::table('feedback')->insert($feedback);

        // Add to Feedback Data

        DB::table('feedback_data')->delete();

        $feedback_data = [
            [
                'id'                    => 1,
                'feedback_id'           => 1,
                'behavior_id'           => 6, // For "Develops my skills"
                'rating'                => 3,
                'text'                  => 'I think Natalie makes database seeds for development.',
                'drop_down_value'       => '', // not sure about what this should be
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],

        ];

        DB::table('feedback_data')->insert($feedback_data);
    }
}
