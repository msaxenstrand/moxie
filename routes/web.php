<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return Inertia\Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/admin/documents', function () {
        return Inertia\Inertia::render('Documents', [
            'documents' => \App\Models\Document::all(),
            'documentTypes' => \App\Models\DocumentType::all()
        ]);
    })->name('documents');

    Route::resources([
        'documents' => \App\Http\Controllers\DocumentController::class,
        'document-types' => \App\Http\Controllers\DocumentTypeController::class
    ]);

    Route::redirect('/admin', '/admin/documents');
});
