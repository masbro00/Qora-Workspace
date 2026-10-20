<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menghitung Total Keseluruhan
        $totalProjects = Project::count();
        $totalBugs = Bug::count();
        $totalUsers = User::count();

        // 2. Menghitung Bug berdasarkan Status (Untuk Grafik Pie/Donut)
        $bugsByStatus = [
            'open' => Bug::where('status', 'open')->count(),
            'in_progress' => Bug::where('status', 'in_progress')->count(),
            'resolved' => Bug::where('status', 'resolved')->count(),
            'closed' => Bug::where('status', 'closed')->count(),
        ];

        // 3. Menghitung Bug berdasarkan Prioritas (Untuk Grafik Bar)
        $bugsByPriority = [
            'low' => Bug::where('priority', 'low')->count(),
            'medium' => Bug::where('priority', 'medium')->count(),
            'high' => Bug::where('priority', 'high')->count(),
            'urgent' => Bug::where('priority', 'urgent')->count(),
        ];

        return response()->json([
            'message' => 'Dashboard statistics retrieved successfully',
            'data' => [
                'totals' => [
                    'projects' => $totalProjects,
                    'bugs' => $totalBugs,
                    'users' => $totalUsers,
                ],
                'bugs_by_status' => $bugsByStatus,
                'bugs_by_priority' => $bugsByPriority,
            ]
        ]);
    }
}