<?php

use Illuminate\Database\Seeder;

class IntegrationTagsTableSeeder extends Seeder
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
        // Create Integration Tags

        DB::table('integration_tags')->delete();

        $integration_tags = [
            [
                'id'                    => 1,
                'preference_id'         => 1,
                'code'                  => 'IntegrationField1',
                'name'                  => 'Role',
                'is_required'           => 1,
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],

        ];

        DB::table('integration_tags')->insert($integration_tags);

        // Create Integration Field Values

        DB::table('integration_field_value_assigns')->delete();

        $integration_field_values = [
            [
                'id'                    => 1,
                'integration_tag_id'    => 1,
                'value'                 => 'Executive',
                'status'                => 1,
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],
            [
                'id'                    => 2,
                'integration_tag_id'    => 1,
                'value'                 => 'Vice President',
                'status'                => 1,
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],
            [
                'id'                    => 3,
                'integration_tag_id'    => 1,
                'value'                 => 'Director',
                'status'                => 1,
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],
            [
                'id'                    => 4,
                'integration_tag_id'    => 1,
                'value'                 => 'Manager',
                'status'                => 1,
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],
            [
                'id'                    => 5,
                'integration_tag_id'    => 1,
                'value'                 => 'Associate',
                'status'                => 1,
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],
            [
                'id'                    => 6,
                'integration_tag_id'    => 1,
                'value'                 => 'Intern',
                'status'                => 1,
                'created_at'            => new DateTime(),
                'updated_at'            => new DateTime(),
            ],
        ];

        DB::table('integration_field_value_assigns')->insert($integration_field_values);

        // Create User Integration Tags

        DB::table('user_integration_tags')->delete();

        $user_integration_tags = [
            [
                'id'                 => 1,
                'integration_tag_id' => 1,
                'user_id'            => 1,
                'value'              => 'Executive',
            ],
            [
                'id'                 => 2,
                'integration_tag_id' => 1,
                'user_id'            => 2,
                'value'              => 'Executive',
            ],
            [
                'id'                 => 3,
                'integration_tag_id' => 1,
                'user_id'            => 3,
                'value'              => 'Executive',
            ],
            [
                'id'                 => 4,
                'integration_tag_id' => 1,
                'user_id'            => 4,
                'value'              => 'Executive',
            ],
            [
                'id'                 => 5,
                'integration_tag_id' => 1,
                'user_id'            => 5,
                'value'              => 'Associate',
            ],
            [
                'id'                 => 6,
                'integration_tag_id' => 1,
                'user_id'            => 6,
                'value'              => 'Associate',
            ],
            [
                'id'                 => 7,
                'integration_tag_id' => 1,
                'user_id'            => 7,
                'value'              => 'Associate',
            ],
            [
                'id'                 => 8,
                'integration_tag_id' => 1,
                'user_id'            => 8,
                'value'              => 'Associate',
            ],
            [
                'id'                 => 9,
                'integration_tag_id' => 1,
                'user_id'            => 8,
                'value'              => 'Associate',
            ],
            [
                'id'                 => 10,
                'integration_tag_id' => 1,
                'user_id'            => 8,
                'value'              => 'Associate',
            ],
        ];

        DB::table('user_integration_tags')->insert($user_integration_tags);
    }
}
