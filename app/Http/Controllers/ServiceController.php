<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of services (frontend).
     */
    public function index()
    {


              // Fetch all active services
      $services = Service::where('status', true)->get();

      return view('services.index', compact('services'));
    }


      // Display a single service
  public function show(Service $service)
  {
      // Return the service details view
      return view('services.show', compact('service'));
  }

    /**
     * Show the form for creating a new service (backend).
     */
    public function create()
    {
        // Return a view for creating a new service (backend admin page)
        return view('services.create');
    }

    /**
     * Store a newly created service in the database.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'duration' => 'nullable|integer',
            'service_type' => 'nullable|string|max:255',
            'target_audience' => 'nullable|string|max:255',
            'deliverables' => 'nullable|string',
            'status' => 'boolean',
        ]);

        // Create a new service record
        Service::create($validated);

        // Redirect to the services index page with success message
        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service)
    {
        // Return the edit view with the current service data
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified service in the database.
     */
    public function update(Request $request, Service $service)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'duration' => 'nullable|integer',
            'service_type' => 'nullable|string|max:255',
            'target_audience' => 'nullable|string|max:255',
            'deliverables' => 'nullable|string',
            'status' => 'boolean',
        ]);

        // Update the service record
        $service->update($validated);

        // Redirect to the services index page with success message
        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified service from the database.
     */
    public function destroy(Service $service)
    {
        // Delete the service record
        $service->delete();

        // Redirect to the services index page with success message
        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }
}