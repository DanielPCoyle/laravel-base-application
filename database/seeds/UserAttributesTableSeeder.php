<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserAttributesTableSeeder extends Seeder
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
        DB::table('user_attributes')->delete();

        $user_attributes = [
            [
                'id'                        => 1,
                'key'                       => 'giverfunction',
                'name'                      => 'Giver Function',
                'type'                      => 'string',
                'input'                     => null,
                'description'               => '',
                'value_validation_enabled'  => 0,
                'allow_empty_values'        => 0,
                'created_at'                => new DateTime(),
                'updated_at'                => new DateTime(),
            ],

        ];

        DB::table('user_attributes')->insert($user_attributes);

        $users = User::all();
        DB::table('user_meta')->delete();
        $user_meta = [];

        foreach ($users as $user) {
            $user_meta[$user->id] = [
                'id'                => $user->id,
                'user_id'           => $user->id,
                'user_attribute_id' => 1, // Giver Function
                'created_at'        => new DateTime(),
                'updated_at'        => new DateTime(),
            ];
            if ($user->id <= 4) {
                $user_meta[$user->id]['value'] = 'Function Type 1';
            } else {
                $user_meta[$user->id]['value'] = 'Function Type 2';
            }
        }

        DB::table('user_meta')->insert($user_meta);
    }
}
