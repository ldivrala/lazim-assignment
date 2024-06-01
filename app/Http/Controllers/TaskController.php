<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Str;

class TaskController extends Controller {
    public function index() {
        if (request()->expectsJson()) {
            return Task::all();
        }
        return view('tasks.index');
    }

    public function create() {
        return view('tasks.create');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|in:pending,in-progress,dropped,done'
        ]);

        $baseSlug = Str::slug($validatedData['name']);
        $existingSlugs = Task::where('slug', 'like', $baseSlug.'%')->pluck('slug');

        $slug = $existingSlugs->contains($baseSlug) ? $baseSlug . '-' . uniqid() : $baseSlug;

        $task = Task::create([
            ...$request->only('name', 'description', 'status'),
            'slug' => $slug
        ]);

        return response()->json($task, 201);
    }

    public function show($slug)
    {
        $task = Task::where('slug', $slug)->firstOrFail();
        return response()->json($task);
    }

    public function edit($slug) {
        $task = Task::where('slug', $slug)->firstOrFail();
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, $slug) {
        $task = Task::where('slug', $slug)->firstOrFail();

        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|in:pending,in-progress,dropped,done'
        ]);

        $task->update($validatedData);

        return response()->json($task, 200);
    }

    public function destroy($slug) {
        $task = Task::where('slug', $slug)->firstOrFail();
        $task->delete();

        return view('tasks.index')->with('success', 'Task has been deleted.');
    }
}
