<?php

use Illuminate\Database\Seeder;

class EntityFeedbackTableSeeder extends Seeder
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
        // Create entity feedback

        DB::table('entity_feedback')->delete();

        $yesterday = new DateTime();
        $yesterday->sub(new DateInterval('P1D'));

        $entity_feedback = [
            [
                'id'                    => 1,
                'user_id'               => 8, // Natalie
                'entity_id'             => 1, // 'Sales'
                'anonymous'             => 1,
                'status_id'             => 1,
                'assignee_id'           => 1,
                'priority_id'           => 1,
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],
            [
                'id'                    => 2,
                'user_id'               => 8, // Natalie
                'entity_id'             => 2, // 'Continuous Pilot Feedback'
                'anonymous'             => 2,
                'status_id'             => 1,
                'assignee_id'           => 2,
                'priority_id'           => 2,
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],
            [
                'id'                    => 3,
                'user_id'               => 6,
                'entity_id'             => 2, // 'Continuous Pilot Feedback'
                'anonymous'             => 1,
                'status_id'             => 1,
                'assignee_id'           => 5,
                'priority_id'           => 3,
                'created_at'            => $yesterday,
                'updated_at'            => $yesterday,
            ],
            [
                'id'                    => 4,
                'user_id'               => 2,
                'entity_id'             => 2, // 'Continuous Pilot Feedback'
                'anonymous'             => 2,
                'status_id'             => 1,
                'assignee_id'           => 4,
                'priority_id'           => 1,
                'created_at'            => $yesterday,
                'updated_at'            => $yesterday,
            ],

        ];

        DB::table('entity_feedback')->insert($entity_feedback);

        // Add to entity feedback data

        DB::table('entity_feedback_data')->delete();

        $entity_feedback_data = [
            [
                'id'                    => 1,
                'entity_feedback_id'    => 1,
                'behavior_id'           => 8, // For "Does what is expected of them"
                'rating'                => 3,
                'text'                  => 'This entity is pretty cool, but could be more defined.',
                'drop_down_value'       => 'Very Important',
                'drop_down_id'          => 5, // 0 is default
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],
            [
                'id'                    => 2,
                'entity_feedback_id'    => 2,
                'behavior_id'           => 8, // For "Does what is expected of them"
                'rating'                => 3,
                'text'                  => 'I have some concerns about the ongoing use of x,y, and z in this process.',
                'drop_down_value'       => 'Neutral', // not sure about what this should be
                'drop_down_id'          => 2, // 0 is default
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],
            [
                'id'                    => 3,
                'entity_feedback_id'    => 3,
                'behavior_id'           => 8, // For "Does what is expected of them"
                'rating'                => 3,
                'text'                  => "This process really needs to be updated so that it's easier on everyone involved.",
                'drop_down_value'       => 'Very Important', // not sure about what this should be
                'drop_down_id'          => 5, // 0 is default
                'created_at'            => $yesterday,
                'updated_at'            => $yesterday,
            ],
            [
                'id'                    => 4,
                'entity_feedback_id'    => 4,
                'behavior_id'           => 8, // For "Does what is expected of them"
                'rating'                => 3,
                'text'                  => 'This process is okay, but could be more defined.',
                'drop_down_value'       => 'Low Importance', // not sure about what this should be
                'drop_down_id'          => 2, // 0 is default
                'created_at'            => $yesterday,
                'updated_at'            => $yesterday,
            ],

        ];

        DB::table('entity_feedback_data')->insert($entity_feedback_data);
    }
}
