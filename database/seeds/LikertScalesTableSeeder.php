<?php

use Illuminate\Database\Seeder;

class LikertScalesTableSeeder extends Seeder
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
        DB::table('likert_scales')->delete();

        $scales = [
        [
            'id'                => 1,
            'name'              => 'Standard',
            'labels'            => json_encode(['Needs significant improvement', 'Could be better', 'Doing ok', 'Very good', 'Awesome!']),
            'is_default'        => 1,
            'is_system_default' => 1,
            'created_at'        => new DateTime(),
            'updated_at'        => new DateTime(),
    ],
];

        DB::table('likert_scales')->insert($scales);
    }
}
