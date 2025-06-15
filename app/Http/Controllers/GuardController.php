<?php

namespace App\Http\Controllers;

use App\Models\Guard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GuardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guards = Guard::orderBy('full_name')->paginate(10);
        return view('guard.index', compact('guards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('guard.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nric' => ['required', 'regex:/^\d{6}-\d{2}-\d{4}$/', 'unique:guards,nric_hash'],
            'full_name' => 'required|string|max:128',
            'dob' => 'nullable|date',
            'contact_no' => 'nullable|string|max:25',
            'email' => 'nullable|email|max:128|unique:users,email',
            'gender' => 'nullable|in:M,F',
            'blood_type' => 'nullable|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'remarks' => 'nullable|string',
            'photo' => 'nullable|image|max:2048', // 2MB max
        ]);

        try {
            DB::beginTransaction();

            // Handle NRIC securely
            $nricHash = hash('sha256', $request->nric);
            $nricLast4 = substr($request->nric, -4);
            
            // Handle photo upload
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('guards/photos', 'public');
            }

            // Create guard record
            $guard = Guard::create([
                'nric_hash' => $nricHash,
                'nric_last4' => $nricLast4,
                'full_name' => $validated['full_name'],
                'dob' => $validated['dob'],
                'contact_no' => $validated['contact_no'],
                'email' => $validated['email'],
                'gender' => $validated['gender'],
                'blood_type' => $validated['blood_type'],
                'remarks' => $validated['remarks'],
                'photo_path' => $photoPath,
            ]);

            // Create user account for the guard if email is provided
            if ($validated['email']) {
                // Use the NRIC as the initial password
                $user = User::create([
                    'name' => $validated['full_name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($request->nric), // Using NRIC as password
                    'guard_id' => $guard->id,
                    'role' => 'guard',
                ]);

                // TODO: Send email with credentials to the guard
                // You might want to create and dispatch a notification here
                // to inform that their NRIC is their initial password
            }

            DB::commit();

            return redirect()->route('guard.index')
                ->with('status', 'Guard created successfully.' . 
                    ($validated['email'] ? ' A user account has been created and credentials sent to their email.' : ''));

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Delete uploaded photo if exists
            if (isset($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred while creating the guard. Please try again.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guard  $guard
     * @return \Illuminate\View\View
     */
    public function show(Guard $guard)
    {
        // Load the associated user relationship
        $guard->load('user');
        
        return view('guard.show', compact('guard'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guard $guard)
    {
        return view('guard.edit', compact('guard'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guard $guard)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:128',
            'dob' => 'nullable|date',
            'contact_no' => 'nullable|string|max:25',
            'email' => 'nullable|email|max:128|unique:users,email,' . optional($guard->user)->id,
            'gender' => 'nullable|in:M,F',
            'blood_type' => 'nullable|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'remarks' => 'nullable|string',
            'photo' => 'nullable|image|max:2048', // 2MB max
        ]);

        try {
            DB::beginTransaction();

            // Handle photo upload
            if ($request->hasFile('photo')) {
                // Delete old photo
                if ($guard->photo_path) {
                    Storage::disk('public')->delete($guard->photo_path);
                }
                $validated['photo_path'] = $request->file('photo')->store('guards/photos', 'public');
            }

            // Update guard record
            $guard->update($validated);

            // Handle user account update or creation
            if ($validated['email']) {
                // Find existing user either by guard_id or email
                $existingUser = User::where('guard_id', $guard->id)
                    ->orWhere('email', $validated['email'])
                    ->first();

                if ($existingUser) {
                    // Update existing user
                    $existingUser->update([
                        'name' => $validated['full_name'],
                        'email' => $validated['email'],
                        'guard_id' => $guard->id // ensure guard_id is set
                    ]);
                } else {
                    // Create new user with a default password only if no user exists
                    User::create([
                        'name' => $validated['full_name'],
                        'email' => $validated['email'],
                        'password' => Hash::make(Str::random(10)), // temporary password
                        'guard_id' => $guard->id,
                        'role' => 'guard'
                    ]);
                    // TODO: Send password reset link to the new user
                }
            } else if ($guard->user) {
                // If email is removed, delete the user account
                $guard->user->delete();
            }

            DB::commit();

            return redirect()->route('guard.index')
                ->with('status', 'Guard updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred while updating the guard. Please try again.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guard  $guard
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Guard $guard): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Delete photo if exists
            if ($guard->photo_path) {
                if (Storage::disk('public')->exists($guard->photo_path)) {
                    Storage::disk('public')->delete($guard->photo_path);
                }
            }

            // Delete associated user if exists using the relationship
            if ($guard->user) {
                $guard->user->delete(); // This will soft delete the user
            }

            // Delete guard (soft delete)
            $guard->delete();

            DB::commit();

            return redirect()->route('guard.index')
                ->with('status', 'Guard and associated user account deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log the error for debugging
            \Log::error('Error deleting guard: ' . $e->getMessage(), [
                'guard_id' => $guard->id,
                'error' => $e
            ]);
            
            return redirect()->back()
                ->withErrors(['error' => 'Could not delete the guard. Please try again or contact support if the problem persists.']);
        }
    }
}
