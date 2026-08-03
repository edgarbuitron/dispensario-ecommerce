<?php

use Illuminate\Support\Facades\Route;

// Rutas pÃºblicas
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/about', [\App\Http\Controllers\HomeController::class, 'about'])->name('about');
Route::get('/contact', [\App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [\App\Http\Controllers\HomeController::class, 'sendContact'])->name('contact.send');
Route::get('/faq', [\App\Http\Controllers\HomeController::class, 'faq'])->name('faq');
Route::get('/terms', [\App\Http\Controllers\HomeController::class, 'terms'])->name('terms');
Route::get('/privacy', [\App\Http\Controllers\HomeController::class, 'privacy'])->name('privacy');
Route::get('/shipping', [\App\Http\Controllers\HomeController::class, 'shipping'])->name('shipping');
Route::get('/returns', [\App\Http\Controllers\HomeController::class, 'returns'])->name('returns');

// CatÃ¡logo
Route::get('/catalog', [\App\Http\Controllers\CatalogController::class, 'index'])->name('catalog.index');
Route::get('/product/{slug}', [\App\Http\Controllers\CatalogController::class, 'show'])->name('product.show');
Route::get('/category/{slug}', [\App\Http\Controllers\CatalogController::class, 'byCategory'])->name('category.show');
Route::get('/brand/{slug}', [\App\Http\Controllers\CatalogController::class, 'byBrand'])->name('brand.show');
Route::get('/search', [\App\Http\Controllers\CatalogController::class, 'quickSearch'])->name('search');

// Carrito
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{cartItem}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{cartItem}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/coupon', [\App\Http\Controllers\CartController::class, 'applyCoupon'])->name('cart.coupon');
Route::get('/cart/mini', [\App\Http\Controllers\CartController::class, 'getCartMini'])->name('cart.mini');

// VerificaciÃ³n de edad
Route::get('/age-gate', function () {
    return view('client.age-gate');
})->name('age-gate.show');

Route::post('/age-gate/verify', function (\Illuminate\Http\Request $request) {
    $request->validate(['age_verified' => 'required|accepted']);
    session(['age_verified' => true]);
    return redirect()->route('home');
})->name('age-gate.verify');

// Google OAuth - SOLO PARA CLIENTES
Route::get('/auth/google', [\App\Http\Controllers\GoogleAuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [\App\Http\Controllers\GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback');

// Rutas autenticadas de clientes
Route::middleware(['auth'])->group(function () {
    // Ã“rdenes
    Route::get('/checkout', [\App\Http\Controllers\OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [\App\Http\Controllers\OrderController::class, 'process'])->name('checkout.process');
    Route::get('/order/{order}/payment', [\App\Http\Controllers\OrderController::class, 'payment'])->name('order.payment');
    Route::post('/order/{order}/proof', [\App\Http\Controllers\OrderController::class, 'uploadProof'])->name('order.proof.upload');
    Route::get('/order/{order}/confirmation', [\App\Http\Controllers\OrderController::class, 'confirmation'])->name('order.confirmation');
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'myOrders'])->name('orders.index');
    Route::get('/order/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('order.show');
    Route::get('/order/{order}/tracking', [\App\Http\Controllers\OrderController::class, 'tracking'])->name('order.tracking');
    Route::get('/order/{order}/invoice', [\App\Http\Controllers\OrderController::class, 'invoice'])->name('order.invoice');
    
    // Comprobantes de transferencia
    Route::get('/order/{order}/upload-proof', [\App\Http\Controllers\ProofController::class, 'clientUploadForm'])->name('order.upload-proof.form');
    Route::post('/order/{order}/upload-proof', [\App\Http\Controllers\ProofController::class, 'clientUploadProof'])->name('order.upload-proof');

    // Favoritos
    Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}/toggle', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Reseñas
    Route::post('/product/{product}/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');

    // Perfil
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/addresses', [\App\Http\Controllers\ProfileController::class, 'addresses'])->name('profile.addresses');
    Route::get('/profile/addresses/create', [\App\Http\Controllers\ProfileController::class, 'addressCreate'])->name('profile.addresses.create');
    Route::post('/profile/addresses', [\App\Http\Controllers\ProfileController::class, 'addressStore'])->name('profile.addresses.store');
    Route::get('/profile/addresses/{address}/edit', [\App\Http\Controllers\ProfileController::class, 'addressEdit'])->name('profile.addresses.edit');
    Route::post('/profile/addresses/{address}', [\App\Http\Controllers\ProfileController::class, 'addressUpdate'])->name('profile.addresses.update');
    Route::post('/profile/addresses/{address}/delete', [\App\Http\Controllers\ProfileController::class, 'addressDelete'])->name('profile.addresses.delete');
    Route::get('/profile/history', [\App\Http\Controllers\ProfileController::class, 'history'])->name('profile.history');
    Route::get('/profile/orders', [\App\Http\Controllers\OrderController::class, 'myOrders'])->name('profile.orders');
});

// Rutas de autenticaciÃ³n (Laravel Breeze)
// SOLO PARA CLIENTES - Google OAuth DESHABILITADO PARA ADMIN
require __DIR__.'/auth.php';

// Admin Panel
Route::prefix('admin')->name('admin.')->group(function () {
    // Login
    Route::get('/login', [\App\Http\Controllers\Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])
        ->middleware('throttle:5,1')->name('login.submit');

    // Verificación en dos pasos (segundo paso del login, todavía sin sesión de admin)
    Route::get('/two-factor-challenge', [\App\Http\Controllers\Admin\TwoFactorChallengeController::class, 'show'])->name('two-factor.show');
    Route::post('/two-factor-challenge', [\App\Http\Controllers\Admin\TwoFactorChallengeController::class, 'verify'])
        ->middleware('throttle:5,1')->name('two-factor.verify');

    // Rutas protegidas
    Route::middleware(['auth:admin'])->group(function () {

        // Dashboard
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Seguridad / 2FA (disponible para cualquier admin sobre su propia cuenta)
        Route::get('security', [\App\Http\Controllers\Admin\TwoFactorSettingsController::class, 'show'])->name('security.index');
        Route::post('security/enable', [\App\Http\Controllers\Admin\TwoFactorSettingsController::class, 'enable'])->name('security.enable');
        Route::post('security/disable', [\App\Http\Controllers\Admin\TwoFactorSettingsController::class, 'disable'])->name('security.disable');

        // Productos
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::post('products/{productImage}/delete-image', [\App\Http\Controllers\Admin\ProductController::class, 'deleteImage'])->name('products.deleteImage');

        // CategorÃ­as
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)
            ->except(['show']);

        // Marcas
        Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class)
            ->except(['show']);

        // Órdenes
        Route::get('orders/export', [\App\Http\Controllers\Admin\OrderController::class, 'export'])->name('orders.export');
        Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class, ['only' => ['index', 'show']]);
        Route::post('orders/{order}/approve-proof', [\App\Http\Controllers\Admin\OrderController::class, 'approveProof'])->name('orders.approveProof');
        Route::post('orders/{order}/reject-proof', [\App\Http\Controllers\Admin\OrderController::class, 'rejectProof'])->name('orders.rejectProof');
        Route::post('orders/{order}/update-status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::post('orders/{order}/add-shipment', [\App\Http\Controllers\Admin\OrderController::class, 'addShipment'])->name('orders.addShipment');
        
        // Comprobantes de transferencia
        Route::get('proofs', [\App\Http\Controllers\ProofController::class, 'adminIndex'])->name('proofs.index');
        Route::post('proofs/{proof}/approve', [\App\Http\Controllers\ProofController::class, 'approve'])->name('proofs.approve');
        Route::post('proofs/{proof}/reject', [\App\Http\Controllers\ProofController::class, 'reject'])->name('proofs.reject');

        // Cupones
        Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class)
            ->except(['show']);

        // Banners
        Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class)
            ->except(['show']);

        // ConfiguraciÃ³n
        Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
        Route::get('settings/bank-accounts', [\App\Http\Controllers\Admin\SettingController::class, 'bankAccounts'])->name('settings.bank-accounts');
        Route::post('settings/bank-accounts', [\App\Http\Controllers\Admin\SettingController::class, 'addBankAccount'])->name('settings.bankAccounts.add');
        Route::post('settings/bank-accounts/{bankAccount}', [\App\Http\Controllers\Admin\SettingController::class, 'updateBankAccount'])->name('settings.bankAccounts.update');
        Route::post('settings/bank-accounts/{bankAccount}/delete', [\App\Http\Controllers\Admin\SettingController::class, 'deleteBankAccount'])->name('settings.bankAccounts.delete');
    });
});


// Simple logout route - GET only
Route::get('/admin/logout-now', function () {
    Auth::guard('admin')->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/admin/login')->with('success', 'Sesión cerrada');
});
