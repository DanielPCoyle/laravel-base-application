<?php

use Illuminate\Database\Seeder;

class AthenaAbVariationDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('athena_ab_variations')->delete();

        $abVariationsData = [
            [
                'id'                                => 1,
                'athena_id'                         => 1,
                'name'                              => 'A',
                'description'                       => 'N/A',
                'active'                            => 1,
                'type'                              => 'none',
                'optimal_day_to_send'               => null,
                'email_subject'                     => 'AB Testing',
                'email_message'                     => null,
                'notification_subject'              => 'AB Testing',
                'notification_message'              => null,
                'optimal_time_to_send'              => null,
                'created_at'                        => new DateTime(),
                'updated_at'                        => new DateTime(),
                'deleted_at'                        => null,

            ],
            [
                'id'                                => 2,
                'athena_id'                         => 1,
                'name'                              => 'B1',
                'description'                       => 'Prompted every Monday at 9am to give feedback.',
                'active'                            => 1,
                'type'                              => 'weekly',
                'optimal_day_to_send'               => 'Monday',
                'email_subject'                     => 'AB Testing',
                'notificaiton_subject'              => 'AB Testing',
                'email_message'                     => 'Help someone develop by giving them feedback.',
                'notificaiton_message'              => 'Help someone develop by giving them feedback.',
                'optimal_time_to_send'              => '09:00:00',
                'created_at'                        => new DateTime(),
                'updated_at'                        => new DateTime(),
                'deleted_at'                        => null,

            ],
            [
                'id'                                => 3,
                'athena_id'                         => 1,
                'name'                              => 'B2',
                'description'                       => 'Optimized based on previous behavior to prompt at a particular day and time to give feedback.',
                'active'                            => 1,
                'type'                              => 'sql',
                'optimal_day_to_send'               => null,
                'email_subject'                     => 'AB Testing',
                'notificaiton_subject'              => 'AB Testing',
                'email_message'                     => 'Help someone develop by giving them feedback.',
                'notificaiton_message'              => 'Help someone develop by giving them feedback.',
                'optimal_time_to_send'              => null,
                'created_at'                        => new DateTime(),
                'updated_at'                        => new DateTime(),
                'deleted_at'                        => null,

            ],
            [
                'id'                                => 4,
                'athena_id'                         => 1,
                'name'                              => 'C1',
                'description'                       => 'Prompted every Monday at 9am to give feedback.',
                'active'                            => 1,
                'type'                              => 'weekly',
                'optimal_day_to_send'               => 'Monday',
                'email_subject'                     => 'AB Testing',
                'notificaiton_subject'              => 'AB Testing',
                'email_message'                     => 'Help someone develop by giving them constructive feedback. Identify an area of strength as well as an opportunity for improvement.',
                'notificaiton_message'              => 'Help someone develop by giving them constructive feedback. Identify an area of strength as well as an opportunity for improvement.',
                'optimal_time_to_send'              => '13:00:00',
                'created_at'                        => new DateTime(),
                'updated_at'                        => new DateTime(),
                'deleted_at'                        => null,

            ],
            [
                'id'                                => 5,
                'athena_id'                         => 1,
                'name'                              => 'C2',
                'description'                       => 'Optimized based on previous behavior to prompt at a particular day and time to give feedback.',
                'active'                            => 1,
                'type'                              => 'sql',
                'optimal_day_to_send'               => null,
                'email_subject'                     => 'AB Testing',
                'notificaiton_subject'              => 'AB Testing',
                'email_message'                     => 'Help someone develop by giving them constructive feedback. Identify an area of strength as well as an opportunity for improvement.',
                'notificaiton_message'              => 'Help someone develop by giving them constructive feedback. Identify an area of strength as well as an opportunity for improvement.',
                'optimal_time_to_send'              => null,
                'created_at'                        => new DateTime(),
                'updated_at'                        => new DateTime(),
                'deleted_at'                        => null,

            ],
        ];
        DB::table('athena_ab_variations')->insert($abVariationsData);
    }
}
