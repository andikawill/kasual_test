<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GoogleDriveServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \Storage::extend('google', function($app) {
            $client = new \Google_Client();
            $client->setAuthConfig(config("google.service.file"));
            $client->setClientId(config("google.client_id"));
            $client->setClientSecret(config("google.client_secret"));
            $client->refreshToken(config("google.refreshToken"));
            $client->fetchAccessTokenWithRefreshToken(config("google.refreshToken"));
            // $access_token = $client->getAccessToken();
            $service = new \Google_Service_Drive($client);
            $adapter = new \Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter($service, config("google.GOOGLE_DRIVE_FOLDER_ID"));

            return new \League\Flysystem\Filesystem($adapter);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
