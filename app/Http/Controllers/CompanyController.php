<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $companies = Company::paginate(10);
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'name' => 'required|unique:companies,name',
            'license_no' => 'required|unique:companies,license_no',
            'license_expiry' => 'required|date',
            'status' => 'required|in:active,expired,suspended',
            'address' => 'nullable|string',
        ]);

        Company::create($validated);

        return redirect()->route('company.index')
            ->with('status', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        //
        $validated = $request->validate([
            'name' => 'required|unique:companies,name,' . $company->id,
            'license_no' => 'required|unique:companies,license_no,' . $company->id,
            'license_expiry' => 'required|date',
            'status' => 'required|in:active,expired,suspended',
            'address' => 'nullable|string',
        ]);

        $company->update($validated);

        return redirect()->route('company.index')
            ->with('status', 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
        $company->delete();
        return redirect()->route('company.index')
            ->with('status', 'Company deleted successfully.');
    }
}
