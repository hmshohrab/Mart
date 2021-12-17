<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\DashboardController;
 use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\SessionController;


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

Route::get('/clear', function () {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');

    return "Cleared!";
});
Route::get('/migrate', function () {
    try {
        Artisan::call('migrate');
        $message = 'Migration Success!';
    } catch (Exception $e) {
        $message = $e->getMessage();
    }

    echo $message;
});
Route::get('/optimizeClear', function () {
    try {
        Artisan::call('optimize:clear');
        $message = 'Optimization Success!';
    } catch (Exception $e) {
        $message = $e->getMessage();
    }

    echo $message;
});
Route::middleware(['admin'])->group(function () {
});

/* Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    } else {
        return view('auth.login');
    }
}); */

Route::get('/home', function () {
    return redirect()->route('admin.dashboard');
})->name('home');

//Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(
    function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboardView'])->name('dashboard')->middleware('admin');
        Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    }
);

Route::prefix('admin')->name('admin.')->group(
    function () {
        Route::get('/login', [UserController::class, 'loginView'])->name('login');
        Route::get('/dashboard', [DashboardController::class, 'dashboardView'])->name('dashboard')->middleware('admin');
        Route::get('/verify', [UserController::class,'verifyView'])->name('verifyView');
        Route::post('/verify', [UserController::class,'verify'])->name('verify');
        Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    }
);


Route::post('/login', [UserController::class, 'login']);

Route::post('/register', [UserController::class, 'register']);


Route::get('/sendEmail', [App\Http\Controllers\EmailController::class, 'createCompose']);
Route::post('/sendEmail', [App\Http\Controllers\EmailController::class, 'basic_email']);


//Session 
Route::get('/session/get',[SessionController::class, 'sessionGet']);
Route::get('/session/put',[SessionController::class, 'sessionPut']);
Route::get('/session/forget',[SessionController::class, 'sessionDelete']);