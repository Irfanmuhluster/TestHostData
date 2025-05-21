<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.product');
    } elseif (auth()->user()->role === 'member') {
        return redirect()->route('member.product');
    }
    abort(403, 'Unauthorized');
});


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/home', [ProductController::class,'index'])->name('admin.product');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'member'])->group(function () {
    Route::post('/member/cart-store', [CartController::class, 'store'])->name('cart.store');
    Route::get('/member/cart-item', [CartController::class, 'cart'])->name('cart-item');
    Route::put('/member/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/member/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/member/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/member/cart/transactionsuccess/{id}', [CartController::class, 'transaction'])->name('member.transaction'); 
    Route::get('/member/dashboard', [MemberController::class, 'index'])->name('dashboard.index');
    Route::get('/member/deposit', [DepositController::class, 'index'])->name('deposit.index');
    Route::get('/member/deposit/create', [DepositController::class, 'create'])->name('member.deposit.create');
    Route::post('/member/deposit/store', [DepositController::class, 'store'])->name('member.deposit.store');
    Route::post('/member/deposit/callback', [DepositController::class, 'callback'])->name('member.deposit.callback');
    Route::post('/member/deposit/proceed', [DepositController::class, 'proceed'])->name('member.deposit.proceed');
});


Route::get('/member/product', [ProductController::class, 'index'])->name('member.product');


require __DIR__.'/auth.php';

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
