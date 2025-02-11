<?php

//use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

$idRegex = '[0-9]+' ;
$slugRegex = '[0-9a-z\-]+'; 

Route::get('/', [App\Http\Controllers\HomeController::class,'index']);
Route::get('/biens', [App\Http\Controllers\PropertyController::class,'index'])->name('property.index');
Route::get('/biens/{slug}-{property}', [App\Http\Controllers\PropertyController::class,'show'])->name('property.show')->where([
    'property'=> $idRegex,
    'slug'=> $slugRegex
]);


Route::post('/biens/{property}/contact', [App\Http\Controllers\PropertyController::class, 'contact'])->name('property.contact')->where([
    'property'=> $idRegex,
]);


Route::get('/login', [App\Http\Controllers\AuthController::class,'login'])
    ->middleware('guest')
    ->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class,'doLogin']);
Route::delete('/logout', [App\Http\Controllers\AuthController::class,'logout'])
    ->middleware('auth')
    ->name('logout');



Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('property', \App\Http\Controllers\Admin\PropertyController::class)->except('show');
    Route::resource('option', \App\Http\Controllers\Admin\OptionController::class)->except('show');
    
//    Route::resource('image', \App\Http\Controllers\Admin\ImageController::class);
 //   Route::post('/admin/image/index', [\App\Http\Controllers\Admin\ImageController::class, 'up']);


    //Route::get('upload', function () {
    //    return view('images/upload');
    //});
    
    

    //   Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
 //   Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//require __DIR__.'/auth.php';
