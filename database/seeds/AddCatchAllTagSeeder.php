<?php

use App\Models\Relationship;
use Illuminate\Database\Seeder;

class AddCatchAllTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $findCatchall = Relationship::where('name', 'Catch-All')->first();
        if (!$findCatchall) {
            $relation = new Relationship();
            $relation->name = 'Catch-All';
            $relation->active = 1;
            $relation->is_manual = 1;
            $relation->integration_order = 1;
            $relation->master_relationship_id = 0;
            $relation->save();
        }
    }
}
