<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Response;

class ProblemController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 25);
        
        $query = Problem::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $problems = $query->orderBy('id', 'desc')
            ->paginate($perPage)
            ->appends($request->except('page'));
        
        return view('problems.index', compact('problems', 'search'));
    }

    public function create(): View
    {
        return view('problems.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Problem::create($validated);

        return redirect('/problems')->with('success', 'Problem created successfully!');
    }

    public function show($id): View
    {
        $problem = Problem::findOrFail($id);
        return view('problems.show', compact('problem'));
    }

    public function edit($id): View
    {
        $problem = Problem::findOrFail($id);
        return view('problems.edit', compact('problem'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $problem = Problem::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $problem->update($validated);

        return redirect('/problems')->with('success', 'Problem updated successfully!');
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $problem = Problem::findOrFail($id);
            $problem->delete();
            
            return redirect('/problems')->with('success', 'Problem deleted successfully!');
        } catch (\Exception $e) {
            return redirect('/problems')->with('error', 'Error deleting problem. Please try again.');
        }
    }

    public function autocomplete(Request $request)
    {
        $term = $request->input('term', '');
        $problems = Problem::where('name', 'like', "%{$term}%")
            ->limit(10)
            ->get();
        
        return response()->json([
            'success' => true, 
            'data' => $problems
        ]);
    }

    // API methods (JSON)
    public function apiIndex(): JsonResponse
    {
        $problems = Problem::all();
        return response()->json(['success' => true, 'data' => $problems]);
    }

    public function apiStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $problem = Problem::create($validated);

        return response()->json(['success' => true, 'data' => $problem], 201);
    }

    public function apiShow($id): JsonResponse
    {
        $problem = Problem::find($id);
        
        if (!$problem) {
            return response()->json(['success' => false, 'message' => 'Problem not found'], 404);
        }
        
        return response()->json(['success' => true, 'data' => $problem]);
    }

    public function apiUpdate(Request $request, $id): JsonResponse
    {
        $problem = Problem::find($id);
        
        if (!$problem) {
            return response()->json(['success' => false, 'message' => 'Problem not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
        ]);

        $problem->update($validated);

        return response()->json(['success' => true, 'data' => $problem]);
    }

    public function apiDestroy($id): JsonResponse
    {
        $problem = Problem::find($id);
        
        if (!$problem) {
            return response()->json(['success' => false, 'message' => 'Problem not found'], 404);
        }

        $problem->delete();

        return response()->json(['success' => true, 'message' => 'Problem deleted successfully']);
    }
}