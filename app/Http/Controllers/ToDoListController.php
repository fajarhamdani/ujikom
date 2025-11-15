<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class ToDoListController extends Controller
{
    # Fungsi menampilkan daftar tugas
    public function index()
    {
        $tasks = Task::orderBy('created_at', 'desc')->get();
        return view('to_do_list.index', compact('tasks'));
    }

    # Fungsi menyimpan tugas baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'sometimes|boolean',
        ]);

        $data['status'] = $data['status'] ?? false;

        $task = Task::create($data);

        return redirect()->back()->with('success', 'Tugas berhasil ditambahkan.');
    }

    # Fungsi memperbarui status tugas
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $data = $request->validate([
            'status' => 'required|boolean',
        ]);

        $task->update($data);

        return redirect()->back()->with('success', 'Tugas berhasil diperbarui.');
    }

    # Fungsi menghapus tugas
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->back()->with('success', 'Tugas berhasil dihapus.');
    }
}
