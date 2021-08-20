<?php


namespace App\Services;
use App\Models\Tasks;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class TasksService{

    public function createTask( Request $request){
        Log::info('Creating a particular task: '.$request->title);
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|unique:tasks|regex:/^[a-zA-Z]+$/u',
            'description' => 'required',
            'status' => ['required',Rule:: in(['Pending','In Progress','Done'])]
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),Response::HTTP_BAD_REQUEST);
        }




        try {


            $task = new Tasks();
            $task->title = $request->title;
            $task->description = $request->description;
            $task->status = $request->status;
            $task->save();

        }catch(QueryException $e){
            return response()->json($e->errorInfo,Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'tasks'=>$task,
        ]);

    }

    public function getTaskById($id){
        Log::info('Fetching a particular task by id: '.$id);

        try {
            $task= DB::table('tasks')->where('id',$id)->first();
        }catch(QueryException $e){
            return response()->json($e->errorInfo,Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if($task==null){
            return response()->json(['message' => "task with id-$id doesn't exist"],Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'id'=>$id,
            'title' => $task->title,
            'description'=>$task->description,
            'status' => $task->status,
        ]);
    }


    public function getAllTasks(){
        Log::info('Fetching All the tasks');
        try {
         $tasks=   DB::table('tasks')->get();
        }catch(QueryException $e){
            return response()->json($e->errorInfo,Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        if(count($tasks)==null){
            return response()->json(['message' => "No tasks available"],Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            "tasks" => $tasks
        ]);


    }

    public function updateStatus($request,$id){
        Log::info('Updating status of a particular task by id: '.$id);
        $newStatus = $request->status;
        try {
            $task= DB::table('tasks')->where('id',$id)->first();
        }catch(QueryException $e){
            return response()->json($e->errorInfo,Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        if($task==null){
            return response()->json(['message' => "task with id-$id does not exist to update"],Response::HTTP_BAD_REQUEST);
        }

        if($task->status=="Done"){
            return response()->json(['message' => "task with id-$id cannnot update the status as the task is already done "],Response::HTTP_BAD_REQUEST);
        }

        $validator = Validator::make($request->all(), [
            'status' => ['required',Rule:: in(['In Progress','Pending','Done'])]]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),Response::HTTP_BAD_REQUEST);
        }



        try {
            Tasks::where('id',$id)->update(['status'=>$newStatus]);


        }catch(QueryException $e){
            return response()->json($e->errorInfo,Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        try {
            $updatedTask= DB::table('tasks')->where('id',$id)->first();
        }catch(QueryException $e){
            return response()->json($e->errorInfo,Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "Message"=>"Task with id-$id updated successfully",
            "Task" => $updatedTask,
        ]);

    }

    public function deleteTaskById($id){
        Log::info('Deleting a particular task by id: '.$id);
        try {
            $task= DB::table('tasks')->where('id',$id)->first();
        }catch(QueryException $e){
            return response()->json($e->errorInfo,Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if($task==null){
            return response()->json(['message' => "task with id-$id doesn't exist to delete"],Response::HTTP_BAD_REQUEST);
        }

        try {
            DB::table('tasks')->where('id',$id)->delete();
        }catch(QueryException $e){
            return response()->json($e->errorInfo,Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            "message" => "task with id = $id is deleted successfully!"
        ]);

    }

    public function deleteTasksDone(){
        Log::info('Deleting a particular task by status: '."Done");
        try {
            $tasks= DB::table('tasks')->where('status',"Done")->get();
        }catch(QueryException $e){
            return response()->json($e->errorInfo,Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        if(count($tasks)==0){
            return response()->json(['message' => "there are no tasks with status Done to delete "],Response::HTTP_BAD_REQUEST);
        }


        try {
            DB::table('tasks')->where('status',"Done")->delete();
        }catch(QueryException $e){
            return response()->json($e->errorInfo,Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            "message" => "tasks with status done is deleted successfully!"
        ]);


    }




}
