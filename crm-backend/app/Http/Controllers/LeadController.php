<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function store(Request $request){
        $validated=$request->validate([
            'full_name'=>'required|string|max:255',
            'email'=>'required|email|max:255',
            'phone'=>'required|digits:10',
            'company'=>'required|string',
            'job_title'=>'required|string|max:255',
            'lead_source'=>'required|in:Website,Referral,Social,Media,Event,Other',
            'status'=>'required|in:New,Contacted,Qualified,Lost',
            'assigned_to'=>'required|string|max:255',
            'notes'=>'nullable|string',
        ],[
        'full_name.required' => 'Please enter the full name.',
        'email.required'=>'Please enter the email',
        'phone'=>'Please enter the phone number',
        'phone.max'=>'Phone number should be maximum 10 digits',
        'company'=>'Please enter the name of the company',
        'job-title'=>'Please enter the job-title',
        'lead-source'=>'Please enter the lead-source',
        'status'=>'Please enter the status',
        'assigned-to'=>'Please eneter the assigned-to field',
        'notes'=>'Please enter the notes'    
    ]);
        $lead = new Lead();
        $lead->full_name = $request->full_name;
        $lead->email = $request->email;
        $lead->phone = $request->phone;
        $lead->company = $request->company;
        $lead->job_title = $request->job_title;
        $lead->lead_source = $request->lead_source;
        $lead->status = $request->status;
        $lead->assigned_to = $request->assigned_to;
        $lead->notes = $request->notes;
        $lead->save();

    return response()->json([
        'message' => 'Lead entry created successfully',
        'data' => $lead
    ], 201);
}
}