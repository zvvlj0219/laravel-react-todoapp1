<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Todo;

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

        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertStatus(200);
    }
}
