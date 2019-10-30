<?php

use App\Services\UserService;
use Illuminate\Database\Seeder;

class UserSettingsTableSeeder extends Seeder
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
        UserService::ensureAllUsersHaveDefaultNotificationSettings();
    }
}
