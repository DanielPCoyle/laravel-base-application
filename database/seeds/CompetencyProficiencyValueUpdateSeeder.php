<?php

use App\Models\Competency;
use Illuminate\Database\Seeder;

class CompetencyProficiencyValueUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $competencyList = Competency::all();
        foreach ($competencyList as $key => $value) {
            $value->proficiency = 3.75;
            $value->save();
        }
    }
}
