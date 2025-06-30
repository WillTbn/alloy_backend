<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
     use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_task_index()
    {
        Task::factory()->count(5)->create();
        $response = $this->getJson('/api/tasks');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'nome',
                        'descricao',
                        'finalizado',
                        'data_limite',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
        $response->assertJsonCount(5, 'data');
    }
    public function test_task_store()
    {
        $taskData = [
            'nome' => 'Test Task',
            'descricao' => 'This is a test task',
            'finalizado' => false,
            'data_limite' => now()->addDays(7)->toDateTimeString(),
        ];

        $response = $this->postJson('/api/tasks', $taskData);
        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'nome',
                    'descricao',
                    'finalizado',
                    'data_limite',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }
    public function test_task_show()
    {
        $task = Task::factory()->create();
        $response = $this->getJson('/api/tasks/' . $task->id);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'nome',
                    'descricao',
                    'finalizado',
                    'data_limite',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }
    public function test_task_update()
    {
        $task = Task::factory()->create();
        $updateData = [
            'nome' => 'Updated Task',
            'descricao' => 'This is an updated task',
            'finalizado' => true,
            'data_limite' => now()->addDays(3)->toDateTimeString(),
        ];

        $response = $this->putJson('/api/tasks/' . $task->id, $updateData);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'nome',
                    'descricao',
                    'finalizado',
                    'data_limite',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }
    public function test_task_delete()
    {
        $task = Task::factory()->create();
        $response = $this->deleteJson('/api/tasks/' . $task->id);
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Tarefa excluída com sucesso',
            ]);
    }

}
