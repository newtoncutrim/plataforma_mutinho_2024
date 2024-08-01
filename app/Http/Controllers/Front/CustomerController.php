<?php

namespace App\Http\Controllers\Front;

use App\Clients;
use App\TimeLineClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{

    public function index(Request $request)
    {
        $data = $request->all();

        $customer = Clients::where('id', $data['id'])->first();
        $timelines = TimeLineClient::where('client_id', $customer->id)->paginate(10);
        return view('front.customer.index', compact('customer', 'timelines'));
    }

    public function timeline(Request $request)
    {
        $data = $request->all();
        $customer = Clients::where('id', $data['id'])->first();
        $timelines = TimeLineClient::where('client_id', $customer->id)->paginate(10);
        return view('front.customer.about', compact( 'timelines'));
    }
}
