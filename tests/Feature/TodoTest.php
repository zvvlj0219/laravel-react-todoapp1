<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Todo;

// use App\Http\Request\StoreTodoRequest;
// use App\Http\Request\UpdateTodoRequest;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    const TABLE_NAME = 'todo_app_1';

    protected function setUp(): void
    {
        parent::setUp();

    }

    /**
     * 一覧を取得
     *
     * @return void
     */
    public function test_getAllTodos()
    {
        $todos = Todo::factory()->count(10)->create();

        $response = $this->getJson('api/todos');

        $response
            ->assertOk()
            ->assertJsonCount($todos->count());
    }

    /**
     * todoを登録
     *
     * @return void
     */
    public function test_registerTodo()
    {
        // テスト内で
        // ”withoutExceptionHandling()”を使用すると
        // メッセージがわかりやすくなることがあります
        $this->withoutExceptionHandling();

        $data = [
            'title' => 'テスト登録'
        ];

        $response = $this->postJson('/api/todos', $data);

        $response
            ->assertStatus(201)
            ->assertJsonFragment($data);

    }

    /**
     * todoを登録する際のバリエーションチェック
     *
     * @return void
     */
    public function test_validation_todo()
    {
        // titleが空のデータ
        $data = [
            'title' => ''
        ];

        $response = $this->postJson('/api/todos', $data);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(
                ['title' => 'The title field is required.']
            );
    }

    /** 
     * todoを更新
     *
     * @return void
     */
    public function test_updateTodo()
    {
        // テスト内で
        // ”withoutExceptionHandling()”を使用すると
        // メッセージがわかりやすくなることがあります
        $this->withoutExceptionHandling();

        $todo = Todo::factory()->create();

        $todo->title = '更新';

        $response = $this->patchJson("api/todos/{$todo->id}", $todo->toArray());

        // ddはvar_dumpと違いそれ以降の処理は実行されない
        // dd($response->json());

        $response
            ->assertOk()
            ->assertJsonFragment($todo->toArray());
    }

    /**
     * todoを削除
     *
     * @return void
     */
    public function test_deleteTodo()
    {
        // テスト内で
        // ”withoutExceptionHandling()”を使用すると
        // メッセージがわかりやすくなることがあります
        $this->withoutExceptionHandling();

        $todos = Todo::factory()->count(10)->create();

        $response = $this->deleteJson("api/todos/15");

        $response->assertOk();

        $response = $this->getJson('api/todos');

        $response->assertJsonCount($todos->count() - 1);
    }
}
