<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('different_airports', function ($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            $originField = $parameters[0];
            return isset($data[$originField]) && $value !== $data[$originField];
        });

        Validator::replacer('different_airports', function ($message, $attribute, $rule, $parameters) {
            return "قم باختيار مطار وصول مختلف";
        });
    }
}

