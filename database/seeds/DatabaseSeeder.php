<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(CompetenciesTableSeeder::class);
        $this->call(BehaviorsTableSeeder::class);
        $this->call(RelationshipsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(BehaviorCompetencyPivotTableSeeder::class);
        $this->call(RelationshipBehaviorPivotTableSeeder::class);
        $this->call(AthenaTableSeeder::class);
        $this->call(AthenaMessagesTableSeeder::class);
        $this->call(RateRaterSeeder::class);
        $this->call(CompetencyProficiencyValueUpdateSeeder::class);
        $this->call(MessageTemplateSeeder::class);
        $this->call(RelationshipToMasterRelationshipCopySeeder::class);
        $this->call(AddCatchAllTagSeeder::class);
        $this->call(AthenaAbVariationDefaultSeeder::class);
        $this->call(UserMetaGetSeeder::class);
        $this->call(UserSettingsTableSeeder::class);
        $this->call(PriorityTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(LikertScalesTableSeeder::class);

        // For Local/Dev Only
        // Adds Sample Data that is not wanted in production
        if (config('app.env') != 'production') {
            $this->call(TeamsTableSeeder::class);
            $this->call(AssignedRolesTableSeeder::class);
            $this->call(EntitiesTableSeeder::class);
            $this->call(StatusesTableSeeder::class);
            $this->call(FeedbackTableSeeder::class);
            $this->call(EntityFeedbackTableSeeder::class);
            $this->call(IntegrationTagsTableSeeder::class);
            $this->call(EscalationsTableSeeder::class);
            $this->call(FlaggedFeedbackTableSeeder::class);
            $this->call(UserAttributesTableSeeder::class);
        }

        Model::reguard();
    }
}
