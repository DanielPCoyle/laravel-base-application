<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @group sheets
 */
class SheetTest extends TestCase
{

    public function testLastSyncFileCreated()
    {
        $lastSyncDirPath = str_replace("\\app","\\database\\syncs" , app_path()); 
        $beforeSyncDir = scandir($lastSyncDirPath);
        $this->artisan("sheets:sync --force --yes");
        $afterSyncDir = scandir($lastSyncDirPath);
        $this->assertTrue(
        	(count($afterSyncDir) - count($beforeSyncDir)) == 1
        );
    }

    /**
     * 
     * A basic test example.
     *
     * @return void
     */
    public function testModelCreated()
    {
        $lastSyncDirPath = str_replace("\\app","\\database\\syncs" , app_path()); 
        $lastSyncDir = scandir($lastSyncDirPath);
        $lastSync = end($lastSyncDir);
        $lastSync = file_get_contents($lastSyncDirPath."\\".$lastSync);
        $lastSync = json_decode($lastSync);
        $entities = array_keys( get_object_vars($lastSync));
        $count = 0;
        foreach ($entities as $entity) {
        	if(in_array($entity.".php", 
	        		scandir(
	        			app_path()
	        		)
        		)
        	){
        		$count= $count+1;
        	}
        }
        $this->assertTrue($count == count($entities));
    }


    public function testMigrationCreated()
    {
        $lastSyncDirPath = str_replace("\\app","\\database\\syncs" , app_path()); 
        $migrationDirPath = str_replace("\\app","\\database\\migrations" , app_path()); 
        $lastSyncDir = scandir($lastSyncDirPath);
        $lastSync = end($lastSyncDir);
        $file = $lastSyncDirPath."\\".$lastSync;
        $lastSync = file_get_contents($file);
        $lastSync = json_decode($lastSync);
        $entities = array_keys( get_object_vars($lastSync));
        $count = 0;
        $fileName = explode("\\",$file);
        $fileName = end($fileName);
        $fileName = explode("_",$fileName);
        array_pop($fileName);
        $timeStamp = join("_",$fileName);
         foreach ($entities as $entity) {
        	$check = $timeStamp."_create_".strtolower($entity)."_table.php";
    		if(in_array($check, scandir($migrationDirPath ))){
    			$count= $count+1;
    		}
        }
        $this->assertTrue($count == count($entities));
    }

    public function testFactoryCreated()
    {
        $lastSyncDirPath = str_replace("\\app","\\database\\syncs" , app_path()); 
        $factoriesDirPath = str_replace("\\app","\\database\\factories" , app_path()); 
        $lastSyncDir = scandir($lastSyncDirPath);
        $lastSyncFile = end($lastSyncDir);

        $file = $lastSyncDirPath."\\".$lastSyncFile;
        $fileName = explode("\\",$file);
        $fileName = end($fileName);
        $fileName = explode("_",$fileName);

        $lastSync = file_get_contents($file);
        $lastSync = json_decode($lastSync);
        $entities = get_object_vars($lastSync);

        $entitiesWithFactories = [];
        foreach ($entities as $entity => $records) {
        	foreach ($records as $rKey => $record) {
        		if(isset($record->factory) && !in_array($entity, $entitiesWithFactories)){
        			$entitiesWithFactories[] = $entity;
        		}
        	}
        }
        $count = 0;
         foreach ($entitiesWithFactories as $entity) {
         	$check = $entity.".php";
    		if(in_array($check, scandir($factoriesDirPath ))){
    			$count= $count+1;
    		}
        }
        $this->assertTrue($count == count($entitiesWithFactories));
    }
}
