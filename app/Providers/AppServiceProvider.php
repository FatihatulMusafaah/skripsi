<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade; // <-- Tambahkan baris ini di paling atas

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Set Locale & Timezone
        config(['app.locale' => 'id']);
        \Carbon\Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        // Tambahkan baris ini untuk mendaftarkan komponen layout Anda secara paksa
        Blade::component('app-layout', \App\View\Components\AppLayout::class);
        
        // JIKA CARA DI ATAS ERROR, gunakan cara alternatif yang lebih simpel ini:
        // Blade::component('components.app-layout', 'app-layout');
    }
}
