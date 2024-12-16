<?php
namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Display the listing page
    public function index()
    {
        $services = Service::with('category')->paginate(10); // Eager load category relationship
        return view('services.index', compact('services'));
    }

    // Display the form for creating a new service
    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        return view('services.create', compact('categories')); // Pass to the view
    }

    // Store a newly created service in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'estimated_time' => 'required',
            'start_time' => 'required',
            'service_cost' => 'required',
            'actual_cost' => 'required|numeric|min:0',
        ]);

        // Handle file uploads (thumbnail)
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $thumbnailPath = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('thumbnails'), $thumbnailPath);
        }

        // Handle multiple image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $imagePaths[] = $imageName;
            }
        }

        // Create the service
        Service::create([
            'service_name' => $request->service_name,
            'description' => $request->description,
            'thumbnail' => $thumbnailPath,
            'images' => json_encode($imagePaths), // Store images as JSON
            'category_id' => $request->category_id,
            'estimated_time' => $request->estimated_time,
            'start_time' => $request->start_time,
            'service_cost' => $request->service_cost,
            'actual_cost' => $request->actual_cost,
        ]);

        // Redirect with success message
        return redirect()->route('services.create')->with('success', 'Service created successfully!');
    }

    

    // Show the edit form
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('services.edit', compact('service'));
    }

    // Update the service
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'service_cost' => 'required|numeric|min:0',
        ]);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $service->thumbnail = $thumbnailPath;
        }

        // Update the service
        $service->update([
            'service_name' => $request->service_name,
            'description' => $request->description,
            'service_cost' => $request->service_cost,
        ]);

        return redirect()->route('services.index')->with('success', 'Service updated successfully!');
    }

    // Delete the service
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully!');
    }
}
