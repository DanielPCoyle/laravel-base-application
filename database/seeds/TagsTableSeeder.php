<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
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
        DB::table('tags')->delete();

        $tags = [
            [
                'id'                    => 1,
                'name'                  => 'Actionable',
                'description'           => 'Was able to take action upon.',
                'user_id'               => 1,
                'badge_color'           => '#1ABC9C',
                'badge_text_color'      => '#ffffff',
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],
            [
                'id'                    => 2,
                'name'                  => 'Not Actionable',
                'description'           => 'Was not able to take action upon.',
                'user_id'               => 1,
                'badge_color'           => '#F7B84B',
                'badge_text_color'      => '#ffffff',
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],
        ];

        DB::table('tags')->insert($tags);
    }
}
