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
use App\Http\Controllers\SellNowController;
use Illuminate\Http\Request;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SjlContactController;
use App\Http\Controllers\OrderController;

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/metal/{metal}', [CatalogController::class,'index'])->name('catalog.metal');
Route::get('/product/{slug}', [ProductController::class,'show'])->name('product.show');


Route::get('/contact', [ProfileController::class,'contact'])->name('contact');
Route::post('/contact', [SjlContactController::class, 'store'])->name('contact.store');
Route::get('/about-us', [ProfileController::class,'about'])->name('about');

// routes/web.php
Route::get('/orders/{order}/declaration', [OrderController::class, 'showCompulsory'])
    ->name('orders.declaration'); // <- signed URL required

Route::post('/orders/{order}/declaration', [OrderController::class, 'submitCompulsory'])
    ->name('orders.declaration.submit');


// routes/web.php

Route::get('/orders/{order}/pdf', [OrderController::class, 'downloadPdf'])
    ->name('orders.pdf')
    ->middleware('auth'); // optional, but recommended


// Checkout (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class,'show'])->name('checkout.show');
    Route::get('/checkout/success', [CheckoutController::class,'success'])->name('checkout.success');
    Route::get('/checkout/cancel',  [CheckoutController::class,'cancel'])->name('checkout.cancel');
});
// Checkout
//Route::get('/checkout', [CheckoutController::class, 'show'])->middleware('auth')->name('checkout.go');
//Route::post('/checkout', [CheckoutController::class,'checkout'])->name('checkout.go');
// Route::get('/checkout/success', [CheckoutController::class,'success'])->name('checkout.success');

// Stripe webhook
Route::post('/stripe/webhook', [StripeWebhookController::class,'handle'])->name('stripe.webhook');

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

// routes/web.php
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

Route::get('/sell-now', [SellNowController::class, 'index'])->name('sell.index');
Route::post('/sell-now', [SellNowController::class, 'store'])->name('sell.store');
// AJAX: price calculator (live price x purity x weight x qty)
Route::post('/sell-now/calc', [SellNowController::class, 'calc'])->name('sell.calc');

Route::post('/favorites/unfav/{id}', [FavoriteController::class, 'unfav'])->name('favorites.unfav');
Route::middleware('auth')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::delete('/favorites/{externalId}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

});

Route::get('/logout', function (Request $request) {
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/'); // Redirect to homepage or login page after logout
})->name('logout');

// Route for processing the account page(requires login)
Route::middleware('auth')->get('/account', [ProfileController::class, 'account'])->name('account');
Route::middleware('auth')->get('/order', [ProfileController::class, 'order'])->name('order');
Route::middleware('auth')->get('/order/{id}', [ProfileController::class, 'orderDetail'])->name('order.details');

Route::middleware('auth')->get('/wishlist', [ProfileController::class, 'wishlist'])->name('wishlist');
Route::middleware('auth')->get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');

// Route for processing the user address update page(requires login)
Route::middleware('auth')->post('/update-address', [ProfileController::class, 'addressUpdate'])->name('update.address');
Route::post('/wishlist/toggle', [ExternalCatalogController::class, 'toggle'])->name('wishlist.toggle');




// External catalog (from your API)
Route::get('/{category}', [ExternalCatalogController::class,'index'])->name('ext.catalog');
// Route::get('/bullion', [ExternalCatalogController::class,'index'])->name('ext.catalog');
// Route::get('/preowned', [ExternalCatalogController::class,'index'])->name('ext.catalog');
// Route::get('/diamond', [ExternalCatalogController::class,'index'])->name('ext.catalog');
Route::get('/{category}/product/{slug}', [ExternalCatalogController::class,'show'])->name('ext.product');
// Route::get('/preowned/product/{slug}', [ExternalCatalogController::class,'show'])->name('ext.product');
// Route::get('/diamond/product/{slug}', [ExternalCatalogController::class,'show'])->name('ext.product');

// Live price (AJAX)
Route::get('/api/{category}/products/{id}/price', [ExternalCatalogController::class,'livePrice'])->name('ext.product.price');
// Route::get('/api/preowned/products/{id}/price', [ExternalCatalogController::class,'livePrice'])->name('ext.product.price');
// Route::get('/api/diamond/products/{id}/price', [ExternalCatalogController::class,'livePrice'])->name('ext.product.price');

// Add to cart (external -> upsert local -> cart)
Route::post('/{category}/cart/add', [ExternalCatalogController::class,'addToCart'])->name('ext.cart.add');
// Route::post('/preowned/cart/add', [ExternalCatalogController::class,'addToCart'])->name('ext.cart.add');
// Route::post('/diamond/cart/add', [ExternalCatalogController::class,'addToCart'])->name('ext.cart.add');

// API for live prices
Route::get('/api/quotes/summary', [QuoteController::class,'summary']);
Route::get('/api/products/{id}/price', [QuoteController::class,'productPrice']);




// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

