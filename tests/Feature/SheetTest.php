<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SheetTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSheetExecutes()
    {
        $test = $this->artisan('sheets:sync')->expectsOutput("Sync has finished, 2 tables updated or created");
    }
}
