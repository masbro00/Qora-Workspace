<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BugStatusUpdated;

class BugController extends Controller
{
    // 1. Melihat semua Bug (Read All) dengan Fitur Filter, Search & Pagination
    public function index(Request $request)
    {
        $query = Bug::with(['project:id,name', 'reporter:id,name,role', 'assignee:id,name,role']);

        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'ILIKE', '%' . $searchTerm . '%')
                  ->orWhere('description', 'ILIKE', '%' . $searchTerm . '%');
            });
        }

        // Tampilkan 5 data per halaman (Pagination)
        $bugs = $query->latest()->paginate(5);
        
        return response()->json([
            'message' => 'Success fetching bugs',
            'data' => $bugs
        ]);
    }

    // 2. Melaporkan Bug baru (Create) dengan Upload File
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'severity' => 'sometimes|in:low,medium,high,critical',
            'priority' => 'sometimes|in:low,medium,high,urgent',
            // UBAH DISINI: Ganti evidence_file jadi evidence
            'evidence' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048' 
        ]);

        $evidencePath = null;
        
        // UBAH DISINI JUGA: Ganti evidence_file jadi evidence
        if ($request->hasFile('evidence')) { 
            $path = $request->file('evidence')->store('evidence', 'public');
            // Path otomatis dikonversi jadi URL lengkap oleh Laravel
            $evidencePath = asset('storage/' . $path); 
        }

        $bug = Bug::create([
            'project_id' => $request->project_id,
            'title' => $request->title,
            'description' => $request->description,
            'severity' => $request->severity ?? 'medium',
            'priority' => $request->priority ?? 'medium',
            'status' => 'open',
            'reported_by' => $request->user()->id,
            'evidence' => $evidencePath,
        ]);

        return response()->json([
            'message' => 'Bug successfully reported with evidence',
            'data' => $bug
        ], 201);
    }

    // 3. Melihat detail 1 Bug (Read One)
    public function show(string $id)
    {
        $bug = Bug::with([
            'project:id,name', 
            'reporter:id,name', 
            'assignee:id,name',
            'activities.user:id,name' // Menarik data sejarah aktivitas
        ])->find($id);

        if (!$bug) {
            return response()->json(['message' => 'Bug not found'], 404);
        }

        return response()->json([
            'message' => 'Success fetching bug detail',
            'data' => $bug
        ]);
    }

    // 4. Mengedit status/detail Bug (Update) - DENGAN LOG ACTIVITY & EMAIL
    public function update(Request $request, string $id)
    {
        $bug = Bug::find($id);

        if (!$bug) {
            return response()->json(['message' => 'Bug not found'], 404);
        }

        // Simpan status lama sebelum diupdate
        $oldStatus = $bug->status;

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'severity' => 'sometimes|in:low,medium,high,critical',
            'priority' => 'sometimes|in:low,medium,high,urgent',
            'status' => 'sometimes|in:open,in_progress,resolved,closed',
            'assigned_to' => 'sometimes|nullable|exists:users,id',
        ]);

        $bug->update($request->all());

        // CATAT KE TABEL ACTIVITIES & KIRIM EMAIL JIKA STATUS BERUBAH
        if ($request->has('status') && $oldStatus !== $request->status) {
            
            // 1. Catat ke Log Activity
            Activity::create([
                'bug_id' => $bug->id,
                'user_id' => $request->user()->id,
                'action' => 'Status Updated',
                'description' => "Changed status from $oldStatus to {$request->status}"
            ]);

            // 2. Kirim Email Notifikasi via Mailtrap
            $bug->load('reporter'); 
            if ($bug->reporter && $bug->reporter->email) {
                Mail::to($bug->reporter->email)->send(new BugStatusUpdated($bug, $oldStatus));
            }
        }

        return response()->json([
            'message' => 'Bug successfully updated',
            'data' => $bug->load(['assignee:id,name', 'reporter:id,name', 'activities.user:id,name'])
        ]);
    }

    // 5. Menghapus Bug dari sistem (Delete / Soft Delete)
    public function destroy(string $id)
    {
        $bug = Bug::find($id);

        if (!$bug) {
            return response()->json(['message' => 'Bug not found'], 404);
        }

        $bug->delete();

        return response()->json([
            'message' => 'Bug successfully deleted'
        ]);
    }

    // 6. Mengembalikan Bug yang terhapus (Restore)
    public function restore(string $id)
    {
        $bug = Bug::onlyTrashed()->find($id);

        if (!$bug) {
            return response()->json(['message' => 'Bug not found in trash'], 404);
        }

        $bug->restore();

        return response()->json([
            'message' => 'Bug successfully restored',
            'data' => $bug
        ]);
    }
}