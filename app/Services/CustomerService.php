<?php

namespace App\Services;
use App\Repositories\CustomerRepository;

class CustomerService {

    protected $repositoy;
    public function __construct(CustomerRepository $repositoy)
    {
        $this->repositoy = $repositoy;
    }

    public function getCustomers()
    {
        return $this->repositoy->all();
    }

    public function getCustomer($id)
    {
        return $this->repositoy->find($id);
    }

    public function createCustomer(array $data)
    {
        return $this->repositoy->create($data);
    }

    public function updateCustomer($id, array $data)
    {
        return $this->repositoy->update($id, $data);
    }

    public function deleteCustomer($id)
    {
        return $this->repositoy->delete($id);
    }
}