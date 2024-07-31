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
        $data = $this->service->getCustomers();
        if($data['status']){
            return response()->json($data['data'], $data['code']);
        }
        return response()->json($data['data'], $data['code']);

    }

    public function show($id)
    {
        $data = $this->service->getTimeline($id);
        if($data['status']){
            return response()->json($data['data'], $data['code']);
        }
        return response()->json($data['data'], 400);
    }
}
