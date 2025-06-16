<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function store(Request $request)
    {
        $form = Form::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'name' => $request->input('name'),
            'submit_message' => $request->input('submitMessage'),
            'logo' => $request->input('logo'), // base64 or URL
            'fields' => json_encode($request->input('fields')),
        ]);

        return response()->json(['id' => $form->id], 201);
    }

    public function show($id)
    {
        $form = Form::findOrFail($id);
        return response()->json($form);
    }
}
