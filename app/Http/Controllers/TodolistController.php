<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TodolistController extends Controller
{

    private TodolistService $todolistService;

    public function __construct(TodolistService $todolistService)
    {
        $this->todolistService = $todolistService;
    }

    public function todoList(Request $request)
    {
        $todolist = $this->todolistService->getTodolist();
        return response()->view("todolist.todolist", [
            "title" => "Todolist",
            "todolist" => $todolist
        ]);
    }

    public function addTodo(Request $request)
{
    $validatedData = $request->validate([
        'todo' => 'required|min:2',
    ], [
        'todo.required' => 'Todo is required.',
        'todo.min' => 'Todo must be at least 2 characters long.',
    ]);

    $todo = $validatedData['todo'];
    $this->todolistService->saveTodo(uniqid(), $todo);

    return redirect()->action([TodolistController::class, 'todoList']);
}
    public function removeTodo(Request $request, string $todoId): RedirectResponse
    {
        $this->todolistService->removeTodo($todoId);
        return redirect()->action([TodolistController::class, 'todoList']);
    }

}