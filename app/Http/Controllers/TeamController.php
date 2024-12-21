<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    // List all teams
    public function index()
    {
        $teams = Team::with('category')->get(); // Eager load category
        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        return view('teams.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);
    
        Team::create($validated);
        return redirect()->route('teams.index')->with('success', 'Team added successfully.');
    }
    
    // Show edit form
    public function edit($id)
    {
        $team = Team::findOrFail($id);
        $categories = Category::all(); // Fetch all categories for dropdown
        return view('teams.edit', compact('team', 'categories'));
    }


    // Update team
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);
    
        $team = Team::findOrFail($id);
        $team->update($validated);
    
        return redirect()->route('teams.index')->with('success', 'Team updated successfully.');
    }
    

    // Delete team
    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();
        return redirect()->route('teams.index')->with('success', 'Team deleted successfully.');
    }
}
