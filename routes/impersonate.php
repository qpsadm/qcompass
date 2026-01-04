<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\UserController as AdminUserController;

Route::middleware(['auth', 'admin'])->group(function () {

    Route::post(
        '/admin/users/{user}/impersonate',
        [AdminUserController::class, 'impersonate']
    )->name('admin.users.impersonate');

    Route::post(
        '/admin/impersonate/leave',
        [AdminUserController::class, 'leaveImpersonate']
    )->name('admin.users.impersonate.leave');
});
