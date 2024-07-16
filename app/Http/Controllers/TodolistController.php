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
        $todolist = Todo::where('user_id', auth()->id())->get();
        $users = User::all();
        return view("todolist.todolist", [
            "title" => "Todolist",
            "todolist" => $todolist,
            'users' => $users
        ]);
    }


    public function addTodo(Request $request)
    {
        $validatedData = $request->validate([
            'todo' => 'required|min:2',
        ]);

        Todo::create([
            'todo' => $validatedData['todo'],
            'user_id' => auth()->id()
        ]);

        return redirect()->route('todolist');
    }



    public function removeTodo(Request $request, $id)
    {
        $this->todolistService->removeTodo($id);
        return redirect()->route('todolist'); 
    }

}