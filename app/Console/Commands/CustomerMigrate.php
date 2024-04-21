<?php

namespace App\Console\Commands;
use App\Services\CustomerManager;
use App\Models\Customer;
use Illuminate\Console\Command;

class CustomerMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer:migrate';
    
    protected $customerManager;
 
    protected $migrator;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate customer databases';

    public function __construct(CustomerManager $customerManager) {
        parent::__construct();
 
        $this->customerManager = $customerManager;
        $this->migrator = app('migrator');
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $customers = Customer::all();
        foreach ($customers as $customer) {
            $this->customerManager->setCustomer($customer);
            \DB::purge('customer');
            $this->migrate();
        }
    }

    private function migrate() {
        $this->prepareDatabase();
        $this->migrator->run(database_path('migrations/customer'), []);
    }
 
    protected function prepareDatabase() {
        $this->migrator->setConnection('customer');
 
        if (! $this->migrator->repositoryExists()) {
            $this->call('migrate:install');
        }
    }
}
