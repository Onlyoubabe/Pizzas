<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('mainp');



Route::view('/login', 'login')->name('login');
Route::view('/register', 'register')->name('register');
Route::view('/nosotros', 'nosotros')->name('nosotros');

// Rutas de contacto
Route::get('/contacto', [ContactController::class, 'showForm'])->name('contacto');
Route::post('/contacto', [ContactController::class, 'sendMessage'])->name('contacto.enviar');
// Ruta protegida para el menú (solo usuarios autenticados pueden acceder)
Route::middleware(['auth'])->group(function () {
    Route::get('/menu', [PizzaController::class, 'menu'])->name('menu');
});
Route::post('/validar-registro', [LoginController::class, 'register'])->name('validar-registro');
Route::post('/inicia-sesion', [LoginController::class, 'login'])->name('inicia-sesion');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/forgotPassword', [PasswordResetController::class, 'showForgotPasswordForm'])->name('forgotpassword');
Route::post('/forgotPassword', [PasswordResetController::class, 'sendResetLinkEmail']);
Route::get('/resetPassword/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/resetPassword', [PasswordResetController::class, 'resetPassword']);


// Rutas para autenticación con Google
Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Rutas para usuarios autenticados
Route::middleware(['auth'])->group(function () {
    // Rutas para todos los usuarios autenticados
    
    // Rutas solo para admins
    Route::middleware(['role:admin,empleado'])->group(function () {
        // Rutas de pizzas (CRUD)
        Route::get('/pizzas', [PizzaController::class, 'index'])->name('pizzas.index');
        Route::post('/pizzas', [PizzaController::class, 'store'])->name('pizzas.store');
        Route::delete('/pizzas/{pizza}', [PizzaController::class, 'destroy'])->name('pizzas.destroy');
        Route::put('/pizzas/{pizza}', [PizzaController::class, 'update'])->name('pizzas.update');
        
    });

    // Rutas del carrito (accesibles para todos)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');

// Rutas de checkout y pago
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

// Rutas de órdenes
Route::get('/order/confirmation/{order}', [OrderController::class, 'confirmation'])->name('order.confirmation');

// Rutas para usuarios autenticados
Route::middleware(['auth'])->group(function () {
    // Órdenes del usuario
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    
    // Rutas para admins y empleados
    Route::middleware(['role:admin,empleado'])->group(function () {
        // Gestión de órdenes
        Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
        Route::put('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status');
    });
});
});