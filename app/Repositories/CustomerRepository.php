<?php

namespace App\Repositories;

use App\Clients;
use App\Repositories\Contract\AbstractRepository;

class CustomerRepository extends AbstractRepository
{
    public function __construct()
    {
        $this->model = new Clients();
    }

    public function getTimeline($id)
    {
        return $this->model->with('timeline')->where('id', $id)->first();

    }
}