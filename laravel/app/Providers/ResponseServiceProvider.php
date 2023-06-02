<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * necessário colocar no app.php em Application Service Providers
         */


        Response::macro('success', function ($data) {
        

            $response = [
                "status" => 'success',
                "data" => $data
            ];
            
            return Response::json($response, 200);
        });

        Response::macro('error', function ($error) {
        

            $response = [
                "status" => 'error',
                "error" => $error
            ];
            
            // return Response::json($response, $code);
            return Response::json($response);
        });
    }
}
