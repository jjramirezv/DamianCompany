<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureLocalCertificateBundle();
        
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
            URL::forceRootUrl(config('app.url'));
        }
    }

    private function configureLocalCertificateBundle(): void
    {
        if (PHP_OS_FAMILY !== 'Windows' || ini_get('curl.cainfo') || ini_get('openssl.cafile')) {
            return;
        }

        $candidates = array_filter([
            env('CLOUDINARY_CA_BUNDLE'),
            'C:/Program Files/Git/mingw64/etc/ssl/certs/ca-bundle.crt',
            'C:/xampp/apache/bin/curl-ca-bundle.crt',
        ]);

        foreach ($candidates as $certificateBundle) {
            if (is_file($certificateBundle)) {
                putenv('CURL_CA_BUNDLE='.$certificateBundle);
                putenv('SSL_CERT_FILE='.$certificateBundle);

                break;
            }
        }
    }
}
