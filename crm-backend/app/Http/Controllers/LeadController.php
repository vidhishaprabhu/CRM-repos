<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function store(Request $request){
        $validated=$request->validated([
            'full_name'=>'required|string|max:255',
            'email'=>'required|email|max:255',
            'phone'=>'required|email|max:10',
            'company'=>'required|str',
            'job_title'=>'required|string|max:255',
            'lead_source'=>'required|in:Website,Referral,Social,Media,Event,Other',
            'status'=>'required|in:New,COntacted,Qualified,Lost',
            'assigned_to'=>'required|string|max:255',
            'notes'=>'nullable|string',
        ]);
        $lead = Lead::create($validated);
        return response()->json($lead,201);
    }
}
