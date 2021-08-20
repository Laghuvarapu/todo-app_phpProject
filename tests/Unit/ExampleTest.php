<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{

use DatabaseMigrations;


public function testCreateTask()
{
    $response = $this->json('POST', '/tasks', ['title' => 'to do something',
     'description' => 'have to do',
               'status' => "Pending"]);

    $response
   ->assertStatus(200)
   ->assertExactJson(['id'=>1, 'title' => 'to do something', 'description' => 'have to do',
      'status' => 'Pending',
       'message' => 'successfully created!'
]);

}





public function testgetAllTasks(){
     $this->json('GET','/tasks')
    ->assertJsonStructure(['*' => []]);

}

public function testupdateStatus(){

    $this->json('PATCH','/tasks/{id}',['status'=>"Pending"],[1])
     ->assertStatus(400)
    ->assertJsonStructure([]);

}

public function testdeleteTaskById()
    {
        $this->json('DELETE', '/tasks/{id}', [], [1])
            ->assertExactJson([
                'message' => 'task with id-{id} doesn\'t exist to delete']);
    }

  /*  public function testgetTaskById()
    {


        $response = $this->json('GET', '/tasks/2',[]);


        $response

            ->assertJsonStructure([
                ['id',
                    'title',
                    'description',
                    'status',

                ]    ])
            ->assertStatus(200);


    }*/





}
