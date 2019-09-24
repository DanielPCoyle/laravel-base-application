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
        $response = $this->get('/api/test');
        $response->assertStatus(200);
    }
}
