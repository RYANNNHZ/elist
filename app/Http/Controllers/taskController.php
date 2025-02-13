<?php

namespace App\Http\Controllers;

use App\Models\task;
use Illuminate\Http\Request;

class taskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|max:175',
        ], [
            'task.required' => 'Task cannot be empty',
            'task.max' => 'Too many characters',
        ]);

        Task::create([
            'task' => $request->task,
            'lists_id' => $request->id
        ]);

        return redirect()->back();
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
public function destroy(string $id)
{
    $task = Task::where('id', $id)->firstOrFail(); // Cari berdasarkan UUID

    $task->delete(); // Hapus task

    return redirect()->back();
}

}
