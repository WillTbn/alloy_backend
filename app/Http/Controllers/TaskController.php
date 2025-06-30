<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tasks\StoreTasksRequest;
use App\Http\Requests\Tasks\UpdateTasksRequest;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $tasks =  Cache::remember('tasks.all', 60, function () {
                return Task::latest()->get();
            });
            return $this->ApiSuccess('Tarefas recuperadas com sucesso', $tasks);

        }catch(Exception $e){
            return $this->ApiError('Falha ao recuperar tarefas', $e->getMessage());
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTasksRequest $request)
    {
        try {
            $task = Cache::remember('task.'.$request->nome, 60, function () use ($request) {
                return Task::create($request->validated());
            });
            Cache::forget('tasks.all');
            return $this->ApiSuccess('Tarefa criada com sucesso', $task, 201);
        } catch (Exception $e) {
            return $this->ApiError('Falha ao criar tarefa', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {

        try{
            $getTask = Cache::get('task.'.$task->id);
            if (!$getTask) {
                $getTask = Task::findOrFail($task->id);
                Cache::put('task.'.$task->id, $getTask, 60);
            }
            $task = Cache::remember('task.'.$getTask->id, 60, function () use ($task) {
                return $task;
            });
            return $this->ApiSuccess('Tarefa recuperada com sucesso', $task, 200);
        }catch(Exception $e){
            return $this->ApiError('Falha ao recuperar tarefa', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTasksRequest $request, Task $getTask)
    {
        try {
            $task = Cache::remember('task.'.$getTask->id, 60, function () use ($request, $getTask) {

                $getTask->nome = $request->nome;
                $getTask->descricao = $request->descricao;
                $getTask->finalizado = $request->finalizado;
                $getTask->data_limite = $request->data_limite;

                $getTask->save();
                // Return the updated task
                return $getTask;
            });
            Cache::put('task.'.$task->id, $task, 60);
            // Update the cache for all tasks
            Cache::forget('tasks.all');
            return $this->ApiSuccess('Tarefa atualizada com sucesso', $task);
        } catch (Exception $e) {
            return $this->ApiError('Falha ao atualizar tarefa', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        try {
            $task->delete();
            Cache::forget('task.'.$id);
            Cache::forget('tasks.all');
            return $this->ApiSuccess('Tarefa excluída com sucesso');
        } catch (Exception $e) {
            return $this->ApiError('Falha ao excluir tarefa', $e->getMessage());
        }
    }

    public function toogle(Task $task)
    {
        $task = Task::findOrFail($task);
        try {
            $task->finalizado = !$task->finalizado;
            $task->save();
            Cache::forget('task.'.$task->id);
            Cache::forget('tasks.all');
            return $this->ApiSuccess('Tarefa atualizada com sucesso', $task);
        } catch (Exception $e) {
            return $this->ApiError('Falha ao atualizar tarefa', $e->getMessage());
        }
    }

}
