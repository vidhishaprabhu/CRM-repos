<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(){
        return Client::all();
    }
    public function store(Request $request){
        $validated=Client::validate([
            'company_name'=>'required|string',
            'client_code'=>'required|string|unique:clients',
            'conatact_person'=>'required|string',
            'designation'=>'nullable|string',
            'client_type'=>'nullable|string',
            'industry'=>'nullable|string',
            'business_size'=>'nullable|string',
            'website'=>'nullable|string',
            'tax_id'=>'nullable|string',
            'logo_path'=>'nullable|string'
        ]);
        $client=Client::created($validated);
        return response()->json(['message'=>'Client created successfully','client'=>$client]);
    }
}
