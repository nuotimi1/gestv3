<?php 
namespace App\Services;
 
use App\Models\Customer;
 
class CustomerManager {
    /*
     * @var null|App\Customer
     */
     private $customer;
 
    public function setCustomer(?Customer $customer) {
        $this->customer = $customer;
        return $this;
    }
 
    public function getCustomer(): ?Customer {
        return $this->customer;
    }
 
    public function loadCustomer(string $identifier): bool {
        $customer = Customer::query()->where('slug', '=', $identifier)->first();
     
        if ($customer) {
            $this->setCustomer($customer);
            return true;
        }
     
        return false;
    }
 }