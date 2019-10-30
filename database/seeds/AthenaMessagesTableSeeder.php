<?php

use Illuminate\Database\Seeder;

class AthenaMessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // delete existing messages
        DB::table('athena_messages')->delete();

        $messages = [
            [
                'id'                        => 1,
                'athena_id'                 => 1,
                'title'                     => '',
                'heading'                   => '',
                'subject'                   => 'Pssst',
                'message'                   => 'Yes, you, {{first_name}}.  We haven’t heard from you in a while. Since you already have your phone in your hand, why not share that feedback now?',
                'notification_message'      => 'Yes, you, {{first_name}}.  We haven’t heard from you in a while. Since you already have your phone in your hand, why not share that feedback now?',
            ],

        ];

        DB::table('athena_messages')->insert($messages);
    }
}
