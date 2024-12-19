<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\Lead;

class LeadController extends Controller
{
    public function store(StoreLeadRequest $request)
{
    // Log the validated data
    logger($request->all());
    logger('Validated:', $request->validated());

    // Attempt to create a record
    $lead = Lead::create($request->validated());

    if ($lead) {
        logger('Lead created successfully:', $lead->toArray());
        return redirect()->back()->with('success', 'Your inquiry was submitted successfully.');
    }

    logger('Failed to save lead record.');
    return redirect()->back()->with('error', 'Failed to submit your inquiry.');
}
}