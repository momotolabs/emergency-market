<?php

use App\Http\Controllers\Client\Auth;
use App\Http\Controllers\Client\Dashboard;
use App\Http\Controllers\Client\Dashboard\DashboardController;
use App\Http\Controllers\Client\Directory;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\Provider;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::as('login')->group(function () {
        Route::get('login', [Auth\AuthenticatedSessionController::class, 'create']);
        Route::post('login', [Auth\AuthenticatedSessionController::class, 'store'])->name('.store');
    });

    Route::as('join.')->group(function () {
        Route::get('join', [Auth\RegisteredUserController::class, 'create'])->name('index');
        Route::post('join', [Auth\RegisteredUserController::class, 'store'])->name('store');
    });

    Route::get('forgot-password', [Auth\PasswordResetLinkController::class, 'create'])->name('forgot-password');
    Route::post('forgot-password', [Auth\PasswordResetLinkController::class, 'store']);

    Route::get('/reset-password/{token}', [Auth\NewPasswordController::class, 'create'])->middleware('guest')->name('password.reset');
    Route::post('/reset-password', [Auth\NewPasswordController::class, 'store'])->name('password.store');

    Route::get('/email-resend', [Auth\EmailVerificationNotificationController::class, 'sendLink'])->name('email.show');
    Route::post('/email-resend', [Auth\EmailVerificationNotificationController::class, 'sendLinkEmail'])->name('email.link');
});

Route::get('/email/verify/{id}/{hash}', Auth\VerifyEmailController::class)->name('verification.verify');

Route::middleware(['auth'])->group(function () {
    Route::get('admin/{invoice}/pdf', [Dashboard\InvoiceBuilder\IndexController::class, 'pdf'])->name('admin.invoice.pdf');
    Route::get('/verification-message', [Auth\EmailVerificationNotificationController::class, 'create'])->name('verification.notice');
});

