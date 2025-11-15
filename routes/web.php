<?php

use App\Http\Controllers\ToDoListController;
use Illuminate\Support\Facades\Route;

// Route::get('/to_do_list', function () {
//     return view('to_do_list.index');
// });

# Route::resource('to_do_list', ToDoListController::class);

Route::get('to_do_list', [ToDoListController::class, 'index'])->name('to_do_list.index');
Route::post('to_do_list', [ToDoListController::class, 'store'])->name('to_do_list.store');
Route::put('to_do_list/{id}', [ToDoListController::class, 'update'])->name('to_do_list.update');
Route::delete('to_do_list/{id}', [ToDoListController::class, 'destroy'])->name('to_do_list.destroy');
