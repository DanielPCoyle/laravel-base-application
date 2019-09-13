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
    public function testApiIsLive()
    {
       $response = $this->json('GET', '/api');

        $response
            ->assertStatus(200)
            ->assertJson(['status' => "active"]); 
    }

    public function testGet()
    {
       $response = $this->json('GET', '/api/chat_messages');

        $response
            ->assertStatus(200)
            ->assertJsonStructure(["data"]); 
    }

    public function testGetSingle()
    {
    //Changed this to seeded data for testing. 
       $response = $this->json('GET', '/api/chat_messages/2');
       $response ->assertStatus(200);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(["id","user_id","message","created_at","updated_at","deleted_at"]); 
    }

    public function testGetPagination(){
       $response = $this->json('GET', '/api/chat_messages?limit=10');
       $response ->assertStatus(200);

       $response
            ->assertJsonStructure(["data","pagination"]);
    }

    public function testGetWhereInteger(){
       $response = $this->json('GET', '/api/chat_messages?where[user_id]=1');
       $response ->assertStatus(200);

        foreach($response->getData()->data as $record){  
            $this->assertTrue(($record->user_id == 1));
        }
    }

    public function testGetWhereStringExact(){
       $response = $this->json('GET', '/api/chat_messages?where[message]=Test');
       $response ->assertStatus(200);

        foreach($response->getData()->data as $record){
            $this->assertTrue( (strtolower($record->message) == "test" ) );
        }
    }

    public function testGetWhereStringNotEqual(){
       $response = $this->json('GET', '/api/chat_messages?where[message]=!=,Test');
       $response ->assertStatus(200);
        foreach($response->getData()->data as $record){
            $test = ((strtolower($record->message) == "test" ) == false);
            $this->assertTrue($test);
        }
    }

    public function testGetWhereStringGreaterThan(){
       $response = $this->json('GET', '/api/chat_messages?where[id]=>,10');
       $response ->assertStatus(200);
        foreach($response->getData()->data as $record){
            $test = ((strtolower($record->id) > 10 ) == true);
            $this->assertTrue($test);
        }
    }

    public function testGetWhereStringGreaterThanOrEqual(){
       $response = $this->json('GET', '/api/chat_messages?where[id]=>=,10');
       $response ->assertStatus(200);
        foreach($response->getData()->data as $record){
            $test = ((strtolower($record->id) >= 10 ) == true);
            $this->assertTrue($test);
        }
    }

    public function testGetWhereStringLessThan(){
       $response = $this->json('GET', '/api/chat_messages?where[id]=<,10');
       $response ->assertStatus(200);
        foreach($response->getData()->data as $record){
            $test = ((strtolower($record->id) < 10 ) == true);
            $this->assertTrue($test);
        }
    }

    public function testGetWhereStringLessThanOrEqual(){
       $response = $this->json('GET', '/api/chat_messages?where[id]=<=,10');
       $response ->assertStatus(200);
        foreach($response->getData()->data as $record){
            $test = ((strtolower($record->id) <= 10 ) == true);
            $this->assertTrue($test);
        }
    }

    public function testPost($inFunc = false){
       $response = $this->json('POST', '/api/chat_messages',['user_id' => 1,"message"=>"Tester Tester 123"]);
       $response->assertStatus(200);
       $response->assertJsonStructure(["status","event","entity","data"]);
       $this->assertTrue(($response->getData()->data->id > 0));
       if($inFunc === true){
            return $response->getData()->data->id;
       } else{
            $this->testDelete($response->getData()->data->id);
       }
    }

    public function testDelete($id = null){
        if($id == null){
            $id = $this->testPost(true);
        }
        $response = $this->json("DELETE", '/api/chat_messages/'.$id);
        $response->assertStatus(200);
        $response->getData()->status == "success";
    }



    // public function testPut(){
    //    $response = $this->json('PUT', '/api/chat_messages/20',["message"=>"Testy Tester ABC"]);
    //    $response->dump(); die;
    //    $response->assertStatus(200);
    //    $response->assertJsonStructure(["status","event","entity","data"]);
    //    $this->assertTrue(($response->getData()->data->message == "Testy Tester ABC"));
    // }

}
