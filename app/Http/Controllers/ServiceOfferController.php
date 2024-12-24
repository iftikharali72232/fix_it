<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceOffer;
use Illuminate\Support\Facades\Storage;

class ServiceOfferController extends Controller
{
    public function index()
    {
        $serviceOffers = ServiceOffer::all();
        return view('service_offers.index', compact('serviceOffers'));
    }

    public function create()
    {
        return view('service_offers.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'service_id' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'discount' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $imagePath = $request->file('image')->store('service_offers', 'public');

        ServiceOffer::create([
            'service_id' => $validatedData['service_id'],
            'image' => $imagePath,
            'discount' => $validatedData['discount'],
            'status' => $validatedData['status'],
        ]);

        return redirect()->route('service_offers.index')->with('success', 'Service Offer added successfully!');
    }

    public function edit(ServiceOffer $serviceOffer)
    {
        return view('service_offers.edit', compact('serviceOffer'));
    }

    public function update(Request $request, ServiceOffer $serviceOffer)
    {
        $validatedData = $request->validate([
            'service_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'discount' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($serviceOffer->image);
            // Upload new image
            $serviceOffer->image = $request->file('image')->store('service_offers', 'public');
        }

        $serviceOffer->update([
            'service_id' => $validatedData['service_id'],
            'image' => $serviceOffer->image, // Keep old image if not updated
            'discount' => $validatedData['discount'],
            'status' => $validatedData['status'],
        ]);

        return redirect()->route('service_offers.index')->with('success', 'Service Offer updated successfully!');
    }

    public function destroy(ServiceOffer $serviceOffer)
    {
        Storage::disk('public')->delete($serviceOffer->image);
        $serviceOffer->delete();

        return redirect()->route('service_offers.index')->with('success', 'Service Offer deleted successfully!');
    }
}
