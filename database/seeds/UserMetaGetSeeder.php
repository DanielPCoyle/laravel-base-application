<?php

use App\Models\UserMeta;
use Illuminate\Database\Seeder;

class UserMetaGetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserMeta::chunk(10, function ($collection) {
            foreach ($collection as $object) {
                $k = json_decode($object, true);

                $oldUser = UserMeta::where('key', 'getfeedback')->where('user_id', $k['user_id'])->first();
                if (!$oldUser) {
                    $user = new UserMeta();
                    $user->user_id = $k['user_id'];
                    $user->key = 'getfeedback';

                    $user->save();
                } else {
                    logger('Not required to add !');
                }
            }
        });
    }
}
