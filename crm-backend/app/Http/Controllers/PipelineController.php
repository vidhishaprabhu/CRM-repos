<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PipelineController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'deal_title' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'deal_value' => 'required|numeric',
            'expected_close_date' => 'required|date',
            'sales_stage' => 'required|string|max:255',
            'assigned_to' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);
        $pipeline = new Pipeline();
        $pipeline->deal_title = $request->deal_title;
        $pipeline->customer_name = $request->customer_name;
        $pipeline->deal_value = $request->deal_value;
        $pipeline->expected_close_date = $request->expected_close_date;
        $pipeline->sales_stage = $request->sales_stage;
        $pipeline->assigned_to = $request->assigned_to;
        $pipeline->notes = $request->notes;
        $pipeline->save();

        return response()->json(['message' => 'Pipeline entry created successfully', 'data' => $pipeline], 201);
    }
}
