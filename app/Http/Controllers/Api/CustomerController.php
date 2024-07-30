<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $service;
    public function __construct(CustomerService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
    }
}
