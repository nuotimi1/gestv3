<?php

namespace App\Providers;
use App\Services\CustomerManager;
use App\Models\Customer;
use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $manager = new CustomerManager;
 
        $this->app->instance(CustomerManager::class, $manager);
        $this->app->bind(Customer::class, function () use ($manager) {
            return $manager->getCustomer();
        });

        $this->app['db']->extend('customer', function ($config, $name) use ($manager) {
            $customer = $manager->getCustomer();
         
            if ($customer) {
                $config['database'] = 'customer_' . $customer->slug;
            }
         
            return $this->app['db.factory']->make($config, $name);
        });

 
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
