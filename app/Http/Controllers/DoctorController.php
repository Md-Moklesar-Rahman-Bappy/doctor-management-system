<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): View
    {
        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 25);

        $query = Doctor::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        }

        $doctors = $query->orderBy('id', 'desc')->paginate($perPage)->appends($request->except('page'));

        return view('doctors.index', compact('doctors', 'search'));
    }

    public function create(): View
    {
        return view('doctors.create');
    }

    public function store(StoreDoctorRequest $request): RedirectResponse
    {
        Doctor::create($request->validated() + ['user_id' => auth()->id(), 'email_verified' => false]);

        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully!');
    }

    public function show($id): View
    {
        $doctor = Doctor::findOrFail($id);

        // Authorization check
        if ($doctor->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('doctors.show', compact('doctor'));
    }

    public function edit($id): View
    {
        $doctor = Doctor::findOrFail($id);

        // Authorization check
        if ($doctor->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('doctors.edit', compact('doctor'));
    }

    public function update(UpdateDoctorRequest $request, $id): RedirectResponse
    {
        $doctor = Doctor::findOrFail($id);

        // Authorization check
        if ($doctor->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $doctor->update($request->validated());

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully!');
    }

    public function destroy($id): RedirectResponse
    {
        $doctor = Doctor::findOrFail($id);

        // Authorization check
        if ($doctor->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $doctor->delete();

        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully!');
    }

    public function search(Request $request)
    {
        $term = $request->input('term', '');
        $doctors = Doctor::where('name', 'like', "%{$term}%")
            ->orWhere('email', 'like', "%{$term}%")
            ->orWhere('phone', 'like', "%{$term}%")
            ->limit(10)
            ->get();

        return response()->json(['success' => true, 'data' => $doctors]);
    }
}
