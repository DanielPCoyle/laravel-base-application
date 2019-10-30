<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class AssignedRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ------
        // Commented out per: DM-36
        // ------
        // DB::table('assigned_roles')->delete();
        // $assigned_roles = array(
        //     array(
        //         'id'         => 1,
        //         'user_id'    => 1,
        //         'role_id'    => 2,
        //         'team_id'   => 1,
        //         'created_at' => new DateTime,
        //         'updated_at' => new DateTime,
        //         'deleted_at' => null
        //     ),
        //     array(
        //         'id'         => 2,
        //         'user_id'    => 2,
        //         'role_id'    => 2,
        //         'team_id'   => 1,
        //         'created_at' => new DateTime,
        //         'updated_at' => new DateTime,
        //         'deleted_at' => null
        //     ),
        //     array(
        //         'id'         => 3,
        //         'user_id'    => 3,
        //         'role_id'    => 2,
        //         'team_id'   => 1,
        //         'created_at' => new DateTime,
        //         'updated_at' => new DateTime,
        //         'deleted_at' => null
        //     ),
        //     array(
        //         'id'         => 4,
        //         'user_id'    => 4,
        //         'role_id'    => 2,
        //         'team_id'   => 1,
        //         'created_at' => new DateTime,
        //         'updated_at' => new DateTime,
        //         'deleted_at' => null
        //     ),
        // );

        // DB::table('assigned_roles')->insert( $assigned_roles );

        $users = User::all();
        DB::table('assigned_roles')->delete();
        $assigned_roles = [];

        foreach ($users as $user) {
            $assigned_roles[$user->id] = [
                'id'             => $user->id,
                'user_id'        => $user->id,
                'reference_type' => 'App\Models\Team',
                'created_at'     => new DateTime(),
                'updated_at'     => new DateTime(),
            ];
            if ($user->id <= 4) {
                $assigned_roles[$user->id]['reference_id'] = 1;
                $assigned_roles[$user->id]['role_id'] = 4; //Owner
            } else {
                $assigned_roles[$user->id]['reference_id'] = 1;
                $assigned_roles[$user->id]['role_id'] = 6; //Member
            }
        }

        DB::table('assigned_roles')->insert($assigned_roles);
    }
}
