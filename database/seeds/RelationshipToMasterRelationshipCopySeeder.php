<?php

use App\Models\MasterRelationship;
use App\Models\Relationship;
use Illuminate\Database\Seeder;

class RelationshipToMasterRelationshipCopySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = Relationship::where('is_manual', 0)->get();
        if ($datas) {
            foreach ($datas as $key => $value) {
                $master_relation = new MasterRelationship();
                $master_relation->name = $value->name;
                $master_relation->active = 1;
                $master_relation->save();
            }
            $master_datas = MasterRelationship::all();
            foreach ($master_datas as $key => $item) {
                $relation = Relationship::where('name', $item->name)->first();
                $relation->master_relationship_id = $item->id;
                $relation->save();
            }
        }
    }
}
