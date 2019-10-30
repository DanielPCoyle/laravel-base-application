<?php

use App\Models\Behavior;
use App\Models\BehaviorCompetency;
use App\Models\Competency;
use Illuminate\Database\Seeder;

class RateRaterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = Behavior::get();
        if ($data) {
            $behavior = new Behavior();
            $behavior->behavior = 'How helpful was this feedback';

            $behavior->active = 1;
            $behavior->type = 'score';
            $behavior->is_rate = 1;

            if ($behavior->save()) {
                $competency = new Competency();
                $competency->name = 'Giving Feedback';
                $competency->proficiency = 3.75;
                $competency->is_rate = 1;
                $competency->save();
            }

            $findBehavior = Behavior::where('is_rate', '=', 1)->get();
            $behaviorData = json_decode($findBehavior, true);
            $findCompetency = Competency::where('name', 'Giving Feedback')->get();
            $comptData = json_decode($findCompetency, true);
            if ($findBehavior && $findCompetency) {
                $qsncompetncy = new BehaviorCompetency();
                $qsncompetncy->behavior_id = $behaviorData[0]['id'];

                $qsncompetncy->competency_id = $comptData[0]['id'];
                $qsncompetncy->save();
            }
        }
    }
}
