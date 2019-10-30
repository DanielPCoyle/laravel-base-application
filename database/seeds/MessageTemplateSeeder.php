<?php

use Illuminate\Database\Seeder;

class MessageTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('message_templates')->delete();

        $messageTemplateDefaultData = [
            [
                'id'                      => 1,
                'subject'                 => 'Your DevelapMe Credentials',
                'title'                   => '',
                'heading'                 => '',
                'message'                 => 'Welcome to DevelapMe, our real-time feedback platform!',
                'status'                  => 1,
                'is_default'              => 1,
                'created_at'              => new DateTime(),
                'updated_at'              => new DateTime(),
                'deleted_at'              => null,

            ],
        ];

        DB::table('message_templates')->insert($messageTemplateDefaultData);
    }
}