Route::middleware(['auth', 'auth-provider', 'verified'])->group(function () {
    Route::post('logout', [Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/provider/complete-form', [Provider\CompleteFormController::class, 'create'])->name('provider.first-time');
    Route::get('/provider/resources-form', [Provider\ResourcesFormController::class, 'create'])->name('provider.resources');
    Route::put('/provider/complete-form', [Provider\CompleteFormController::class, 'update'])->name('provider.first-time.update');

    Route::put('/provider/resources-form', [Provider\ResourcesFormController::class, 'update'])->name('provider.resources.update');

    Route::middleware('first-time')->group(function () {
        Route::prefix('dashboard')->as('dashboard.')->group(function () {
            Route::prefix('extras')->as('extras.')->group(function() {
                Route::get('/', [Dashboard\Extras\IndexController::class, 'index'])->name('index');
                Route::get('/samplecontract', [Dashboard\Extras\IndexController::class, 'download'])->name('download');
            });
            Route::prefix('profile')->as('profile.')->group(function () {
                Route::get('/resources', [Dashboard\Profile\ResourcesController::class, 'create'])->name('resources.index');
                Route::put('/resources', [Dashboard\Profile\ResourcesController::class, 'update'])->name('resources.update');
                Route::get('/multimedia', [Dashboard\Profile\MultimediaController::class, 'create'])->name('multimedia.create');
                Route::post('/multimedia/avatar', [Dashboard\Profile\MultimediaController::class, 'avatar'])->name('multimedia.avatar');
                Route::post('/multimedia/gallery', [Dashboard\Profile\MultimediaController::class, 'gallery'])->name('multimedia.gallery');
                Route::put('/multimedia/main-video', [Dashboard\Profile\MultimediaController::class, 'mainVideo'])->name('multimedia.video');
                Route::delete('/multimedia/gallery/{multimedia}', [Dashboard\Profile\MultimediaController::class, 'deleteGallery'])->name('multimedia.gallery.delete');

                Route::get('/', [Dashboard\Profile\IndexController::class, 'create'])->name('index');
                Route::put('/', [Dashboard\Profile\IndexController::class, 'update'])->name('update');
            });

            Route::prefix('builder')->as('builder.')->group(function () {
                Route::get('/', [Dashboard\ContractBuilder\IndexController::class, 'index'])->name('index');
                Route::get('/create', [Dashboard\ContractBuilder\IndexController::class, 'create'])->name('create');
                Route::post('/', [Dashboard\ContractBuilder\IndexController::class, 'store'])->name('store');
                Route::get('/{contract}/edit', [Dashboard\ContractBuilder\IndexController::class, 'edit'])->name('edit');
                Route::put('/{contract}', [Dashboard\ContractBuilder\IndexController::class, 'update'])->name('update');
                Route::delete('/{contract}', [Dashboard\ContractBuilder\IndexController::class, 'delete'])->name('delete');
                Route::put('/{contract}/default', [Dashboard\ContractBuilder\IndexController::class, 'makeDefault'])->name('default');
                Route::get('/{contract}/show', [Dashboard\ContractBuilder\IndexController::class, 'show'])->name('show');
                Route::get('/{contract}/pdf', [Dashboard\ContractBuilder\IndexController::class, 'pdf'])->name('pdf');
            });

            Route::prefix('invoices')->as('invoices.')->group(function () {
                Route::get('/', [Dashboard\InvoiceBuilder\IndexController::class, 'index'])->name('index');
                Route::get('/{id}/create', [Dashboard\InvoiceBuilder\IndexController::class, 'create'])->name('create');
                Route::post('/{insuredcontract}', [Dashboard\InvoiceBuilder\IndexController::class, 'store'])->name('store');
                Route::get('/{invoice}/edit', [Dashboard\InvoiceBuilder\IndexController::class, 'edit'])->name('edit');
                Route::post('/{invoice}/update', [Dashboard\InvoiceBuilder\IndexController::class, 'update'])->name('update');
                Route::get('/{invoice}/pdf', [Dashboard\InvoiceBuilder\IndexController::class, 'pdf'])->name('pdf');
                Route::get('/{invoice}/show', [Dashboard\InvoiceBuilder\IndexController::class, 'show'])->name('show');
            });

            Route::prefix('contracts')->as('contracts.')->group(function () {
                Route::get('/open', [DashboardController::class, 'contractsOpen'])->name('open');
                Route::get('/viewed', [DashboardController::class, 'contractsViewed'])->name('viewed');
                Route::get('/closed', [DashboardController::class, 'contractsClosed'])->name('closed');
                Route::get('/{insuredcontract}/show', [DashboardController::class, 'showContract'])->name('show');
            });
        });
    });
});

Route::get('/cities/{state}', [HomeController::class, 'cities'])->name('cities');

/* provider directory */
Route::get('/provider', [Directory\IndexController::class, 'providerFilter'])->name('provider');

Route::get('/{kind}/{state}/{city}/{company:slug}/contract', [Directory\IndexController::class, 'contractLink'])->name('contract-link');

Route::prefix('directory')->as('directory.')->group(function () {
    Route::get('/', [Directory\IndexController::class, 'index'])->name('index');

    Route::get('/contract/{id}/pdf', [Directory\IndexController::class, 'complete'])->name('contract.complete');

    Route::get('/{state}/{city}/{company:slug}', [Directory\IndexController::class, 'contractDescription'])->name('contract');
    Route::get('/{state}/{city}/{company:slug}/hire', [Directory\IndexController::class, 'hireContract'])->name('hire');
    Route::post('/{company}', [Directory\IndexController::class, 'store'])->name('contract.store');
    Route::get('/contract/{insuredContract}', [Directory\IndexController::class, 'contractShow'])->name('contract.show');
    Route::put('/contract/{insuredcontract}', [Directory\IndexController::class, 'contractSign'])->name('contract.sign');
});

Route::get('/welcome', [HomeController::class, 'welcome'])->name('welcome');
Route::get('/test', [HomeController::class, 'test'])->name('test');
Route::get('/terms-of-services', [HomeController::class, 'termOfService'])->name('terms-of-service');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/', [HomeController::class, 'index'])->name('home');

// data
//Route::prefix('admin')->group(function () {
//    Route::prefix('companies')->group(function () {
//        Route::get('/', \App\Http\Livewire\Company\ListCompanies::class);
//        Route::get('/edit/{record}', \App\Http\Livewire\Company\EditCompanies::class)->name('companies-edit');
//    });
//});

// require __DIR__ . '/auth.php';
