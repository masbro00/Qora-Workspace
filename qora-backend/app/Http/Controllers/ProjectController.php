<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // Mengambil semua data project
    public function index()
    {
        // Kita gunakan 'with' untuk sekalian memanggil data pembuatnya (relasi creator)
        $projects = Project::with('creator:id,name,email')->get();
        
        return response()->json([
            'message' => 'Success fetching projects',
            'data' => $projects
        ]);
    }

    // Membuat project baru
    public function store(Request $request)
    {
        // 1. Validasi inputan dari frontend
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|in:active,archived,completed',
        ]);

        // 2. Simpan ke database
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status ?? 'active',
            // 'created_by' otomatis mengambil ID dari user yang sedang login!
            'created_by' => $request->user()->id, 
        ]);

        return response()->json([
            'message' => 'Project successfully created',
            'data' => $project
        ], 201);
    }

    // Melihat 1 project spesifik beserta detailnya
    public function show(string $id)
    {
        $project = Project::with('creator:id,name,email')->find($id);
        
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        return response()->json([
            'message' => 'Success fetching project',
            'data' => $project
        ]);
    }

    // Mengedit project
    public function update(Request $request, string $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|in:active,archived,completed',
        ]);

        $project->update($request->all());

        return response()->json([
            'message' => 'Project successfully updated',
            'data' => $project
        ]);
    }

    // Menghapus project
    public function destroy(string $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $project->delete();

        return response()->json([
            'message' => 'Project successfully deleted'
        ]);
}
}