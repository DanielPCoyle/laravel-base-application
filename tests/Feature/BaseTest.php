<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
Use App\Http\Services\QueryService;
class BaseTest extends TestCase
{
    /**
     * A test to see if the fields variable works.
     *
     * @return void
     */
    public function getFieldsTest()
    {
       $response = $this->json('GET', '/api/chat_messages/2/math/votes/12');

        $response
            ->assertStatus(201)
            ->assertJson([
                'created' => true,
        ]);
    }
}
