<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BugController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;

// --------------------------------------------------------
// 1. RUTE PUBLIK (Tidak perlu login / token)
// --------------------------------------------------------
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// --------------------------------------------------------
// 2. RUTE PROTECTED (Wajib Login & Bawa Token Sanctum)
// --------------------------------------------------------
Route::middleware('auth:sanctum')->group(function () {
    
    // Rute Profil & Autentikasi
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Rute Dashboard Statistik
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Rute Utama (CRUD API)
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('bugs', BugController::class);
    Route::apiResource('comments', CommentController::class)->only(['store', 'destroy']);
    
    // ----------------------------------------------------
    // 3. RUTE KHUSUS ADMIN (Wajib Login + Role 'admin')
    // ----------------------------------------------------
    Route::middleware('admin')->group(function () {
        // Fitur kembalikan data dari "tong sampah" hanya boleh diakses Admin
        Route::post('/bugs/{id}/restore', [BugController::class, 'restore']);
        
        // (Opsional: Nanti kalau omm mau rute hapus project/bug hanya untuk admin, 
        // bisa dipindah atau dideklarasikan ulang di dalam blok ini)
    });


    Route::get('/test-email', function () {
    try {
        \Illuminate\Support\Facades\Mail::raw('Halo omm! Ini adalah test email langsung dari rute Laravel.', function($msg) {
            $msg->to('admin@qora.com')->subject('Test Tembak Email Mailtrap');
        });
        return response()->json(['status' => 'SUKSES! Jalan ke Mailtrap terbuka!']);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'GAGAL!', 
            'error_pesan' => $e->getMessage()
        ]);
    }
});

});