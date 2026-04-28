<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProblemController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 25);

        $query = Problem::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
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

    public function store(StoreProblemRequest $request): RedirectResponse
    {
        Problem::create($request->validated());

        return redirect()->route('problems.index')->with('success', 'Problem created successfully!');
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

    public function update(UpdateProblemRequest $request, $id): RedirectResponse
    {
        $problem = Problem::findOrFail($id);

        $problem->update($request->validated());

        return redirect()->route('problems.index')->with('success', 'Problem updated successfully!');
    }

    public function destroy($id): RedirectResponse
    {
        $problem = Problem::findOrFail($id);

        // Authorization check - only superadmin can delete
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized action.');
        }

        try {
            $problem->delete();

            return redirect()->route('problems.index')->with('success', 'Problem deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('problems.index')->with('error', 'Error deleting problem. Please try again.');
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
            'data' => $problems,
        ]);
    }

    // API methods (JSON)
    public function apiIndex(): JsonResponse
    {
        $problems = Problem::all();

        return response()->json(['success' => true, 'data' => $problems]);
    }

    public function apiStore(StoreProblemRequest $request): JsonResponse
    {
        $problem = Problem::create($request->validated());

        return response()->json(['success' => true, 'data' => $problem], 201);
    }

    public function apiShow($id): JsonResponse
    {
        $problem = Problem::find($id);

        if (! $problem) {
            return response()->json(['success' => false, 'message' => 'Problem not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $problem]);
    }

    public function apiUpdate(UpdateProblemRequest $request, $id): JsonResponse
    {
        $problem = Problem::find($id);

        if (! $problem) {
            return response()->json(['success' => false, 'message' => 'Problem not found'], 404);
        }

        $problem->update($request->validated());

        return response()->json(['success' => true, 'data' => $problem]);
    }

    public function apiDestroy($id): JsonResponse
    {
        $problem = Problem::find($id);

        if (! $problem) {
            return response()->json(['success' => false, 'message' => 'Problem not found'], 404);
        }

        $problem->delete();

        return response()->json(['success' => true, 'message' => 'Problem deleted successfully']);
    }
}
