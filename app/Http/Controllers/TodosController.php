<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodosController extends Controller
{
    public function index(){
        // $todos = Todo::all();
        $todos = Todo::with("category")->get();
        foreach ($todos as $key => $todo) {
            dump($todo->category);
        }

    }
}
