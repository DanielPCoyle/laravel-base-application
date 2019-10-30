<?php

use Illuminate\Database\Seeder;

class EscalationsTableSeeder extends Seeder
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
        // Create escalation

        DB::table('escalations')->delete();

        $escalations = [
            [
                'id'                    => 1,
                'user_id'               => 8, // Natalie
                'assignee_user_id'      => 1, // Alec
                'escalated_to_user_id'  => 1,
                'feedback_id'           => null,
                'entity_id'             => 1,
                'entity_feedback_id'    => 1,
                'status'                => 'open',
                'level'                 => null,
                'detail'                => 'There is a big problem in sales that we need to escalate.',
                'urgency'               => 'And it is very urgent.',
                'outcome'               => 'To resolve it you will take this feedback through the cycle.',
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],

        ];

        DB::table('escalations')->insert($escalations);

        // Add to Escalations Feedback Data

        DB::table('escalation_feedback_data')->delete();

        $escalation_feedback_data = [
            [
                'id'                    => 1,
                'user_id'               => 1, // Alec
                'escalation_id'         => 1,
                'message'               => 'This is extremely important and affects day to day life.',
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],

        ];

        DB::table('escalation_feedback_data')->insert($escalation_feedback_data);
    }
}
