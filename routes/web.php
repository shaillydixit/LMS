<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('frontend.user_dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
    Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');
});

Route::get('/admin/login',[AdminController::class, 'AdminLogin'])->name('admin.login');

Route::middleware(['auth', 'roles:admin'])->group(function(){
    Route::get('/admin/dashboard',[AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout',[AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/update', [AdminController::class, 'AdminProfileUpdate'])->name('admin.profile.update');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');


    Route::get('/category', [CategoryController::class, 'Index'])->name('category');
    Route::get('/add-category', [CategoryController::class, 'AddCategory'])->name('add.category');
    Route::post('/ajax-manage-category', [CategoryController::class, 'ManageCategory']);
    Route::get('/fetch-category', [CategoryController::class, 'FetchCategory']);
    Route::get('/edit-category/{id}', [CategoryController::class, 'EditCategory'])->name('edit.category');
    Route::post('/delete-category', [CategoryController::class, 'DeleteCategory']);

    Route::get('/subcategory', [SubcategoryController::class, 'Index'])->name('subcategory');
    Route::get('/add-subcategory', [SubcategoryController::class, 'AddSubcategory'])->name('add.subcategory');
    Route::post('/ajax-manage-subcategory', [SubcategoryController::class, 'ManageSubcategory']);
    Route::get('/fetch-subcategory', [SubcategoryController::class, 'FetchSubcategory']);
    Route::get('/edit-subcategory/{id}', [SubcategoryController::class, 'EditSubcategory'])->name('edit.subcategory');
    Route::post('/delete-subcategory', [SubcategoryController::class, 'DeleteSubcategory']);

});
Route::get('/instructor/login',[InstructorController::class, 'instructorLogin'])->name('instructor.login');

Route::middleware(['auth', 'roles:instructor'])->group(function(){
    Route::get('/instructor/dashboard',[InstructorController::class, 'InstructorDashboard'])->name('instructor.dashboard');
    Route::get('/instructor/logout',[InstructorController::class, 'InstructorLogout'])->name('instructor.logout');
    Route::get('/instructor/profile', [InstructorController::class, 'InstructorProfile'])->name('instructor.profile');
    Route::post('/instructor/profile/update', [InstructorController::class, 'InstructorProfileUpdate'])->name('instructor.profile.update');
    Route::get('/instructor/change/password', [InstructorController::class, 'InstructorChangePassword'])->name('instructor.change.password');
    Route::post('/instructor/password/update', [InstructorController::class, 'InstructorPasswordUpdate'])->name('instructor.password.update');

});
Route::get('/',[UserController::class, 'Index'])->name('index');

require __DIR__.'/auth.php';
