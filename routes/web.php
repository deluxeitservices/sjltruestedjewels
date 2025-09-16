<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExternalCatalogController;

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/metal/{metal}', [CatalogController::class,'index'])->name('catalog.metal');
Route::get('/product/{slug}', [ProductController::class,'show'])->name('product.show');

// External catalog (from your API)
Route::get('/bullion', [ExternalCatalogController::class,'index'])->name('ext.catalog');
Route::get('/bullion/product/{slug}', [ExternalCatalogController::class,'show'])->name('ext.product');

// Live price (AJAX)
Route::get('/api/bullion/products/{id}/price', [ExternalCatalogController::class,'livePrice'])->name('ext.product.price');

// Add to cart (external -> upsert local -> cart)
Route::post('/bullion/cart/add', [ExternalCatalogController::class,'addToCart'])->name('ext.cart.add');

// API for live prices
Route::get('/api/quotes/summary', [QuoteController::class,'summary']);
Route::get('/api/products/{id}/price', [QuoteController::class,'productPrice']);

// Cart
Route::get('/cart', [CartController::class,'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class,'add'])->name('cart.add');
Route::get('/cart/add',  [CartController::class,'addFromGet'])->name('cart.add.get');//Route::post('/cart/add', [CartController::class,'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class,'update'])->name('cart.update');
Route::get('/cart/price', [CartController::class,'price'])->name('cart.price');
Route::post('/cart/remove', [CartController::class,'remove'])->name('cart.remove');

// New AJAX endpoints for qty +/- and remove
Route::post('/cart/item/update', [CartController::class,'updateAjax'])->name('cart.updateAjax');
Route::post('/cart/item/remove', [CartController::class,'removeAjax'])->name('cart.removeAjax');

// Checkout (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class,'show'])->name('checkout.show');
    Route::get('/checkout/success', [CheckoutController::class,'success'])->name('checkout.success');
    Route::get('/checkout/cancel',  [CheckoutController::class,'cancel'])->name('checkout.cancel');
});
// Checkout
//Route::get('/checkout', [CheckoutController::class, 'show'])->middleware('auth')->name('checkout.go');
//Route::post('/checkout', [CheckoutController::class,'checkout'])->name('checkout.go');
Route::get('/checkout/success', [CheckoutController::class,'success'])->name('checkout.success');

// Stripe webhook
Route::post('/stripe/webhook', [StripeWebhookController::class,'handle'])->name('stripe.webhook');


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// routes/web.php
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');


require __DIR__.'/auth.php';

