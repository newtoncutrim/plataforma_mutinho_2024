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
        $response = $this->repositoy->all();
        if ($response) {
            return ['status' => true, 'data' => $response, 'code' =>  200];
        }

        return ['status' => false, 'data' => $response, 'code' =>  400];
    }

    public function getCustomer($id)
    {
        $response = $this->repositoy->find($id);
        if ($response) {
            return ['status' => true, 'data' => $response, 'code' =>  200];
        }

        return ['status' => false, 'data' => $response, 'code' =>  400];
    }

    public function getTimeline($id){
        $customer = $this->repositoy->find($id);
        $response = $this->repositoy->getTimeline($id);
        if (!$customer) {
            return ['status' => false, 'data' => 'Cliente não encontrado.', 'code' =>  400];
        }
        if ($response) {
            return ['status' => true, 'data' => $response, 'code' =>  200];
        }

        return ['status' => false, 'data' => $response, 'code' =>  400];
    }
    public function createCustomer(array $data)
    {
        $response = $this->repositoy->create($data);
        if ($response) {
            return ['status' => true, 'data' => $response, 'code' =>  201];
        }

        return ['status' => false, 'data' => $response, 'code' =>  400];
    }

    public function updateCustomer($id, array $data)
    {
        $response = $this->repositoy->update($data, $id);
        if ($response) {
            return ['status' => true, 'data' => $response, 'code' =>  200];
        }

        return ['status' => false, 'data' => $response, 'code' =>  400];
    }

    public function deleteCustomer($id)
    {
        $response = $this->repositoy->delete($id);
        if ($response) {
            return ['status' => true, 'data' => $response, 'code' =>  200];
        }

        return ['status' => false, 'data' => $response, 'code' =>  400];
    }
}