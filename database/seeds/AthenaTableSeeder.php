<?php

use Illuminate\Database\Seeder;

class AthenaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('athena')->delete();

        $algorithms = [
            [
                'id'          => 1,
                'name'        => 'Reminder to give feedback',
                'description' => 'Reminder for users to give feedback after a specified number of days.',
                'explanation' => 'Athena sends a notification to users, reminding them to give feedback. A notification is sent only if a
                            user has not provided feedback in X number of days.',
                'instructions' => 'Enter the desired number of days in the
                            box on the left. For example: if X is 15, then after 15 days a notification will go out to all users who
                            haven’t given feedback in the last 15 days. After an additional 15 days, another email will again
                            be sent if users haven’t provided feedback. Upon giving feedback, Athena resets the clock.',
                'order'       => 1,
                'data'        => json_encode(['day' => 15]),
            ],
            [
                'id'          => 2,
                'name'        => 'Reminder to request feedback',
                'description' => 'Reminder for users to request feedback after a specified number of days.',
                'explanation' => 'Athena sends a notification to users, reminding them to request feedback. A notification is sent only if a
                            user has not requested feedback in X number of days.',
                'instructions' => 'Enter the desired number of days in the
                            box on the left. For example: if X is 15, then after 5 days a notification will go out to all users who
                            haven’t requested feedback in the last 15 days. After an additional 15 days, another email will again
                            be sent if users haven’t requested feedback. Upon requesting feedback, Athena resets the clock.',
                'order'       => 1,
                'data'        => json_encode(['day' => 15]),
            ],
            [
                'id'          => 3,
                'name'        => 'Reminder to respond to unanswered feedback requests',
                'description' => 'Reminder for users to respond to unanswered feedback requests after a specified number of days.',
                'explanation' => 'Athena sends a notification to users, reminding them to give feedback to someone who has requested feedback and is still waiting for that feedback. A notification is sent only if a
                            user has not provided feedback in a response to the request in X number of days.',
                'instructions' => 'Enter the desired number of days in the
                            box on the left. For example: if X is 5, then after 5 days a notification will go out to all users who
                            haven’t responded . After an additional 5 days, another email will again
                            be sent if users still haven’t provided feedback. Upon giving feedback, Athena resets the clock.',
                'order'       => 1,
                'data'        => json_encode(['day' => 5]),
            ],
            [
                'id'           => 4,
                'name'         => 'Reminder to give follow-up feedback after giving a low score',
                'description'  => 'TODO',
                'explanation'  => 'TODO.',
                'instructions' => 'TODO',
                'order'        => 1,
                'data'         => json_encode(['days' => 14]),
            ],
        ];

        DB::table('athena')->insert($algorithms);
    }
}
