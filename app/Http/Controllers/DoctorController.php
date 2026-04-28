<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'degrees' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Doctor::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'degrees' => $request->degrees ? json_encode($request->degrees) : null,
            'email_verified' => false,
        ]);

        return redirect('/doctors')->with('success', 'Doctor created successfully!');
    }

    public function show($id): View
    {
        $doctor = Doctor::findOrFail($id);
        return view('doctors.show', compact('doctor'));
    }

    public function edit($id): View
    {
        $doctor = Doctor::findOrFail($id);
        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $doctor = Doctor::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'degrees' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $doctor->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'degrees' => $request->degrees ? json_encode($request->degrees) : null,
        ]);

        return redirect('/doctors')->with('success', 'Doctor updated successfully!');
    }

    public function destroy($id): RedirectResponse
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return redirect('/doctors')->with('success', 'Doctor deleted successfully!');
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
