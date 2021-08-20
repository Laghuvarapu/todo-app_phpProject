<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Services\TasksService;

class TaskController extends Controller
{
    // create a single task
    protected $service;

    public function __construct(TasksService $service)
    {
        $this->service = $service;
    }


    public function createTask(Request $request){


        return $this->service->createTask($request);

    }

    public function getTaskById( $id){


        return $this->service->getTaskById($id);


    }

    public function getAllTasks( ){
        return $this->service->getAllTasks();

    }
    public function updateStatus( Request $request , $id){





        return $this->service->updateStatus($request,$id);

    }
    public function deleteTaskById( $id)
    {

        return $this->service->deleteTaskById($id);

    }

    public function deleteTasksDone()
    {
        return $this->service->deleteTasksDone();
    }
}
