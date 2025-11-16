<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\TodoResource;

class TodosController extends Controller
{
    private function getUserTodos()
    {
        return Todo::where('user_id', auth()->id());
    }

    public function index()
    {
        $todos = $this->getUserTodos()->with('category')->get();
        return response()->json([
            'status' => true,
            'todos' => TodoResource::collection($todos),

        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'category_id' => 'required|exists:categories,id',
            'due_date' => 'nullable|date',
            'tags' => 'nullable|json'
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'desc.string' => 'The description must be a string.',
            'priority.required' => 'The priority field is required.',
            'priority.in' => 'The selected priority is invalid.',
            'category_id.required' => 'The category field is required.',
            'category_id.exists' => 'The selected category does not exist.',
            'due_date.date' => 'The due date must be a valid date.',
            'tags.json' => 'The tags must be a valid JSON string.'
        ]);

        $todo = Todo::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'desc' => $request->desc,
            'priority' => $request->priority,
            'category_id' => $request->category_id,
            'due_date' => $request->due_date,
            'tags' => $request->tags
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Todo Created Successfully',
            'todo' => TodoResource::make($todo->fresh())
        ], Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $todo = $this->getUserTodos()->with('category')->find($id);

        if (!$todo) {
            return response()->json([
                'status' => false,
                'message' => 'Todo Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => true,
            'todo' => TodoResource::make($todo)
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'category_id' => 'required|exists:categories,id',
            'due_date' => 'nullable|date',
            'tags' => 'nullable|json'
        ]);

        $todo = $this->getUserTodos()->with('category')->find($id);

        if (!$todo) {
            return response()->json([
                'status' => false,
                'message' => 'Todo Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        $todo->update([
            'name' => $request->name,
            'desc' => $request->desc,
            'priority' => $request->priority,
            'category_id' => $request->category_id,
            'due_date' => $request->due_date,
            'tags' => $request->tags
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Todo Updated Successfully',
            'todo' => TodoResource::make($todo->fresh())
        ]);
    }

    public function destroy(string $id)
    {
        $todo = $this->getUserTodos()->find($id);

        if (!$todo) {
            return response()->json([
                'status' => false,
                'message' => 'Todo Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        $todo->delete();

        return response()->json([
            'status' => true,
            'message' => 'Todo Deleted Successfully'
        ]);
    }

    public function toggleCompletion(string $id)
    {
        $todo = $this->getUserTodos()->with('category')->find($id);

        if (!$todo) {
            return response()->json([
                'status' => false,
                'message' => 'Todo Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        $todo->completed = !$todo->completed;
        $todo->save();

        return response()->json([
            'status' => true,
            'message' => 'Todo Completion Status Toggled Successfully',
            'todo' => TodoResource::make($todo->fresh())
        ]);
    }
}
