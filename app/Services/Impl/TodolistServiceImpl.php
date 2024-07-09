<?php

namespace App\Services\Impl;

use App\Models\Todo;
use App\Services\TodolistService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class TodolistServiceImpl implements TodolistService
{

    public function saveTodo(string $id, string $todo): void
    {
        Auth::user()->todos()->create([
            'id' => $id,
            'title' => $todo,
        ]);
    }

    public function getTodolist(): array
    {
        return Auth::user()->todos->toArray();
    }

    public function removeTodo(string $todoId)
    {
        $todo = Todo::where('id', $todoId)->where('user_id', Auth::id())->first();
        if ($todo) {
            $todo->delete();
        }
    }
}