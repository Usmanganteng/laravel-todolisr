<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Todo;
use App\Models\User;

class TodolistController extends Controller
{

    private TodolistService $todolistService;

    public function __construct(TodolistService $todolistService)
    {
        $this->middleware('auth');
        $this->todolistService = $todolistService;
    }

    public function todoList(Request $request)
    {
        // Mendapatkan pengguna yang sedang login
        $user = Auth::user();

        $todolist = Todo::where('user_id', $user->id)->get();

        return view("todolist.todolist", [
            "title" => "Todolist",
            "todolist" => $todolist,
            'username' => $user->name // Menambahkan username untuk ditampilkan
        ]);
    }

    public function addTodo(Request $request)
    {
        $validatedData = $request->validate([
            'todo' => 'required|min:2',
            'due_date' => 'date', // Add validation for due_date
        ]);

        Todo::create([
            'todo' => $validatedData['todo'],
            'user_id' => auth()->id(),
            'due_date' => $validatedData['due_date'], // Add due_date to the created todo
        ]);

        return redirect()->route('todolist');
    }

    public function removeTodo(Request $request, $id)
    {
        $this->todolistService->removeTodo($id);
        return redirect()->route('todolist');
    }
}
